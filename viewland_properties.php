<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch locations for the dropdown
if (isset($_GET['action']) && $_GET['action'] === 'fetch_locations') {
    $sql = "SELECT DISTINCT location FROM land_properties";
    $result = $conn->query($sql);

    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row['location'];
    }

    echo json_encode($locations);
    exit;
}

// Fetch properties based on the selected location
if (isset($_GET['action']) && $_GET['action'] === 'fetch_properties' && isset($_GET['location'])) {
    $selectedLocation = $_GET['location'];
    $sql = "SELECT * FROM land_properties WHERE location = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedLocation);
    $stmt->execute();
    $result = $stmt->get_result();

    $properties = [];
    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }

    echo json_encode($properties);
    exit;
}

// Delete a property
if (isset($_POST['action']) && $_POST['action'] === 'delete_property' && isset($_POST['id'])) {
    $propertyId = $_POST['id'];

    $sql = "DELETE FROM land_properties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $propertyId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Property deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete property."]);
    }
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Property Listings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
            padding: 20px;
        }
        h1 { text-align: center; }
        #location {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .table-container {
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th { background-color: #007bff; color: #fff; }
        .delete-btn, .update-btn {
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn { background-color: red; color: white; }
        .delete-btn:hover { background-color: darkred; }
        .update-btn { background-color: #28a745; color: white; margin-right: 5px; }
        .update-btn:hover { background-color: #218838; }
        #loading { text-align: center; display: none; }
    </style>
</head>
<body>
    <h1>Land Property Listings</h1>
    <label for="location">Select Location:</label>
    <select id="location" name="location">
        <option value="">-- Select a Location --</option>
    </select>
    <div class="table-container">
        <table id="property-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Property Type</th>
                    <th>Location</th>
                    <th>Location ID</th>
                    <th>Water Source</th>
                    <th>Total Area (sq. ft.)</th>
                    <th>Address</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>
    <div id="loading">Loading...</div>
    <script>
        async function fetchLocations() {
            const response = await fetch('viewland_properties.php?action=fetch_locations');
            const locations = await response.json();
            const dropdown = document.getElementById('location');
            locations.forEach(location => {
                const option = document.createElement('option');
                option.value = location;
                option.textContent = location;
                dropdown.appendChild(option);
            });
        }
        async function fetchProperties(location) {
            if (!location) return;
            document.getElementById('loading').style.display = 'block';
            try {
                const response = await fetch(`viewland_properties.php?action=fetch_properties&location=${location}`);
                const properties = await response.json();
                const tableBody = document.getElementById('table-body');
                tableBody.innerHTML = '';
                properties.forEach(property => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${property.id}</td>
                        <td>${property.property_type}</td>
                        <td>${property.location}</td>
                        <td>${property.location_id}</td>
                        <td>${property.water_source || '-'}</td>
                        <td>${property.total_area} sq. ft.</td>
                        <td>${property.address}</td>
                        <td>$${property.price.toLocaleString()}</td>
                        <td>${property.description}</td>
                        <td>
                            <button class="update-btn" onclick="updateProperty(${property.id})">Update</button>
                            <button class="delete-btn" onclick="deleteProperty(${property.id})">Delete</button>
                        </td>`;
                    tableBody.appendChild(row);
                });
            } finally {
                document.getElementById('loading').style.display = 'none';
            }
        }
        function updateProperty(id) {
            window.location.href = `update_land_property.php?id=${id}`;
        }
        async function deleteProperty(id) {
            if (confirm("Are you sure you want to delete this property?")) {
                await fetch('viewland_properties.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=delete_property&id=${id}`
                });
                fetchProperties(document.getElementById('location').value);
            }
        }
        document.getElementById('location').addEventListener('change', function () {
            fetchProperties(this.value);
        });
        fetchLocations();
    </script>
</body>
</html>
