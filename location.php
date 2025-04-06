<?php
require 'vendor/autoload.php';

use GeoIp2\Database\Reader;

header("Content-Type: application/json");

try {
    // Load GeoIP2 database
    $reader = new Reader('GeoIP/GeoLite2-City.mmdb');

    // Get user's IP address
    $ip = $_SERVER['REMOTE_ADDR'];

    // Exclude local IPs (e.g., 127.0.0.1)
    if ($ip == '127.0.0.1' || $ip == '::1') {
        echo json_encode(["error" => "Localhost IP detected, cannot fetch location."]);
        exit;
    }

    // Get location details
    $record = $reader->city($ip);

    $locationData = [
        "ip" => $ip,
        "city" => $record->city->name ?? "Unknown",
        "region" => $record->mostSpecificSubdivision->name ?? "Unknown",
        "country" => $record->country->name ?? "Unknown",
        "latitude" => $record->location->latitude ?? "Unknown",
        "longitude" => $record->location->longitude ?? "Unknown"
    ];

    echo json_encode($locationData, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(["error" => "Unable to fetch location", "details" => $e->getMessage()]);
}
?>
