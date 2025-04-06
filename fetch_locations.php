<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die(json_encode(["error" => "Database connection failed."]));
}

// Fetch locations
$sql = "SELECT location_name, location_id FROM location_details";
$result = mysqli_query($conn, $sql);

$locations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $locations[] = $row;
}

// Return JSON response
echo json_encode($locations);
?>
