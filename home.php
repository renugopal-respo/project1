<?php
require_once 'components.php';
$footer = new footer();
include "database.php"; // Secure Database Connection

// Fetch properties from the database
$stmt = $conn->prepare("SELECT * FROM properties ORDER BY id DESC LIMIT 6");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->execute();
$properties = $stmt->get_result();
if ($properties === false) {
    die("Error executing query: " . $stmt->error);
}
// Indian number formatting function
function format_indian_number($number) {
    $number = (float)$number;
    if ($number >= 10000000) {
        return round($number / 10000000, 2) . ' Cr';
    } elseif ($number >= 100000) {
        return round($number / 100000, 2) . ' Lakh';
    }
    return number_format($number);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Real Estate Portal</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <!-- AOS Library for Scroll Animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <!-- LazyLoad -->
  <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
<!-- Custom CSS -->
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            background: #f0f2f5;
            font-family: 'Poppins', sans-serif;
        }
        /* Filter & Suggestions */
        #filterContainer {
            transition: transform 0.5s ease, opacity 0.5s ease;
            background: #c3cfe2;
            border-radius: 1px;
        }
        .hidden-slide {
            transform: translateY(20px);
            opacity: 0;
        }
        .animate-slide-up {
            transform: translateY(0);
            opacity: 1;
        }
        #suggestionsDropdown {
            z-index: 1100;
        }
        /* Property Grid & Card Styles */
        .property-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        .property-card {
            min-height: 300px;
        }
        @media (max-width: 1024px) {
            .property-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 768px) {
            .property-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .property-grid {
                grid-template-columns: 1fr;
            }
        }
        /* Filter Button Styles */
        .filter-btn.active {
            background: red !important;
            color: white !important;
        }
        .filter-btn.active i {
            color: white !important;
        }
        /* Price Dropdown */
        #priceDropdown {
            min-width: 160px;
            position: absolute;
            top: 0;
            left: 100%;
            margin-left: 0.5rem;
        }
        .price-dropdown-flex {
            display: flex;
            flex-direction: row;
            gap: 0.5rem;
            padding: 0.5rem;
        }
        .price-dropdown-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.5rem;
            background-color: #e5e7eb;
            border-radius: 9999px;
            font-size: 0.875rem;
            transition: background-color 0.2s ease;
            white-space: nowrap;
        }
        .price-dropdown-item:hover {
            background-color: #d1d5db;
        }
        /* Status Badge & Image Container */
        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            z-index: 10;
        }
        .image-container {
            position: relative;
        }
		.price-animation {
        animation: priceSlide 0.5s ease-out;
        position: relative;
    }
    
    @keyframes priceSlide {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .discounted-price {
        color: #dc2626;
        font-weight: 600;
        margin-left: 8px;
    }
    
    .original-price {
        color: #6b7280;
    }
    </style>
</head>
<body class="bg-[#f5f7fa]">
  <!-- Header -->
  <header class="sticky top-0 bg-blue-900 shadow-lg z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="text-white text-2xl font-bold">Real Estate</div>
      <ul class="flex space-x-6">
        <li><a href="home.php" class="text-white hover:text-red-500">Home</a></li>
        <li><a href="about.php" class="text-white hover:text-red-500">About</a></li>
        <li><a href="properties.html" class="text-white hover:text-red-500">Properties</a></li>
        <li><a href="contact.php" class="text-white hover:text-red-500">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <div class="container mx-auto px-4 py-12 flex flex-col lg:flex-row items-center" data-aos="fade">
    <div class="lg:w-1/2 text-center lg:text-left mb-8 lg:mb-0" data-aos="fade-right">
      <div class="flex items-center justify-center lg:justify-start mb-4">
        <i class="fas fa-home text-red-500 text-2xl mr-2"></i>
        <span class="text-gray-700 text-lg font-semibold">Real Estate Agency</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">Find Your Dream House By Us</h1>
      <p class="text-gray-600 mb-8">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
      <div class="flex justify-center lg:justify-start space-x-4">
        <form action="sell.php" method="POST">
          <button class="bg-red-500 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-red-600 transition duration-300">Sell First</button>
        </form>
        <form action="properties.html" method="post">
          <button class="bg-blue-500 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-blue-600 transition duration-300">Search</button>
        </form>
      </div>
    </div>
    <div class="lg:w-1/2 flex justify-center" data-aos="fade-left">
      <img alt="Modern house" class="rounded-lg shadow-lg lazy" data-src="assets/image/hero-banner.png" height="400" width="600"/>
    </div>
  </div>
          <!-- Added White Space -->
  <div class="bg-white py-1"></div>
  <!-- Services Section -->
  <section class="bg-[#f5f7fa] py-16" data-aos="fade">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-8">
        <i class="fas fa-tools text-red-500 mr-2"></i> Our Services
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 justify-items-center">
        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[350px] w-full max-w-xs transition-transform transform hover:scale-105">
          <img data-src="assets/image/service-1.png" alt="Buy a Home" class="w-full h-48 object-cover lazy">
          <div class="p-4 text-center flex-grow flex flex-col justify-center">
            <h3 class="text-2xl font-bold mb-2">Buy a Home</h3>
            <p class="text-gray-600 mb-2 text-base">Over 1 million+ homes for sale.</p>
            <a href="properties.html" class="text-blue-500 font-semibold hover:text-blue-700">Find A Home →</a>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[350px] w-full max-w-xs transition-transform transform hover:scale-105">
          <img data-src="assets/image/service-2.png" alt="Rent a Home" class="w-full h-48 object-cover lazy">
          <div class="p-4 text-center flex-grow flex flex-col justify-center">
            <h3 class="text-2xl font-bold mb-2">Rent a Home</h3>
            <p class="text-gray-600 mb-2 text-base">Over 1 million+ rentals available.</p>
            <a href="properties.html" class="text-blue-500 font-semibold hover:text-blue-700">Find A Home →</a>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-[350px] w-full max-w-xs transition-transform transform hover:scale-105">
          <img data-src="assets/image/service-3.png" alt="Sell a Home" class="w-full h-48 object-cover lazy">
          <div class="p-4 text-center flex-grow flex flex-col justify-center">
            <h3 class="text-2xl font-bold mb-2">Sell a Home</h3>
            <p class="text-gray-600 mb-2 text-base">Reach millions of potential buyers.</p>
            <a href="Properties.html" class="text-blue-500 font-semibold hover:text-blue-700">Find A Home →</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Added White Space -->
  <div class="bg-white py-1"></div>

    <!-- Featured Properties Section -->
  <section class="bg-[#f5f7fa] py-12" data-aos="fade">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-8">
        <i class="fas fa-home text-red-500 mr-2"></i> Featured Properties
      </h2>
      <div class="property-grid grid gap-4">
        <?php if ($properties->num_rows > 0): ?>
          <?php while ($property = $properties->fetch_assoc()): ?>
            <div class="property-card bg-white rounded-lg shadow-md overflow-hidden flex flex-col" data-aos="fade">
              <div class="image-container relative">
                <?php 
                  $imgSrc = !empty($property['image1']) ? $property['image1'] : "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80";
                ?>
                <img data-src="<?= $imgSrc ?>" class="w-full h-40 object-cover lazy" alt="<?= htmlspecialchars($property['location']) ?>">
                <div class="status-badge absolute top-2 right-2 px-3 py-1 rounded-full text-sm <?= $property['rent_sale'] === 'rent' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                  <?= $property['rent_sale'] === 'rent' ? "Rent ({$property['current_stage']})" : 'For Sale' ?>
                </div>
              </div>
              <div class="p-4 flex flex-col gap-2 flex-grow">
                <h3 class="text-base font-semibold flex items-center">
                  <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                  <?= htmlspecialchars($property['location']) ?>
                </h3>
                <div class="text-xl text-blue-600">
                  <?php if ($property['discount'] > 0): ?>
                    <del class="original-price">₹<?= format_indian_number($property['amount']) ?></del>
                    <span class="discounted-price price-animation">
                      ₹<?= format_indian_number($property['amount'] - $property['discount']) ?>
                      <?= $property['rent_sale'] === 'rent' ? '/mo' : '' ?>
                    </span>
                  <?php else: ?>
                    ₹<?= format_indian_number($property['amount']) ?><?= $property['rent_sale'] === 'rent' ? '/mo' : '' ?>
                  <?php endif; ?>
                </div>
                <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                  <?= !empty($property['bedrooms']) ? '<div class="flex items-center"><i class="fas fa-bed text-blue-500 mr-1"></i>' . htmlspecialchars($property['bedrooms']) . '</div>' : '' ?>
                  <?= !empty($property['bathrooms']) ? '<div class="flex items-center"><i class="fas fa-bath text-blue-500 mr-1"></i>' . htmlspecialchars($property['bathrooms']) . '</div>' : '' ?>
                  <?= !empty($property['parking']) ? '<div class="flex items-center"><i class="fas fa-car text-blue-500 mr-1"></i>' . htmlspecialchars($property['parking']) . '</div>' : '' ?>
                </div>
                <p class="text-gray-700 text-sm mt-2"><?= htmlspecialchars($property['exact_address']) ?></p>
                <a href="propertyview.php?id=<?= $property['id'] ?>" class="mt-auto bg-gray-800 hover:bg-gray-900 text-white py-2 px-4 rounded-full transition-colors text-sm text-center">
                  View Details →
                </a>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-center text-gray-600">No properties found.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- Added White Space -->
  <div class="bg-white py-1"></div>

  <!-- Steps Section -->
  <section class="bg-[#f5f7fa] py-12" data-aos="fade">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-8">It's Easy - Get Started Now!</h2>
      <div class="flex flex-col items-center space-y-6">
        <div class="text-center">
          <h3 class="text-xl font-bold mb-1">01. Let's Chat</h3>
          <p class="text-gray-600">Take the first step. Let us know what time works for you to chat with us!</p>
        </div>
        <div class="text-center">
          <h3 class="text-xl font-bold mb-1">02. Discuss Your Goals</h3>
          <p class="text-gray-600">We'll work with you to understand your financial goals.</p>
        </div>
        <div class="text-center">
          <h3 class="text-xl font-bold mb-1">03. Make It Happen</h3>
          <p class="text-gray-600">We’ll guide you through the entire process stress-free.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php $footer->foot(); ?>

  <!-- WhatsApp Float Button -->
  <a href="https://wa.me/1234567890" class="fixed bottom-8 right-8" target="_blank">
    <img src="whatsapp-icon.png" alt="WhatsApp" class="w-12 h-12">
  </a>

  <!-- Initialize LazyLoad -->
  <script>
    var lazyLoadInstance = new LazyLoad({
      elements_selector: ".lazy"
    });
  </script>
  <!-- Initialize AOS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: false
    });
  </script>
</body>
</html>