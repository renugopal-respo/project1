<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Property Details for Editing
$property = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $property = $result->fetch_assoc();
    } else {
        header("Location: error.php");
        exit();
    }
    $stmt->close();
}

// Handle Update Operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $property_type = $_POST['property_type'];
    $amount = $_POST['amount'];
    $bedrooms = $_POST['bedrooms'];
    $location = $_POST['location'];
    $location_id = $_POST['location_id'];
    $water_source = $_POST['water_source'];
    $facing = $_POST['facing'];
    $balcony = $_POST['balcony'];
    $parking = $_POST['parking'];
    $possession = $_POST['possession'];
    $rent_sale = $_POST['rent_sale'];
    $exact_address = $_POST['exact_address'];

    // Handle image uploads
    $image1 = uploadImage($_FILES['image1']);
    $image2 = uploadImage($_FILES['image2']);
    $image3 = uploadImage($_FILES['image3']);
    $image4 = uploadImage($_FILES['image4']);

    // If no new image is uploaded, retain the existing image
    if (!$image1) $image1 = $property['image1'];
    if (!$image2) $image2 = $property['image2'];
    if (!$image3) $image3 = $property['image3'];
    if (!$image4) $image4 = $property['image4'];

    $update_sql = "UPDATE properties SET 
            property_type = ?, 
            amount = ?, 
            bedrooms = ?, 
            location = ?, 
            water_source = ?, 
            facing = ?, 
            location_id = ?, 
            balcony = ?, 
            parking = ?, 
            possession = ?, 
            rent_sale = ?, 
            exact_address = ?, 
            image1 = ?, 
            image2 = ?, 
            image3 = ?, 
            image4 = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdiisssissssssssi", 
        $property_type, $amount, $bedrooms, $location, $water_source, 
        $facing, $location_id, $balcony, $parking, $possession, 
        $rent_sale, $exact_address, $image1, $image2, $image3, $image4, $id
    );

    if ($stmt->execute()) {
        header("Location: success.php");
        exit();
    } else {
        $error_message = "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

// Function to handle image upload
function uploadImage($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        }
    }
    return null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Property</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px; /* Increased width for two columns */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two columns */
            gap: 20px; /* Space between columns */
        }

        .form-section {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #555;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="number"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 8px; /* Reduced padding */
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px; /* Reduced font size */
            background-color: #fff;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        select {
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            background-size: 12px;
            padding-right: 30px;
        }

        .submit-btn {
            width: 100%;
            padding: 10px; /* Reduced padding */
            background: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 14px; /* Reduced font size */
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: #218838;
        }

        .error-message {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Update Property</h1>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if ($property): ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($property['id']); ?>">

            <!-- Property Details Section -->
            <div class="form-grid">
                <div class="form-section">
                    <h2>Property Details</h2>

                    <label for="exact_address">Exact Address</label>
                    <input type="text" id="exact_address" name="exact_address" value="<?php echo htmlspecialchars($property['exact_address']); ?>" required maxlength="255">

                    <label for="property_type">Property Type</label>
                    <select id="property_type" name="property_type" required>
                        <option value="apartment" <?php if ($property['property_type'] == 'apartment') echo 'selected'; ?>>Apartment</option>
                        <option value="house" <?php if ($property['property_type'] == 'house') echo 'selected'; ?>>House</option>
                        <option value="villa" <?php if ($property['property_type'] == 'villa') echo 'selected'; ?>>Villa</option>
                    </select>

                    <label for="amount">Amount (₹)</label>
                    <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($property['amount']); ?>" required min="1000" step="1000">

                    <label for="bedrooms">Bedrooms</label>
                    <input type="number" id="bedrooms" name="bedrooms" value="<?php echo htmlspecialchars($property['bedrooms']); ?>" required min="1" max="10">

                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required maxlength="100">

                    <label for="location_id">Location ID</label>
                    <input type="number" id="location_id" name="location_id" value="<?php echo htmlspecialchars($property['location_id']); ?>" required min="1">
                </div>

                <div class="form-section">
                    <h2>Additional Details</h2>

                    <label for="water_source">Water Source</label>
                    <input type="text" id="water_source" name="water_source" value="<?php echo htmlspecialchars($property['water_source']); ?>" required>

                    <label for="facing">Facing</label>
                    <select id="facing" name="facing" required>
                        <option value="north" <?php if ($property['facing'] == 'north') echo 'selected'; ?>>North</option>
                        <option value="south" <?php if ($property['facing'] == 'south') echo 'selected'; ?>>South</option>
                        <option value="east" <?php if ($property['facing'] == 'east') echo 'selected'; ?>>East</option>
                        <option value="west" <?php if ($property['facing'] == 'west') echo 'selected'; ?>>West</option>
                    </select>

                    <label for="balcony">Balcony</label>
                    <input type="text" id="balcony" name="balcony" value="<?php echo htmlspecialchars($property['balcony']); ?>" min="0" max="5">

                    <label for="parking">Parking</label>
                    <select id="parking" name="parking" required>
                        <option value="yes" <?php if ($property['parking'] == 'yes') echo 'selected'; ?>>Yes</option>
                        <option value="no" <?php if ($property['parking'] == 'no') echo 'selected'; ?>>No</option>
                    </select>

                    <label for="possession">Possession</label>
                    <input type="text" id="possession" name="possession" value="<?php echo htmlspecialchars($property['possession']); ?>" required>

                    <label for="rent_sale">For Rent or Sale?</label>
                    <select id="rent_sale" name="rent_sale" required>
                        <option value="rent" <?php if ($property['rent_sale'] == 'rent') echo 'selected'; ?>>Rent</option>
                        <option value="sale" <?php if ($property['rent_sale'] == 'sale') echo 'selected'; ?>>Sale</option>
                    </select>
                </div>
            </div>

            <!-- Image Upload Section -->
            <div class="form-section">
                <h2>Upload Images</h2>

                <label for="image1">Image 1</label>
                <input type="file" id="image1" name="image1" accept="image/*">

                <label for="image2">Image 2</label>
                <input type="file" id="image2" name="image2" accept="image/*">

                <label for="image3">Image 3</label>
                <input type="file" id="image3" name="image3" accept="image/*">

                <label for="image4">Image 4</label>
                <input type="file" id="image4" name="image4" accept="image/*">
            </div>

            <button type="submit" name="update" class="submit-btn">Update Property</button>
        </form>
        <?php else: ?>
            <p>Property not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>