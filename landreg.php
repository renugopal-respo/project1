<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve property type from the dropdown
    $property_type = $_POST["property_type"];
    $location = $_POST["location"];
    $location_id = $_POST["location_id"];
    $water_source = $_POST["water_source"];
    $total_area = $_POST["total_area"];
    $address = $_POST["address"]; // Address field
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Handle multiple image uploads
    $image1 = uploadImage($_FILES["image1"]);
    $image2 = uploadImage($_FILES["image2"]);
    $image3 = uploadImage($_FILES["image3"]);
    $image4 = uploadImage($_FILES["image4"]);

    // Insert into database
    $sql = "INSERT INTO land_properties (property_type, location, location_id, water_source, total_area, address, price, description, image1, image2, image3, image4) 
            VALUES ('$property_type', '$location', '$location_id', '$water_source', '$total_area', '$address', '$price', '$description', '$image1', '$image2', '$image3', '$image4')";

    if ($conn->query($sql) === TRUE) {
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
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
            return $target_file; // Return the path of the uploaded image
        }
    }
    return null; // Return null if no file is uploaded
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Add your CSS styles here */
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
            background: #e0e0e0;
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
        input[type="file"],
        textarea {
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
        input[type="file"]:focus,
        textarea:focus {
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

        .delete-btn {
            width: 100%;
            padding: 14px;
            background: #dc3545;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .error-message {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Dropdown container styled to match the input width and white background */
        .dropdown-container {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            width: 100%;
            display: none;
            max-height: 150px;
            overflow-y: auto;
            border-radius: 5px;
            z-index: 1000;
        }

        .dropdown-item {
            padding: 8px;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: #f1f1f1;
        }

        /* Wrapper to ensure proper positioning */
        .dropdown-wrapper {
            position: relative;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Land Registration Form</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Location Details -->
        <div class="form-section">
            <h2>Location Details</h2>
            <div class="dropdown-wrapper">
                <label for="location">Location Name</label>
                <input type="text" id="location" name="location" onfocus="showDropdown()" autocomplete="off" required>
                <div id="dropdown-container" class="dropdown-container"></div>
            </div>
            <label for="location_id">Location ID</label>
            <input type="text" id="location_id" name="location_id" readonly>
        </div>

        <!-- Property Details -->
        <div class="form-section">
            <h2>Property Details</h2>
            <label for="property_type">Property Type</label>
            <select id="property_type" name="property_type" required>
                <option value="">Select Property Type</option>
                <option value="agricultureland">Agriculture Land</option>
                <option value="plots">Plots</option>
            </select>

            <label for="total_area">Total Area (sq ft)</label>
            <input type="number" id="total_area" name="total_area" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>

            <label for="water_source">Water Source</label>
            <input type="text" id="water_source" name="water_source" required>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" required>

            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
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

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Register Property</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('fetch_locations.php')
            .then(response => response.json())
            .then(data => {
                let dropdownContainer = document.getElementById("dropdown-container");
                dropdownContainer.innerHTML = data.map(loc =>
                    `<div class="dropdown-item" onclick="selectLocation('${loc.location_name}', '${loc.location_id}')">
                        ${loc.location_name} (${loc.location_id})
                    </div>`
                ).join('');
            });
    });

    function showDropdown() {
        document.getElementById("dropdown-container").style.display = "block";
    }

    function selectLocation(name, id) {
        document.getElementById("location").value = name;
        document.getElementById("location_id").value = id;
        document.getElementById("dropdown-container").style.display = "none";
    }
</script>
</body>
</html>
