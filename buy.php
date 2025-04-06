<?php
    require_once 'components.php';
	$nav=new Navigation();
	$foot=new footer();
	?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Real Estaet</title>
 <!-- <link rel="stylesheet" href="{{ url_for('static',filename='css/home.css')}}">-->
  <style>
    body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #f0f8ff; /* Soft light blue background */
    color: #333;
  }
  
  
  
  /* Create Listing Button */
  .create-listing {
    padding: 0.8rem 1.6rem; /* Reduced padding */
    background-color: #ffd700; /* Golden yellow */
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    font-size: 1rem; /* Reduced font size */
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    animation: bounceIn 1s ease-out;
  }
  
  .create-listing:hover {
    transform: scale(1.05); /* Slight scale */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    background-color: #f39c12; /* Darker shade on hover */
  }
  
  /* Hero Section */
  .hero {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh; /* Reduced height */
    background: linear-gradient(135deg, #ff6347, #ff8c00); /* Warm gradient */
    color: white;
    text-align: center;
    animation: fadeIn 2s ease-in-out;
  }
  
  .hero h1 {
    font-size: 2.5rem; /* Reduced font size */
    margin-bottom: 1rem;
    animation: slideInFromLeft 1s ease-in-out;
    font-weight: bold;
    letter-spacing: 2px;
  }
  
  .hero p {
    font-size: 1.2rem; /* Reduced font size */
    margin-bottom: 1.5rem; /* Reduced margin */
    opacity: 0.8;
    font-style: italic;
    letter-spacing: 1px;
    animation: fadeIn 2s ease-in-out;
  }
  
  /* Animations */
  @keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
  }
  
  @keyframes slideInFromLeft {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(0); }
  }
  
  @keyframes fadeInLeft {
    0% { opacity: 0; transform: translateX(-30px); }
    100% { opacity: 1; transform: translateX(0); }
  }
  
  @keyframes bounceIn {
    0% { transform: scale(0.5); opacity: 0; }
    60% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(1); }
  }
  
  /* Search Bar */
  .search-bar {
    width: 100%;
    max-width: 800px; /* Reduced max-width */
    margin: 2rem auto;
    padding: 1.2rem; /* Reduced padding */
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    transition: transform 0.4s ease;
    animation: fadeInLeft 1s ease-out;
  }
  
  .search-bar:hover {
    transform: scale(1.02);
  }
  
  .search-bar input,
  .search-bar select {
    padding: 1rem;
    border-radius: 5px;
    border: 2px solid #ff6347; /* Tomato red border */
    background-color: #fff;
    transition: all 0.3s ease;
  }
  
  .search-bar input:focus,
  .search-bar select:focus {
    border-color: #ff8c00; /* Focus state orange border */
  }
  
  /* Filter Buttons */
  .filter-buttons {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem; /* Reduced bottom margin */
  }
  
  .filter-btn {
    margin: 0 1rem;
    padding: 0.8rem 1.6rem; /* Reduced padding */
    background-color: #ff6347; /* Tomato Red */
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.4s ease-in-out;
    color: white;
    font-size: 1rem; /* Reduced font size */
    font-weight: 600;
    letter-spacing: 1px;
    animation: fadeIn 1.5s ease-out;
  }
  
  .filter-btn:hover {
    background-color: #ff8c00; /* Bright Orange */
    transform: scale(1.05); /* Slight scale on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }
  
  /* Input Group */
  .input-container {
    display: flex;
    gap: 1rem;
    justify-content: center;
  }
  
  .input-container select,
  .search-btn {
    padding: 0.8rem 1.6rem; /* Reduced padding */
    border-radius: 12px;
    border: none;
    transition: all 0.4s ease-in-out;
    font-size: 1rem; /* Reduced font size */
  }
  
  .search-btn {
    background-color: #ff6347; /* Tomato red */
    color: white;
    cursor: pointer;
  }
  
  .search-btn:hover {
    background-color: #ff8c00; /* Orange on hover */
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }
  
  
  
  
  /* Property List Section */
  #property-list {
    background: linear-gradient(135deg, #ff6347, #ff8c00); /* Tomato red to orange gradient */
    padding: 80px 20px; /* Reduced padding */
    text-align: center;
    animation: fadeIn 1s ease-in-out;
  }
  
  #property-list h2 {
    font-size: 30px; /* Reduced font size */
    margin-bottom: 40px;
    color: #fff;
    animation: fadeInLeft 1.5s ease-out;
  }
  
  .property-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px; /* Reduced gap */
  }
  
  .property-card {
    background-color: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    width: 30%;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
  }
  
  .property-card:hover {
    transform: translateY(-20px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
  }
  
  .property-image {
    width: 100%;
    height: 180px; /* Reduced height */
    object-fit: cover;
  }
  
  .property-info {
    padding: 16px; /* Reduced padding */
    text-align: left;
  }
  
  .property-title {
    font-size: 20px; /* Reduced font size */
    font-weight: bold;
    margin: 10px 0;
    color: #2c3e50;
    animation: fadeInLeft 1s ease-out;
  }
  
  .property-description {
    font-size: 14px; /* Reduced font size */
    color: #7f8c8d;
    margin-bottom: 15px;
  }
  
  .property-price {
    font-size: 16px; /* Reduced font size */
    color: #e74c3c; /* Red color for price */
    font-weight: bold;
    margin-bottom: 15px;
  }
  
  .property-link {
    font-size: 16px; /* Reduced font size */
    color: #3498db; /* Blue link */
    text-decoration: none;
  }
  
  .property-link:hover {
    text-decoration: underline;
    color: #2980b9; /* Darker blue on hover */
  }
  /* Steps Section */
  .steps {
    background: #f8f8f8;
    padding: 60px 20px;
    text-align: center;
  }
  
  .steps-title {
    font-size: 2rem;
    margin-bottom: 20px;
  }
  
  .steps-container {
    display: flex;
    justify-content: center;
    gap: 2rem;
  }
  
  .step {
    max-width: 300px;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  </style>
</head>
<body>
  <!-- Header Section -->
  <?php
  
     $nav->renderNav();
	 ?>

  <!-- Main Content -->
  <main>
    <!-- Hero Section -->
    <section class="hero">
     
      <div class="hero-content">
        <h1>Find potential buyers and sellers with ease</h1>
        <p>Explore the best properties for sale and rent near you.</p>
       
        <!-- Search Bar -->
        <div class="search-bar">
          <!-- Filter Buttons -->
          <div class="filter-buttons">
            <button class="filter-btn">ALL</button>
            <button class="filter-btn">FOR RENT</button>
            <button class="filter-btn">FOR SALE</button>
          </div>

          <!-- Input Group -->
          <div class="input-container">
            <select id="location"> 
              <option value="">Where</option>
              <option value="virudhunagar">Virudhunagar</option>
              <option value="theni">Theni</option>
			  
            </select>
            <select id="price">
              <option value="">Price</option>
              <option value="10000">10,000</option>
              <option value="20000">20,000</option>
            </select>
            <button class="search-btn">Search</button>
          </div>
        </div>
      </div>
    </section>
	<!--steps  steps  -->
	 
    <section id="property-list" class="property-list">
  <h2>Our Properties</h2>
  <div class="property-cards">
    <!-- Property 1 -->
    <div class="property-card">
      <img src="uploads\/peakpx (1).jpg" alt="Property 1" class="property-image">
      <div class="property-info">
        <h3 class="property-title">Modern Family Home</h3>
        <p class="property-description">A beautiful 4-bedroom home with a spacious backyard and modern amenities. Perfect for families looking for comfort and convenience.</p>
        <p class="property-price">$450,000</p>
        <a href="/property-detail/1" class="property-link">View Details</a>
      </div>
    </div>

    <!-- Property 2 -->
    <div class="property-card">
      <img src="uploads\/peakpx (1).jpg" alt="Property 2" class="property-image">
      <div class="property-info">
        <h3 class="property-title">Luxury Condo</h3>
        <p class="property-description">A stunning 2-bedroom condo located in the heart of the city, offering breathtaking views and upscale amenities.</p>
        <p class="property-price">$750,000</p>
        <a href="/property-detail/2" class="property-link">View Details</a>
      </div>
    </div>

    <!-- Property 3 -->
    <div class="property-card">
      <img src="uploads\/peakpx (1).jpg" alt="Property 3" class="property-image">
      <div class="property-info">
        <h3 class="property-title">Charming Cottage</h3>
        <p class="property-description">A cozy 2-bedroom cottage nestled in the countryside, perfect for weekend getaways or a peaceful retreat.</p>
        <p class="property-price">$225,000</p>
        <a href="/property-detail/3" class="property-link">View Details</a>
      </div>
    </div>
	 <div class="property-card">
      <img src="uploads\/peakpx (1).jpg" alt="Property 3" class="property-image">
      <div class="property-info">
        <h3 class="property-title">Charming Cottage</h3>
        <p class="property-description">A cozy 2-bedroom cottage nestled in the countryside, perfect for weekend getaways or a peaceful retreat.</p>
        <p class="property-price">$225,000</p>
        <a href="/property-detail/3" class="property-link">View Details</a>
      </div>
    </div>
	 <div class="property-card">
      <img src="uploads\/peakpx (1).jpg" alt="Property 3" class="property-image">
      <div class="property-info">
        <h3 class="property-title">Charming Cottage</h3>
        <p class="property-description">A cozy 2-bedroom cottage nestled in the countryside, perfect for weekend getaways or a peaceful retreat.</p>
        <p class="property-price">$225,000</p>
        <a href="/property-detail/3" class="property-link">View Details</a>
      </div>
    </div>
</main>
   <?php
   $foot->foot();
    ?>

  
</body>
</html>


