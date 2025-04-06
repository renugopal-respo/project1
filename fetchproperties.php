<?php
// fetch_properties.php

// Database connection details
$host = 'localhost'; // Replace with your database host
$dbname = 'project'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Establish a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get the location from the query parameter
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Prepare and execute the SQL query
try {
    $stmt = $pdo->prepare("
        SELECT 
            property_type, 
            exact_address, 
            location, 
            location_id, 
            amount, 
            rent_sale, 
            bedrooms, 
            balcony, 
            bathrooms, 
            water_source, 
            parking, 
            facing, 
            possession, 
            description 
        FROM properties 
        WHERE location LIKE :location
    ");
    $stmt->execute(['location' => '%' . $location . '%']);
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Set the response header to JSON
header('Content-Type: application/json');

// Return the properties as a JSON response
echo json_encode($properties);