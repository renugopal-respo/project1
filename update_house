<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch locations
$locationQuery = "SELECT location_id, location_name FROM location_details";
$locationResult = mysqli_query($conn, $locationQuery);

// Initialize properties array
$properties = [];

if (isset($_POST['location_id']) && !empty($_POST['location_id'])) {
    $selected_location = mysqli_real_escape_string($conn, $_POST['location_id']);

    // Fetch properties for the selected location
    $propertyQuery = "SELECT id, property_type, exact_address FROM properties WHERE location_id = '$selected_location'";
    $propertyResult = mysqli_query($conn, $propertyQuery);

    while ($row = mysqli_fetch_assoc($propertyResult)) {
        $properties[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Property</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Select Location</h1>
        <form method="POST">
            <label for="location_id">Select Location</label>
            <select name="location_id" id="location_id" onchange="this.form.submit()">
                <option value="">-- Select Location --</option>
                <?php while ($row = mysqli_fetch_assoc($locationResult)): ?>
                    <option value="<?php echo $row['location_id']; ?>" <?php if (isset($selected_location) && $selected_location == $row['location_id']) echo 'selected'; ?>>
                        <?php echo $row['location_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <?php if (!empty($properties)): ?>
            <h2>Available Properties</h2>
            <ul>
                <?php foreach ($properties as $property): ?>
                    <li>
                        <a href="edit_property.php?id=<?php echo $property['id']; ?>">
                            <?php echo "ID: " . $property['id'] . " | Type: " . $property['property_type'] . " | Address: " . $property['exact_address']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif (isset($selected_location)): ?>
            <p>No properties found for the selected location.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
