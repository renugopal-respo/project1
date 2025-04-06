<?php
require_once 'components.php';
$footer = new footer();
include "database.php"; // Secure Database Connection

// Get the property ID from the URL
$property_id = $_GET['id'] ?? null;
if (!$property_id) {
    die("Property ID is missing.");
}

// Fetch the property details from the database
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $property_id);
$stmt->execute();
$property = $stmt->get_result()->fetch_assoc();

if (!$property) {
    die("Property not found.");
}

// Fetch related properties (same property_type)
$related_stmt = $conn->prepare("SELECT * FROM properties WHERE property_type = ? AND id != ? LIMIT 3");
if ($related_stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$related_stmt->bind_param("si", $property['property_type'], $property_id);
$related_stmt->execute();
$related_properties = $related_stmt->get_result();

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
  <title>Property View - <?= htmlspecialchars($property['property_type']) ?></title>
  <!-- Tailwind CSS (for basic layout and utility classes) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <!-- AOS Library for Scroll Animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
  <!-- LazyLoad -->
  <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js"></script>
  <!-- Custom CSS -->
  <style>
    html {
      scroll-behavior: smooth;
    }
    body {
      background: #c3cfe2;
      font-family: 'Poppins', sans-serif;
    }
    /* Header Styles */
    header {
      position: sticky;
      top: 0;
      background: #1e3a8a;
      box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1),
                  0 4px 6px -2px rgba(0,0,0,0.05);
      z-index: 50;
    }
    header nav {
      max-width: 1200px;
      margin: 0 auto;
      padding: 1rem 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header nav ul {
      list-style: none;
      display: flex;
      gap: 1.5rem;
    }
    header nav ul li a {
      color: #fff;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    header nav ul li a:hover {
      color: #ef4444;
    }
    /* Property Image Container */
    .image-container {
      position: relative;
    }
    /* Status Badge */
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
    /* Extra Badge for Sq Ft */
    .extra-badge {
      position: absolute;
      bottom: 10px;
      right: 10px;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
      background: #e5e7eb;
      color: #1f2937;
      z-index: 10;
    }
    /* Plain CSS Property Card Style for Related Properties */
    .property-card {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      min-height: 300px;
      margin: 1rem 0;
    }
    .property-card .image-container {
      position: relative;
    }
    .property-card img {
      width: 100%;
      height: 160px; /* Adjust height as needed */
      object-fit: cover;
    }
    .property-card .card-body {
      padding: 16px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .property-card .card-body h3 {
      margin: 0;
      font-size: 16px;
      font-weight: 600;
      color: #1e293b;
    }
    .property-card .card-body p {
      margin: 0;
      font-size: 14px;
      color: #4b5563;
    }
    .property-card .card-body .price {
      font-size: 20px;
      color: #3b82f6;
      font-weight: bold;
    }
    .property-card .card-body .view-details {
      margin-top: auto;
      background: #1f2937;
      color: #ffffff;
      padding: 8px 16px;
      border-radius: 9999px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      transition: background 0.3s ease;
    }
    .property-card .card-body .view-details:hover {
      background: #111827;
    }
    /* Property Grid & Responsive Adjustments */
    .property-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1rem;
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
    /* Other Utility Classes (for discount animations, etc.) */
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
<body class="bg-gray-100">
  <!-- Header -->
  <header class="sticky top-0 bg-blue-900 shadow-lg z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="text-white text-2xl font-bold">MyWebsite</div>
      <ul class="flex space-x-6">
        <li><a href="home.php" class="text-white hover:text-red-500">Home</a></li>
        <li><a href="about.php" class="text-white hover:text-red-500">About</a></li>
        <li><a href="Properties.html" class="text-white hover:text-red-500">Properties</a></li>
        <li><a href="sell.php" class="text-white hover:text-red-500">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Property Details Section -->
  <section class="container mx-auto px-4 py-16 relative">
    <!-- Carousel/Images Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
      <?php for ($i = 1; $i <= 4; $i++): ?>
        <?php if (!empty($property['image' . $i])): ?>
          <img src="<?= htmlspecialchars($property['image' . $i]) ?>" alt="Property Image <?= $i ?>" class="w-full h-64 object-cover rounded-lg">
        <?php endif; ?>
      <?php endfor; ?>
    </div>

    <!-- Property Details -->
    <div class="p-6 relative">
      <!-- Property Type and Rent/Sale Tag -->
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($property['property_type']) ?></h1>
        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
          <?= strtoupper($property['rent_sale']) ?>
        </span>
      </div>
      <!-- Location -->
      <div class="flex items-center mb-4">
        <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
        <span class="text-gray-700"><?= htmlspecialchars($property['exact_address']) ?>, <?= htmlspecialchars($property['location']) ?></span>
      </div>
      <!-- Price -->
      <p class="text-blue-500 font-bold text-2xl mb-4">$<?= number_format($property['amount'], 2) ?></p>
      <!-- Agent Phone (Bottom-Right Corner) -->
      <div class="absolute bottom-4 right-4 bg-blue-900 text-white px-4 py-2 rounded-lg shadow-lg flex items-center">
        <i class="fas fa-phone mr-2"></i>
        <a href="tel:+1234567890" class="hover:underline">+1 (234) 567-890</a>
      </div>
      <!-- Property Features -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <?php if (!empty($property['bedrooms'])): ?>
          <div class="flex items-center">
            <i class="fas fa-bed text-blue-500 mr-2"></i>
            <span class="text-gray-600"><?= htmlspecialchars($property['bedrooms']) ?> Bedrooms</span>
          </div>
        <?php endif; ?>
        <?php if (!empty($property['bathrooms'])): ?>
          <div class="flex items-center">
            <i class="fas fa-bath text-blue-500 mr-2"></i>
            <span class="text-gray-600"><?= htmlspecialchars($property['bathrooms']) ?> Bathrooms</span>
          </div>
        <?php endif; ?>
        <?php if (!empty($property['square_feet'])): ?>
          <div class="flex items-center">
            <i class="fas fa-ruler-combined text-blue-500 mr-2"></i>
            <span class="text-gray-600"><?= htmlspecialchars($property['square_feet']) ?> Sq Ft</span>
          </div>
        <?php endif; ?>
        <?php if (!empty($property['balcony'])): ?>
          <div class="flex items-center">
            <i class="fas fa-archway text-blue-500 mr-2"></i>
            <span class="text-gray-600"><?= htmlspecialchars($property['balcony']) ?> Balcony</span>
          </div>
        <?php endif; ?>
        <?php if (!empty($property['water_source'])): ?>
          <div class="flex items-center">
            <i class="fas fa-tint text-blue-500 mr-2"></i>
            <span class="text-gray-600"><?= htmlspecialchars($property['water_source']) ?></span>
          </div>
        <?php endif; ?>
        <?php if (!empty($property['parking'])): ?>
          <div class="flex items-center">
            <i class="fas fa-car text-blue-500 mr-2"></i>
            <span class="text-gray-600"><?= htmlspecialchars($property['parking']) ?> Parking</span>
          </div>
        <?php endif; ?>
        <?php if (!empty($property['facing'])): ?>
          <div class="flex items-center">
            <i class="fas fa-compass text-blue-500 mr-2"></i>
            <span class="text-gray-600"><?= htmlspecialchars($property['facing']) ?> Facing</span>
          </div>
        <?php endif; ?>
        <?php if (!empty($property['possession'])): ?>
          <div class="flex items-center">
            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
            <span class="text-gray-600"><?= htmlspecialchars($property['possession']) ?> Possession</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Special Description Based on Property Type -->
      <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Description</h2>
        <p class="text-gray-600">
          <?php
          switch ($property['property_type']) {
            case 'land':
              echo "This is a prime piece of land located in a highly sought-after area. Ideal for commercial or residential development.";
              break;
            case 'house':
              echo "A beautiful family home with modern amenities and spacious rooms. Perfect for a growing family.";
              break;
            case 'plots':
              echo "Well-maintained plots available for immediate construction. Great investment opportunity.";
              break;
            case 'apartment':
              echo "A luxurious apartment with stunning views and top-notch facilities. Perfect for urban living.";
              break;
            default:
              echo "This property offers great value for money. Don't miss out on this opportunity!";
          }
          ?>
        </p>
      </div>

      <!-- General Description -->
      <?php if (!empty($property['description'])): ?>
        <div class="mb-6">
          <h2 class="text-xl font-bold text-gray-800 mb-2">Description</h2>
          <p class="text-gray-600"><?= htmlspecialchars($property['description']) ?></p>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Related Properties Section (Plain CSS Property Card Style) -->
  <section class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-8">🏡 Related Properties</h2>
    <div class="property-grid grid gap-8">
      <?php if ($related_properties->num_rows > 0): ?>
        <?php while ($related_property = $related_properties->fetch_assoc()): ?>
          <div class="property-card">
            <div class="image-container">
              <img src="<?= htmlspecialchars($related_property['image1']) ?>" alt="Property Image">
              <div class="status-badge <?= $related_property['rent_sale'] === 'rent' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= $related_property['rent_sale'] === 'rent' ? 'Rent (' . htmlspecialchars($related_property['current_stage']) . ')' : 'For Sale' ?>
              </div>
            </div>
            <div class="card-body">
              <h3><?= htmlspecialchars($related_property['location']) ?></h3>
              <p class="price">$<?= number_format($related_property['amount'], 2) ?><?= $related_property['rent_sale'] === 'rent' ? '/mo' : '' ?></p>
			  <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                  <?= !empty($property['bedrooms']) ? '<div class="flex items-center"><i class="fas fa-bed text-blue-500 mr-1"></i>' . htmlspecialchars($property['bedrooms']) . '</div>' : '' ?>
                  <?= !empty($property['bathrooms']) ? '<div class="flex items-center"><i class="fas fa-bath text-blue-500 mr-1"></i>' . htmlspecialchars($property['bathrooms']) . '</div>' : '' ?>
                  <?= !empty($property['parking']) ? '<div class="flex items-center"><i class="fas fa-car text-blue-500 mr-1"></i>' . htmlspecialchars($property['parking']) . '</div>' : '' ?>
                </div>
              <p><?= htmlspecialchars($related_property['exact_address']) ?></p>
              <a href="propertyview.php?id=<?= $related_property['id'] ?>" class="view-details">View Details →</a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center text-gray-600">No related properties found.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- White Gap -->
  <div class="section-gap"></div>

  <!-- Footer -->
  <?php $footer->foot(); ?>

  <!-- WhatsApp Float Button -->
  <a href="https://wa.me/1234567890" class="fixed bottom-8 right-8" target="_blank">
    <img src="whatsapp-icon.png" alt="WhatsApp" class="w-12 h-12">
  </a>

  <!-- Carousel Script -->
  <script>
    // Gather all non-empty images from property (for carousel)
    const images = [];
    <?php for ($i = 1; $i <= 4; $i++): ?>
      <?php if (!empty($property['image' . $i])): ?>
        images.push("<?= addslashes($property['image' . $i]) ?>");
      <?php endif; ?>
    <?php endfor; ?>

    // Fallback if no images found
    if (images.length === 0) {
      images.push("https://via.placeholder.com/1000x500/FFC0CB/000000?text=No+Images");
    }

    let currentIndex = 0;
    const carouselImage = document.getElementById("carouselImage");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    // Display the first image
    carouselImage.src = images[currentIndex];

    // Prev/Next button logic
    prevBtn.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      carouselImage.src = images[currentIndex];
    });
    nextBtn.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % images.length;
      carouselImage.src = images[currentIndex];
    });
  </script>

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
