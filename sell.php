
<?php
require_once 'components.php'; // Securely include the Navigation and Footer classes

$foot = new footer();
$nav = new Navigation(); // Create an object of Navigation
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
    <!-- Add Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .main-content {
            display: flex;
            gap: 30px;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .contact-info, .form-container {
            flex: 1;
            min-width: 280px;
        }
        .contact-info {
            text-align: left;
            padding-left: 20px;
        }
        .contact-info h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #1e3a8a;
            font-weight: 700;
        }
        .contact-info p {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: #333;
            font-weight: 500;
        }
        .contact-info a {
            color: #007BFF;
            text-decoration: none;
            font-weight: 600;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }
        .form-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
            color: #333;
            font-weight: 600;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        .radio-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .radio-group label {
            font-size: 0.9rem;
            color: #555;
            font-weight: 500;
        }
        .submit-button {
            background-color: #007BFF;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }
        .submit-button:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }
            .contact-info {
                text-align: center;
                padding-left: 0;
            }
        }
        /* Header */
        header {
            position: sticky;
            top: 0;
            background-color: #1e3a8a; /* bg-blue-900 */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-lg */
            z-index: 50; /* z-50 */
        }
        /* Navigation Container */
        nav {
            max-width: 1280px; /* container */
            margin-left: auto; /* mx-auto */
            margin-right: auto; /* mx-auto */
            padding-left: 1.5rem; /* px-6 */
            padding-right: 1.5rem; /* px-6 */
            padding-top: 1rem; /* py-4 */
            padding-bottom: 1rem; /* py-4 */
            display: flex; /* flex */
            justify-content: space-between; /* justify-between */
            align-items: center; /* items-center */
        }
        /* Logo */
        nav div {
            color: white; /* text-white */
            font-size: 1.5rem; /* text-2xl */
            font-weight: 700; /* font-bold */
            font-family: 'Playfair Display', serif;
        }
        /* Navigation Links */
        nav ul {
            display: flex; /* flex */
            gap: 1.5rem; /* space-x-6 */
            list-style: none; /* Remove default list styling */
            padding: 0; /* Remove default padding */
            margin: 0; /* Remove default margin */
        }
        nav ul li a {
            color: white; /* text-white */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s ease; /* Smooth hover transition */
            font-weight: 600;
        }
        nav ul li a:hover {
            color: #ef4444; /* hover:text-red-500 */
        }
    </style>
</head>
<body>

    <header>
        <nav>
            <div>Real Estate</div>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="properties.php">Properties</a></li>
                <li><a href="sell.php">Contact</a></li>
            </ul>
        </nav>
    </header>
	

    <div class="container">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; text-align: center; color: #1e3a8a; margin-bottom: 20px; font-weight: 700;">NEW REPORT</h1>
        <h2 style="font-family: 'Montserrat', sans-serif; font-size: 2rem; text-align: center; color: #333; margin-bottom: 20px; font-weight: 600;">1.5 TREATIONS</h2>
        <hr style="margin-bottom: 30px;">

        <div class="main-content">
            <!-- Contact Information -->
            <div class="contact-info">
                <h2>Have Questions?</h2>
                <p>Call us: <strong>951-489-6744</strong></p>
                <p>Email us: <a href="mailto:admin@gmail.com">contactAdmin</a></p>
                
            </div>

            <!-- Form Section -->
            <div class="form-container">
                <form action="submit_form.php" method="POST">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" required minlength="2">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" required minlength="2">
                    </div>
                    <div class="form-group">
                        <label for="email">Enter your email address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}">
                    </div>
                    <div class="form-group">
                        <label>Best time to call?</label>
                        <div class="radio-group">
                            <label><input type="radio" name="callTime" value="today" required> Today</label>
                            <label><input type="radio" name="callTime" value="tomorrow"> Tomorrow</label>
                            <label><input type="radio" name="callTime" value="weekend"> Weekend</label>
                        </div>
                    </div>
                    <button type="submit"  name="submit" class="submit-button">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    $foot->foot();
    ?>

</body>
</html>
