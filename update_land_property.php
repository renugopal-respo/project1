<?php
include("database.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM land_properties WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $property_type = $row['property_type'];
        $location = $row['location'];
        $location_id = $row['location_id'];
        $water_source = $row['water_source'];
        $total_area = $row['total_area'];
        $address = $row['address']; // Fetch address from the database
        $price = $row['price'];
        $description = $row['description'];
        $image1 = $row['image1'];
        $image2 = $row['image2'];
        $image3 = $row['image3'];
        $image4 = $row['image4'];
    } else {
        echo "Property not found.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        // Handle delete request
        $id = $_POST['id'];
        $sql = "DELETE FROM land_properties WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: success.php");
            exit();
        } else {
            echo "Error deleting property: " . $conn->error;
        }
    } else {
        // Handle update request
        $id = $_POST['id'];
        $property_type = "Land";
        $location = $_POST["location"];
        $location_id = $_POST["location_id"];
        $water_source = $_POST["water_source"];
        $total_area = $_POST["total_area"];
        $address = $_POST["address"]; // Get address from the form
        $price = $_POST["price"];
        $description = $_POST["description"];

        // Handle multiple image uploads
        $image1 = uploadImage($_FILES["image1"], $image1);
        $image2 = uploadImage($_FILES["image2"], $image2);
        $image3 = uploadImage($_FILES["image3"], $image3);
        $image4 = uploadImage($_FILES["image4"], $image4);

        // Update database
        $sql = "UPDATE land_properties 
                SET property_type = '$property_type', 
                    location = '$location', 
                    location_id = '$location_id', 
                    water_source = '$water_source', 
                    total_area = '$total_area', 
                    address = '$address', 
                    price = '$price', 
                    description = '$description', 
                    image1 = '$image1', 
                    image2 = '$image2', 
                    image3 = '$image3', 
                    image4 = '$image4' 
                WHERE id = $id";

        if ($conn->query($sql)) {
            header("Location: success.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Function to handle image upload
function uploadImage($file, $existingImage) {
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
    return $existingImage;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Land Property</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-section {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #34495e;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        select,
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
            background-color: #fff;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        input[type="file"]:focus,
        textarea:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        select {
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            background-size: 12px;
            padding-right: 30px;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #28a745;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .submit-btn:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .dropdown-container {
            display: none;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-height: 150px;
            overflow-y: auto;
            margin-top: 5px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 10px 12px;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
            color: #333;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f1f1f1;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Update Land Property</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <!-- Location Details -->
        <div class="form-section">
            <label for="location">Location Name</label>
            <input type="text" id="location" name="location" value="<?php echo $location; ?>" onfocus="showDropdown()" autocomplete="off" required>
            <div id="dropdown-container" class="dropdown-container"></div>
            <label for="location_id">Location ID</label>
            <input type="text" id="location_id" name="location_id" value="<?php echo $location_id; ?>" readonly>
        </div>

        <!-- Property Details -->
        <div class="form-section">
            <label>Total Area (sq ft)</label>
            <input type="number" name="total_area" value="<?php echo $total_area; ?>" required>
        </div>
        <div class="form-section">
            <label>Address</label>
            <input type="text" name="address" value="<?php echo $address; ?>" required>
        </div>
        <div class="form-section">
            <label>Water Source</label>
            <input type="text" name="water_source" value="<?php echo $water_source; ?>" required>
        </div>
        <div class="form-section">
            <label>Price</label>
            <input type="number" name="price" value="<?php echo $price; ?>" required>
        </div>
        <div class="form-section">
            <label>Description</label>
            <textarea name="description"><?php echo $description; ?></textarea>
        </div>

        <!-- Image Upload Section -->
        <div class="form-section">
            <label>Image 1</label>
            <input type="file" name="image1" accept="image/*">
            <label>Image 2</label>
            <input type="file" name="image2" accept="image/*">
            <label>Image 3</label>
            <input type="file" name="image3" accept="image/*">
            <label>Image 4</label>
            <input type="file" name="image4" accept="image/*">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Update Property</button>
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