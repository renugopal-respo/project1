
<?php
$host = "localhost"; // Change if needed
$user = "root"; // Default user for XAMPP
$pass = ""; // Default password for XAMPP (leave empty)
$dbname = "project"; // Change to your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
