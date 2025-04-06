<?php
session_start();
include("database.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $property_type = $_POST["property_type"];
    $exact_address = $_POST["exact_address"];
    $location = $_POST["location"];
    $location_id = $_POST["location_id"];
    $amount = $_POST["amount"];
    $rent_sale = $_POST["rent_sale"];
    $bedrooms = $_POST["bedrooms"];
    $balcony = $_POST["balcony"];
    $bathrooms = $_POST["bathrooms"];
    $water_source = $_POST["water_source"];
    $parking = $_POST["parking"];
    $facing = $_POST["facing"];
    $possession = $_POST["possession"];

    // Image Upload Handling
    $uploadDir = "uploads/";
    $imagePaths = ["", "", "", ""];

    for ($i = 0; $i < 4; $i++) {
        $imageKey = "image" . ($i + 1);
        if (!empty($_FILES[$imageKey]["name"])) {
            $fileName = time() . "_" . basename($_FILES[$imageKey]["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $allowedTypes = ["jpg", "jpeg", "png", "gif"];

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES[$imageKey]["tmp_name"], $targetFilePath)) {
                    $imagePaths[$i] = $targetFilePath;
                }
            }
        }
    }

    // Insert into database
    $sql = "INSERT INTO properties (property_type, exact_address, location, location_id, amount, rent_sale, 
            bedrooms, balcony, bathrooms, water_source, parking, facing, possession, 
            image1, image2, image3, image4) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdsiiissssssss", 
        $property_type, $exact_address, $location, $location_id, $amount, $rent_sale, 
        $bedrooms, $balcony, $bathrooms, $water_source, $parking, $facing, $possession, 
        $imagePaths[0], $imagePaths[1], $imagePaths[2], $imagePaths[3]
    );

    if ($stmt->execute()) {
        $_SESSION["success_message"] = "Property registered successfully!";
        header("Location: success.php");
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Registration Form</title>
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
            max-width: 600px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
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
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
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
            padding: 14px;
            background: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
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
        <h1>Property Registration Form</h1>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label>Property Type</label>
            <select name="property_type" required>
                <option value="">Select property type</option>
                <option value="apartment">Apartment</option>
                <option value="house">House</option>
                <option value="villa">Villa</option>
            </select>

            <label>Exact Address</label>
            <input type="text" name="exact_address" required>

            <label>Location</label>
            <input type="text" name="location" required>

            <label>Location ID</label>
            <input type="text" name="location_id" required>

            <label>Amount</label>
            <input type="text" name="amount" required>

            <label>Rent/Sale</label>
            <select name="rent_sale" required>
                <option value="rent">Rent</option>
                <option value="sale">Sale</option>
            </select>

            <label>Bedrooms</label>
            <input type="number" name="bedrooms">

            <label>Balcony</label>
            <input type="number" name="balcony">

            <label>Bathrooms</label>
            <input type="number" name="bathrooms">

            <label>Water Source</label>
            <select name="water_source">
                <option value="municipal">Municipal</option>
                <option value="borewell">Borewell</option>
            </select>

            <label>Parking</label>
            <select name="parking">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <label>Facing</label>
            <select name="facing">
                <option value="north">North</option>
                <option value="south">South</option>
                <option value="east">East</option>
                <option value="west">West</option>
            </select>

            <label>Possession</label>
            <select name="possession">
                <option value="immediate">Immediate</option>
                <option value="under-construction">Under Construction</option>
            </select>

            <label>Images</label>
            <input type="file" name="image1">
            <input type="file" name="image2">
            <input type="file" name="image3">
            <input type="file" name="image4">

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</body>
</html>
