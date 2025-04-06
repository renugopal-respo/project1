<?php
include "database.php"; // Secure Database Connection

// Prepare a secure SQL statement
$stmt = $conn->prepare("SELECT * FROM team_members ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Secure Real Estate</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            color: #333;
            line-height: 1.6;
        }
        h1, h2 { 
            color: #2c3e50; 
            text-align: center;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        h1 {
            font-size: 2.5rem;
            margin-top: 40px;
        }
        h2 {
            font-size: 2rem;
            margin-top: 30px;
        }
        p, li {
            font-size: 1.1rem;
            color: #555;
        }

        /* Sections */
        section {
            margin: 40px auto;
            padding: 30px;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }
        section img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
        }
        section div {
            flex: 1;
        }

        /* Mission & Vision Cards */
        .mission-vision-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
        .card {
            flex: 1 1 300px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid #3498db;
        }
        .card h3 {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 1rem;
            color: #555;
            line-height: 1.5;
        }

        /* Team Section */
        .team {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            padding: 20px;
        }
        .member {
            flex: 1 1 280px;
            background: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .member:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .member img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #3498db;
            object-fit: cover;
        }
        .member h3 {
            margin: 15px 0 10px;
            font-size: 1.4rem;
            color: #2c3e50;
        }
        .member p {
            margin: 5px 0;
            font-size: 1rem;
            color: #555;
        }
        .contact {
            margin-top: 10px;
            font-size: 14px;
        }
        .contact a {
            text-decoration: none;
            color: #3498db;
            font-weight: 500;
        }
        .contact a:hover {
            text-decoration: underline;
        }

        /* Dark Mode Toggle */
        .dark-mode {
            background: #2c3e50;
            color: #f8f8f8;
        }
        .dark-mode section {
            background: #34495e;
            box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.1);
        }
        .dark-mode h1, .dark-mode h2, .dark-mode h3 {
            color: #f8f8f8;
        }
        .dark-mode p, .dark-mode li {
            color: #ddd;
        }
        .toggle-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .toggle-btn:hover {
            background: #2980b9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            section {
                flex-direction: column;
                text-align: center;
            }
            section img {
                margin-bottom: 20px;
            }
            h1 {
                font-size: 2rem;
            }
            h2 {
                font-size: 1.8rem;
            }
            .mission-vision-cards {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<button class="toggle-btn" onclick="toggleDarkMode()">🌙 Dark Mode</button>

<h1>About Our Real Estate Company</h1>

<section>
    <img src="https://via.placeholder.com/150" alt="Company History">
    <div>
        <h2>🏢 Company History</h2>
        <p>Founded in 2010, our real estate agency has been helping people find their dream homes for over a decade. We pride ourselves on delivering exceptional service and building lasting relationships with our clients.</p>
    </div>
</section>

<section>
    <img src="https://via.placeholder.com/150" alt="Why Choose Us">
    <div>
        <h2>🌟 Why Choose Us?</h2>
        <ul>
            <li>✅ Over 10 years of experience in the real estate industry.</li>
            <li>✅ Trusted by thousands of satisfied customers.</li>
            <li>✅ A wide range of properties to suit every need and budget.</li>
            <li>✅ Personalized service tailored to your unique requirements.</li>
        </ul>
    </div>
</section>

<section>
    <h2>🎯 Mission & Vision</h2>
    <div class="mission-vision-cards">
        <!-- Mission Card -->
        <div class="card">
            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=150&h=150&q=80" alt="Mission">
            <h3>Mission</h3>
            <p>To make home buying and selling a seamless and stress-free experience for our clients.</p>
        </div>

        <!-- Vision Card -->
        <div class="card">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-1.2.1&auto=format&fit=crop&w=150&h=150&q=80" alt="Vision">
            <h3>Vision</h3>
            <p>To be the most trusted and innovative real estate company, setting new standards in the industry.</p>
        </div>

        <!-- Values Card -->
        <div class="card">
            <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=150&h=150&q=80" alt="Values">
            <h3>Values</h3>
            <p>We are committed to integrity, transparency, and excellence in everything we do.</p>
        </div>
    </div>
</section>

<section>
    <img src="https://via.placeholder.com/150" alt="Our Services">
    <div>
        <h2>🛠️ Our Services</h2>
        <p>We offer a comprehensive range of real estate services, including property sales, rentals, property management, and investment consulting. Our team is dedicated to helping you achieve your real estate goals.</p>
    </div>
</section>

<section>
    <h2>👥 Our Agents</h2>
    <div class="team">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $safe_name = htmlspecialchars($row['name']);
                $safe_role = htmlspecialchars($row['role']);
                $safe_phone = htmlspecialchars($row['phone']);
                $safe_email = htmlspecialchars($row['email']);
                $safe_image = htmlspecialchars($row['image']);

                echo "<div class='member'>
                        <img src='upload/$safe_image' alt='$safe_name'>
                        <h3>$safe_name</h3>
                        <p>$safe_role</p>
                        <p>📞 <a href='tel:$safe_phone'>$safe_phone</a></p>
                        <p>✉️ <a href='mailto:$safe_email'>$safe_email</a></p>
                      </div>";
            }
        } else {
            echo "<p>No team members found.</p>";
        }
        $stmt->close();
        ?>
    </div>
</section>

<script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
</script>

</body>
</html>