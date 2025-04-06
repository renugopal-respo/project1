<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? strtolower($_GET['search']) : "";
$sql = "SELECT * FROM properties WHERE LOWER(name) LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Search</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .container { max-width: 900px; margin: auto; padding: 20px; text-align: center; }
        input, button { padding: 12px; margin: 10px 0; width: 100%; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        button { background-color: #28a745; color: white; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #218838; }
        .card-container { display: grid; gap: 15px; margin-top: 20px; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); }
        
        @media (min-width: 600px) { 
            .card-container { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 599px) { 
            .card-container { grid-template-columns: 1fr; }
        }
        
        .card { border: 1px solid #ddd; border-radius: 10px; overflow: hidden; padding: 10px; background: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease-in-out; }
        .card:hover { transform: scale(1.05); }
        .card img { width: 100%; height: 180px; object-fit: cover; border-bottom: 1px solid #ddd; }
        .card h2 { margin: 10px 0; color: #333; font-size: 18px; }
        .card p { font-size: 14px; color: #555; }
    </style>
    <script>
        function highlightInput() {
            document.getElementById('searchBox').style.border = "2px solid #28a745";
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Search for Properties</h1>
        <form method="GET">
            <input type="text" id="searchBox" name="search" placeholder="Search properties..." value="<?= htmlspecialchars($search) ?>" onfocus="highlightInput()">
            <button type="submit">Search</button>
        </form>
        <div class="card-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($property = $result->fetch_assoc()): ?>
                    <div class="card">
                        <img src="<?= htmlspecialchars($property['image']) ?>" alt="<?= htmlspecialchars($property['name']) ?>">
                        <h2><?= htmlspecialchars($property['name']) ?></h2>
                        <p><strong>Location:</strong> <?= htmlspecialchars($property['location']) ?></p>
                        <p><strong>Hall:</strong> <?= htmlspecialchars($property['hall']) ?>, <strong>Bedroom:</strong> <?= htmlspecialchars($property['bedroom']) ?>, <strong>Kitchen:</strong> <?= htmlspecialchars($property['kitchen']) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($property['status']) ?></p>
                        <p><strong>Price:</strong> <?= htmlspecialchars($property['amount']) ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No properties found.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php $conn->close(); ?>
</body>
</html>
