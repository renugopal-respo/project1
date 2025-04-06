<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Database connection parameters
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "project";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get parameters
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$filter = isset($_GET['filter']) ? strtolower(trim($_GET['filter'])) : 'all';
$price = isset($_GET['price']) ? strtolower(trim($_GET['price'])) : '';
$isDropdown = isset($_GET['dropdown']);

// Handle dropdown suggestions (live search)
if ($isDropdown) {
    $stmt = $conn->prepare("SELECT DISTINCT location FROM properties WHERE location LIKE ? LIMIT 10");
    $searchParam = "%$search%";
    $stmt->bind_param("s", $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();

    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row['location'];
    }
    echo json_encode($locations);
    exit;
}

// Base query
$query = "SELECT * FROM properties WHERE location LIKE ?";
$types = "s";
$params = ["%$search%"];

// Apply filter based on the 'filter' parameter
switch($filter) {
    case 'rent':
        $query .= " AND rent_sale = 'rent'";
        break;
    case 'buy':
        $query .= " AND rent_sale = 'sale'";
        break;
    case 'house':
    case 'land':
    case 'storehouse':
        $query .= " AND type = ?";
        $types .= "s";
        $params[] = $filter;
        break;
    // You can add more filter cases here if needed
}

// For property type filters, ensure both rent and sale properties are included
if (in_array($filter, ['house', 'land', 'storehouse'])) {
    $query .= " AND rent_sale IN ('rent', 'sale')";
}

// Apply price sorting if set via the 'price' parameter
if ($price) {
    if ($price === 'price_low_high') {
        $query .= " ORDER BY amount ASC";
    } elseif ($price === 'price_high_low') {
        $query .= " ORDER BY amount DESC";
    }
} else {
    // Default sorting if no price parameter is provided
    $query .= " ORDER BY amount ASC";
}

// Prepare and execute the query
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

if ($types !== "s" || count($params) > 1) {
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param($types, $params[0]);
}

$stmt->execute();
$result = $stmt->get_result();

$properties = [];
while ($row = $result->fetch_assoc()) {
    // Format amount as a number with commas (e.g. 250,000)
    $row['amount'] = number_format($row['amount']);
    $properties[] = $row;
}

// Output the properties as JSON
echo json_encode($properties);

$conn->close();
?>
