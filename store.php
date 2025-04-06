<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "project";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner = $_POST['owner'];
    $address = $_POST['address'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $phone_num = $_POST['phone_num'];
    $property_type = $_POST['property_type'];
    $transaction_type = $_POST['transaction_type'];

    // Determine the correct table
    if ($transaction_type == "Rent" && $property_type == "House") {
        $table_name = "rent_house";
    } elseif ($transaction_type == "Sale" && $property_type == "House") {
        $table_name = "sale_house";
    } elseif ($transaction_type == "Rent" && $property_type == "Land") {
        $table_name = "rent_land";
    } elseif ($transaction_type == "Sale" && $property_type == "Land") {
        $table_name = "sale_land";
    } else {
        die("Invalid property type or transaction type.");
    }

    // Handle Image Uploads
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $imagePaths = [];

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $imageName = basename($_FILES['images']['name'][$key]);
        $targetFilePath = $uploadDir . $imageName;

        if (move_uploaded_file($tmp_name, $targetFilePath)) {
            $imagePaths[] = $targetFilePath;
        }
    }

    $imagePathsJson = json_encode($imagePaths);

    // Insert data into the correct table
    $stmt = $conn->prepare("INSERT INTO $table_name (owner, address, price, description, phone_num, image_paths) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsss", $owner, $address, $price, $description, $phone_num, $imagePathsJson);

    if ($stmt->execute()) {
        echo "Property registered successfully in table: " . $table_name;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
