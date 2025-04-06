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
    $sql = "SELECT DISTINCT location FROM properties";
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
    $sql = "SELECT * FROM properties WHERE location = ?";
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

    $sql = "DELETE FROM properties WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $propertyId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Property deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete property."]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        #location {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
        #loading {
            text-align: center;
            padding: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <h1>Property Listings</h1>

    <!-- Dropdown for locations -->
    <label for="location">Select Location:</label>
    <select id="location" name="location">
        <option value="">-- Select a Location --</option>
    </select>

    <!-- Table -->
    <table id="property-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property Type</th>
                <th>Exact Address</th>
                <th>Location</th>
                <th>Location ID</th>
                <th>Amount</th>
                <th>Rent/Sale</th>
                <th>Bedrooms</th>
                <th>Balcony</th>
                <th>Bathrooms</th>
                <th>Water Source</th>
                <th>Parking</th>
                <th>Facing</th>
                <th>Possession</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Rows will be dynamically added here -->
        </tbody>
    </table>

    <!-- Loading Spinner -->
    <div id="loading">Loading...</div>

    <script>
        async function fetchLocations() {
            const response = await fetch('index.php?action=fetch_locations');
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
                const response = await fetch(`index.php?action=fetch_properties&location=${location}`);
                const properties = await response.json();

                const tableBody = document.getElementById('table-body');
                tableBody.innerHTML = '';

                if (properties.length > 0) {
                    properties.forEach(property => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${property.id}</td>
                            <td>${property.property_type}</td>
                            <td>${property.exact_address}</td>
                            <td>${property.location}</td>
                            <td>${property.location_id}</td>
                            <td>$${property.amount}</td>
                            <td>${property.rent_sale}</td>
                            <td>${property.bedrooms || '-'}</td>
                            <td>${property.balcony || '-'}</td>
                            <td>${property.bathrooms || '-'}</td>
                            <td>${property.water_source || '-'}</td>
                            <td>${property.parking || '-'}</td>
                            <td>${property.facing || '-'}</td>
                            <td>${property.possession || '-'}</td>
                            <td>${property.description}</td>
                            <td><button class="delete-btn" onclick="deleteProperty(${property.id})">Delete</button></td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="16">No properties found for this location.</td></tr>';
                }
            } catch (error) {
                console.error('Error fetching properties:', error);
            } finally {
                document.getElementById('loading').style.display = 'none';
            }
        }

        async function deleteProperty(id) {
            if (confirm("Are you sure you want to delete this property?")) {
                const response = await fetch('index.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=delete_property&id=${id}`
                });

                const result = await response.json();
                if (result.success) {
                    alert(result.message);
                    fetchProperties(document.getElementById('location').value);
                } else {
                    alert(result.message);
                }
            }
        }

        document.getElementById('location').addEventListener('change', function () {
            fetchProperties(this.value);
        });

        fetchLocations();
    </script>
</body>
</html>
