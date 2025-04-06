<?php 
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Start output buffering to ensure clean JSON output.
ob_start();

// Set headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Database configuration
$dbHost   = 'localhost';
$dbUser   = 'root';
$dbPass   = '';
$dbName   = 'project';
$dbPort   = 3306;

// Establish a connection using mysqli_connect
$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
if (!$connection) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        'success' => false,
        'error'   => 'Database connection failed: ' . mysqli_connect_error()
    ]);
    exit;
}

// Retrieve request parameters
$search      = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$filter      = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'all';
$priceSort   = filter_input(INPUT_GET, 'price', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$dropdownMode = filter_input(INPUT_GET, 'dropdown', FILTER_VALIDATE_BOOLEAN);

// Build the base query
$query = "SELECT property_type, location, location_id, water_source, total_area, address, price, description, image1 
          FROM land_properties 
          WHERE 1=1";
$params = [];
$types  = "";

// Add search filter
if (!empty($search)) {
    $query .= " AND (location LIKE ? OR address LIKE ? OR description LIKE ?)";
    $searchTerm = "%" . $search . "%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "sss";
}

// Allowed property types now match filter button values from HTML.
$allowedPropertyTypes = ['agricultureland', 'plot'];

if ($filter !== 'all' && in_array($filter, $allowedPropertyTypes, true)) {
    $query .= " AND property_type = ?";
    $params[] = $filter;
    $types .= "s";
}

// Add sorting by price if specified
$validSorts = [
    'price_low_high' => 'ASC',
    'price_high_low' => 'DESC'
];

if (array_key_exists($priceSort, $validSorts)) {
    $query .= " ORDER BY price " . $validSorts[$priceSort];
}

// Prepare the statement
$stmt = mysqli_prepare($connection, $query);
if (!$stmt) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        'success' => false,
        'error'   => 'Statement preparation failed: ' . mysqli_error($connection)
    ]);
    exit;
}

// Bind parameters if any
if (!empty($params)) {
    $bindParams = [];
    $bindParams[] = $types;
    for ($i = 0; $i < count($params); $i++) {
        $bindParams[] = &$params[$i];
    }
    call_user_func_array('mysqli_stmt_bind_param', array_merge([$stmt], $bindParams));
}

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        'success' => false,
        'error'   => 'Statement execution failed: ' . mysqli_stmt_error($stmt)
    ]);
    exit;
}

// Get the result set
$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    http_response_code(500);
    ob_clean();
    echo json_encode([
        'success' => false,
        'error'   => 'Failed to get result: ' . mysqli_error($connection)
    ]);
    exit;
}

// Handle dropdown mode for suggestions
if ($dropdownMode) {
    $suggestions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row['location'];
    }
    $uniqueSuggestions = array_values(array_unique($suggestions));
    ob_clean();
    echo json_encode($uniqueSuggestions);
    exit;
}

// Build the properties array
$properties = [];
while ($row = mysqli_fetch_assoc($result)) {
    $properties[] = [
        'property_type' => $row['property_type'],
        'location'      => $row['location'],
        'location_id'   => $row['location_id'],
        'water_source'  => $row['water_source'],
        'total_area'    => $row['total_area'],
        'address'       => $row['address'],
        'price'         => $row['price'],
        'description'   => $row['description'],
        'image1'        => $row['image1']
    ];
}

// Clear any previous output and echo the JSON response
ob_clean();
echo json_encode($properties);

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
