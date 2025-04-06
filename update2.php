<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch Property Details for Editing
if (isset($_GET['id'])) {
    $property_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM properties WHERE property_id = '$property_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $property = mysqli_fetch_assoc($result);
    } else {
        die("Property not found.");
    }
}

// Handle Update Operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $property_id = mysqli_real_escape_string($conn, $_POST['property_id']);
    $property_type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $bedrooms = mysqli_real_escape_string($conn, $_POST['bedrooms']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
    $water_source = mysqli_real_escape_string($conn, $_POST['water_source']);
    $facing = mysqli_real_escape_string($conn, $_POST['facing']);
    $balcony = mysqli_real_escape_string($conn, $_POST['balcony']);
    $parking = mysqli_real_escape_string($conn, $_POST['parking']);
    $possession = mysqli_real_escape_string($conn, $_POST['possession']);
    $rent_sale = mysqli_real_escape_string($conn, $_POST['rent_sale']);
    $exact_address = mysqli_real_escape_string($conn, $_POST['exact_address']);

    $update_sql = "UPDATE properties SET 
            property_type = '$property_type', 
            amount = '$amount', 
            bedrooms = '$bedrooms', 
            location = '$location', 
            water_source = '$water_source', 
            facing = '$facing', 
            location_id = '$location_id',
            balcony = '$balcony',
            parking = '$parking',
            possession = '$possession',
            rent_sale = '$rent_sale',
            exact_location = '$exact_address'
            WHERE property_id = '$property_id'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: success.php");
        exit();
    } else {
        $error_message = "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Property</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Update Property</h1>

        <form action="" method="POST">
            <input type="hidden" name="property_id" value="<?php echo $property['property_id']; ?>">

            <label for="exact_address">Exact Address</label>
            <input type="text" id="exact_address" name="exact_address" value="<?php echo $property['exact_location']; ?>" required maxlength="255" placeholder="Enter exact address">

            <label for="property_type">Property Type</label>
            <select id="property_type" name="property_type" required>
                <option value="apartment" <?php if ($property['property_type'] == 'apartment') echo 'selected'; ?>>Apartment</option>
                <option value="house" <?php if ($property['property_type'] == 'house') echo 'selected'; ?>>House</option>
                <option value="villa" <?php if ($property['property_type'] == 'villa') echo 'selected'; ?>>Villa</option>
            </select>

            <label for="amount">Amount (₹)</label>
            <input type="number" id="amount" name="amount" value="<?php echo $property['amount']; ?>" required min="1000" step="1000" placeholder="Enter price">

            <label for="bedrooms">Bedrooms</label>
            <input type="number" id="bedrooms" name="bedrooms" value="<?php echo $property['bedrooms']; ?>" required min="1" max="10">

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo $property['location']; ?>" required maxlength="100">

            <label for="location_id">Location ID</label>
            <input type="number" id="location_id" name="location_id" value="<?php echo $property['location_id']; ?>" required min="1">

            <label for="water_source">Water Source</label>
            <input type="text" id="water_source" name="water_source" value="<?php echo $property['water_source']; ?>" required>

            <label for="facing">Facing</label>
            <select id="facing" name="facing" required>
                <option value="north" <?php if ($property['facing'] == 'north') echo 'selected'; ?>>North</option>
                <option value="south" <?php if ($property['facing'] == 'south') echo 'selected'; ?>>South</option>
                <option value="east" <?php if ($property['facing'] == 'east') echo 'selected'; ?>>East</option>
                <option value="west" <?php if ($property['facing'] == 'west') echo 'selected'; ?>>West</option>
            </select>

            <label for="balcony">Balcony</label>
            <input type="number" id="balcony" name="balcony" value="<?php echo $property['balcony']; ?>" min="0" max="5">

            <label for="parking">Parking</label>
            <select id="parking" name="parking" required>
                <option value="yes" <?php if ($property['parking'] == 'yes') echo 'selected'; ?>>Yes</option>
                <option value="no" <?php if ($property['parking'] == 'no') echo 'selected'; ?>>No</option>
            </select>

            <label for="possession">Possession</label>
            <input type="date" id="possession" name="possession" value="<?php echo $property['possession']; ?>" required>

            <label for="rent_sale">For Rent or Sale?</label>
            <select id="rent_sale" name="rent_sale" required>
                <option value="rent" <?php if ($property['rent_sale'] == 'rent') echo 'selected'; ?>>Rent</option>
                <option value="sale" <?php if ($property['rent_sale'] == 'sale') echo 'selected'; ?>>Sale</option>
            </select>

            <button type="submit" name="update" class="submit-btn">Update Property</button>
        </form>
    </div>
</body>
</html>
