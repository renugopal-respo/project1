<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Welcome Message */
        .welcome-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        /* Decorated Text */
        .decorated-text {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 20px 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .decorated-text h1 {
            font-size: 36px;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .decorated-text p {
            font-size: 18px;
            margin: 10px 0 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .decorated-text:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            position: fixed;
            height: 100%;
            left: -250px;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #333;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Dropdown Styling */
        .dropdown {
            margin-left: 20px;
            margin-top: 5px;
            display: none;
            background-color: rgba(0, 0, 0, 0.1); /* Slightly darker background */
            border-radius: 4px;
            padding: 5px 0;
        }

        .dropdown li a {
            padding: 8px;
            font-weight: bold; /* Bold text */
            color: #333; /* Darker text color */
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .dropdown li a:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Hover effect */
        }

        /* Admin Profile Section */
        .admin-profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .admin-name {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        /* Contact Details */
        .contact-details {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .contact-details p {
            margin: 5px 0;
        }

        /* Close Button and Hamburger Menu */
        .toggle-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        .toggle-btn:hover {
            color: #ff4d4d;
        }

        .close-btn {
            display: none;
        }

        .hamburger-menu {
            display: block;
        }

        .sidebar.active .close-btn {
            display: block;
        }

        .sidebar.active .hamburger-menu {
            display: none;
        }

        /* Profile Field (Visible when sidebar is closed) */
        .profile-field {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            cursor: pointer;
            text-align: center;
        }

        .profile-field .profile-icon {
            font-size: 36px;
        }

        .profile-field p {
            margin: 5px 0 0;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- Toggle Buttons -->
            <span class="toggle-btn close-btn" onclick="closeSidebar()">×</span>
            <span class="toggle-btn hamburger-menu" onclick="openSidebar()">☰</span>

            <!-- Admin Profile -->
            <div class="admin-profile">
                <div class="profile-icon">👤</div>
                <p class="admin-name">Admin</p>
            </div>
            <h2>Admin Dashboard</h2>
            <ul>
                <li>
                    <a href="#" onclick="toggleDropdown('upload-dropdown')">
                        <i class="fas fa-upload"></i> Upload Property
                    </a>
                    <ul id="upload-dropdown" class="dropdown">
                        <li>
                            <a href="landreg.php">
                                <i class="fas fa-mountain"></i> Land
                            </a>
                        </li>
                        <li>
                            <a href="housereg.php">
                                <i class="fas fa-home"></i> House
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" onclick="toggleDropdown('update-dropdown')">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <ul id="update-dropdown" class="dropdown">
                        <li>
                            <a href="viewland_properties.php">
                                <i class="fas fa-mountain"></i> Land
                            </a>
                        </li>
                        <li>
                            <a href="viewproperties.php">
                                <i class="fas fa-home"></i> House
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>

            <!-- Contact Details -->
            <div class="contact-details">
                <p><i class="fas fa-envelope"></i> Email: admin@example.com</p>
                <p><i class="fas fa-phone"></i> Phone: +123 456 7890</p>
                <p><i class="fas fa-map-marker-alt"></i> Address: 123 Admin St, City</p>
            </div>
        </div>

        <!-- Profile Field (Visible when sidebar is closed) -->
        <div class="profile-field" id="profile-field">
            <div class="profile-icon">👤</div>
            <p>John Doe</p>
        </div>

        <!-- Welcome Message -->
        
        
    </div>

    <script>
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.add('active');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.remove('active');
        }

        function toggleDropdown(id) {
            var dropdown = document.getElementById(id);
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }
    </script>
</body>
</html>