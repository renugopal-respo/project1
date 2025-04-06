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
    $sql = "SELECT location_name FROM location_details";
    $result = $conn->query($sql);

    $locations = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row['location_name'];
        }
    }

    echo json_encode($locations); // Return locations as JSON
    exit;
}

// Fetch properties based on the selected location
if (isset($_GET['action']) && $_GET['action'] === 'fetch_properties' && isset($_GET['location'])) {
    $selectedLocation = $_GET['location'];

    $sql = "SELECT * FROM land_properties WHERE location = '$selectedLocation'";
    $result = $conn->query($sql);

    $properties = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
    }

    echo json_encode($properties); // Return properties as JSON
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
        /* General Styles */
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

        /* Dropdown Styles */
        #location {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }

        /* Table Styles */
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

        /* Loading Spinner */
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
                <th>Location</th>
                <th>Location ID</th>
                <th>Water Source</th>
                <th>Total Area</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Rows will be dynamically added here -->
        </tbody>
    </table>

    <!-- Loading Spinner -->
    <div id="loading">Loading...</div>

    <script>
        // Fetch locations and populate dropdown
        async function fetchLocations() {
            const response = await fetch('view.php?action=fetch_locations');
            const locations = await response.json();

            const dropdown = document.getElementById('location');
            locations.forEach(location => {
                const option = document.createElement('option');
                option.value = location;
                option.textContent = location;
                dropdown.appendChild(option);
            });
        }

        // Fetch properties based on the selected location
        async function fetchProperties(location) {
            if (!location) return; // Do nothing if no location is selected

            // Show loading spinner
            document.getElementById('loading').style.display = 'block';

            try {
                const response = await fetch(`view.php?action=fetch_properties&location=${location}`);
                const properties = await response.json();

                const tableBody = document.getElementById('table-body');
                tableBody.innerHTML = ''; // Clear existing rows

                if (properties.length > 0) {
                    properties.forEach(property => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${property.id}</td>
                            <td>${property.property_type}</td>
                            <td>${property.location}</td>
                            <td>${property.location_id}</td>
                            <td>${property.water_source}</td>
                            <td>${property.total_area} sq. ft.</td>
                            <td>$${property.price}</td>
                            <td>${property.description}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="8">No properties found for this location.</td></tr>';
                }
            } catch (error) {
                console.error('Error fetching properties:', error);
            } finally {
                // Hide loading spinner
                document.getElementById('loading').style.display = 'none';
            }
        }

        // Event listener for dropdown change
        document.getElementById('location').addEventListener('change', function () {
            const selectedLocation = this.value;
            fetchProperties(selectedLocation);
        });

        // Initial fetch of locations
        fetchLocations();
    </script>
</body>
</html>