<?php
class Navigation {
    public function renderNav() {
        echo '
        <header>
    <div class="container">
      <div class="logo">Real Estate</div>
      <nav>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="properties.html">Properties</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>
  

       <style>
    /* Basic Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    /* Sticky Header */
    header {
      position: sticky;
      top: 0;
      background-color: #1e3a8a; /* Blue-900 */
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                  0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Shadow effect */
      z-index: 50;
      padding: 1rem 0;
    }
    
    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    /* Logo */
    .logo {
      font-size: 1.5rem; /* Approximation of text-2xl */
      font-weight: bold;
      color: #ffffff;
    }
    
    /* Navigation */
    nav ul {
      list-style: none;
      display: flex;
      gap: 1.5rem; /* Space between links */
    }
    
    nav ul li a {
      text-decoration: none;
      color: #ffffff;
      transition: color 0.3s ease;
      font-size: 1rem;
    }
    
    nav ul li a:hover {
      color: #ef4444; /* Red-500 */
    }
  </style>
        ';
    }
}
?>

<?php
class footer{
     public	function foot(){
		echo '<footer>
  <div class="footer-container">
    <!-- Left Section (About) -->
    <div class="footer-section">
      <p>
         To find your best property in sivakasi. Our repository of data and information associated with each property will assist you in making a decision and purchasing the same as your assets.
      </p>
      <div class="social-icons">
        <a href="https://facebook.com/yourpage" target="_blank">
            <img src="uploads/facebook2.png" alt="Facebook">
        </a>
        
        <a href="https://linkedin.com/in/yourprofile" target="_blank">
            <img src="uploads/wp2.png" alt="WhatsApp">
        </a>
        <a href="https://instagram.com/yourpage" target="_blank">
            <img src="uploads/instagram2.png" alt="Instagram">
        </a>
      </div>
    </div>

    <!-- Middle Section (Information Links) -->
    <div class="footer-section">
      <h3>INFORMATION</h3>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="properties.html">Properties</a></li>   
        <li><a href="sell.php">Contact</a></li>
      </ul>
    </div>

    <!-- Right Section (Contact Details) -->
    <div class="footer-section">
      <h3>CONTACT DETAILS</h3>
      
      <p><i class="fas fa-envelope"></i> <a href="mailto:12crenugopal42@gmail.com">admin23@gmail.com</a></p>
      <p><i class="fas fa-phone-alt"></i> (+91) 9514896744</p>
    </div>
  </div>

  <div class="footer-bottom">
    <p>Copyrights © 2022 All Rights Reserved</p>
  </div>
</footer>

<style>
  /* Footer Styles */
  footer {
    background-color: #0c2340;
    color: white;
    padding: 40px 0;
    font-family: Arial, sans-serif;
    animation: fadeIn 1.5s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1200px;
    margin: 0 auto;
    animation: slideUp 1s ease-in-out;
  }

  @keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }

  .footer-section {
    flex: 1;
    min-width: 250px;
    padding: 0 20px;
  }

  .footer-section h3 {
    font-size: 18px;
    margin-bottom: 15px;
    font-weight: bold;
    border-bottom: 2px solid red;
    display: inline-block;
    padding-bottom: 5px;
  }

  .footer-section p, .footer-section a {
    font-size: 14px;
    color: #bdc3c7;
    line-height: 1.6;
  }

  .footer-section ul {
    list-style-type: none;
    padding: 0;
  }

  .footer-section ul li {
    margin-bottom: 10px;
  }

  .footer-section ul li a {
    color: white;
    text-decoration: none;
    transition: color 0.3s;
  }

  .footer-section ul li a:hover {
    color: red;
  }

  /* Adjust Social Icons */
  .social-icons {
    margin-top: 10px;
    display: flex;
    gap: 10px;
  }

  .social-icons a {
    display: inline-block;
    transition: transform 0.3s ease-in-out;
  }

  .social-icons img {
    width: 30px;
    height: 30px;
    object-fit: contain;
    border-radius: 50%;
    transition: transform 0.3s ease-in-out;
  }

  .social-icons img:hover {
    transform: scale(1.2);
  }

  /* Center Footer Bottom Text */
  .footer-bottom {
    text-align: center;
    margin-top: 30px;
    font-size: 14px;
    animation: fadeIn 1.5s ease-in-out;
  }
</style>';
	 }
}

?>
