<?php
session_start();
require_once('../php/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit();
}
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// cart count
$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    $cartCountStmt = $pdo->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
    $cartCountStmt->execute([$_SESSION['user_id']]);
    $cartCount = $cartCountStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="description" content="Skye Interior Design Services - Your trusted provider of quality window blinds and treatments">
    <meta name="author" content="Skye Interior Design Services">
    <meta name="HandheldFriendly" content="true">
    <title>Skye Blinds Interior Design Services</title>

    <!-- CSS FILES -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="stylesheet" href="../css/theme.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;300;400;600;700&display=swap" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/owl.carousel.min.css" rel="stylesheet">
    <link href="../css/card.css" rel="stylesheet">
    <link href="../css/chatbot.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="../favicon/favicon.ico">
      <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="192x192" href="../favicon/android-chrome-192x192.png">
      <link rel="icon" type="image/png" sizes="512x512" href="../favicon/android-chrome-512x512.png">
      <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
      <link rel="manifest" href="/site.webmanifest">
      <link rel="gif" type="image/gif" href="../chat/AIchatbot.gif">
      <!-- JS FILES -->
      <style>
       
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }
        
        .fade-in-up.active {
            opacity: 1;
            transform: translateY(0);
        }

        .contact-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }

        .social-icon {
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: scale(1.15);
        }

        .form-control {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            transform: translateY(-2px);
        }

        .btn-send {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-send:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn-send:hover:before {
            width: 300px;
            height: 300px;
        }

        .map-container {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            transition: transform 0.3s ease;
        }

        .map-container:hover {
            transform: scale(1.01);
        }

        /* Modern loading animation */
        .loading-dots {
            display: inline-flex;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .loading-dots.active {
            opacity: 1;
        }

        .loading-dots span {
            width: 6px;
            height: 6px;
            margin: 0 2px;
            background: currentColor;
            border-radius: 50%;
            animation: dots 1s infinite;
        }

        .loading-dots span:nth-child(2) { animation-delay: 0.2s; }
        .loading-dots span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes dots {
            0%, 100% { transform: scale(0.5); opacity: 0.5; }
            50% { transform: scale(1); opacity: 1; }
        }

        /* Custom form styles */
        .form-floating > label {
            transition: all 0.3s ease;
        }

        .form-floating > .form-control:focus ~ label {
            transform: translateY(-1.5rem) scale(0.85);
            color: #0d6efd;
        }

        .contact-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        .contact-header {
            text-align: left;
            margin-bottom: 30px;
        }

        .contact-header h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 8px;
        }

        .contact-header p {
            color: #666;
            font-size: 15px;
        }

        .contact-form .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .contact-form .form-control:focus {
            border-color:rgb(157, 204, 162);
            box-shadow: 0 0 0 3px rgba(77, 127, 82, 0.1);
        }

        .contact-form textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn-send {
            background:rgb(204, 211, 112);
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-send:hover {
            background:rgb(81, 92, 17);
            transform: translateY(-2px);
        }

        .contact-info {
            margin-top: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            color: #555;
        }

        .contact-info-item:last-child {
            margin-bottom: 0;
        }

        .contact-info-item img {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            opacity: 0.7;
        }

        .map-container {
            margin-top: 30px;
            border-radius: 12px;
            overflow: hidden;
        }

        .map-container iframe {
            width: 100%;
            height: 250px;
            border: none;
        }

        @media (max-width: 768px) {
            .contact-container {
                padding: 24px;
                margin: 16px;
            }
        }
        .profile-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #0d6efd;
            text-decoration: none;
            margin-left: 15px;
            transition: all 0.3s ease;
        }
        .profile-icon:hover {
            background: #e2e6ea;
            color: #0a58ca;
        }
        .profile-menu {
            min-width: 200px;
        }
        .profile-menu .dropdown-item {
            padding: 8px 16px;
        }
        .profile-menu .dropdown-item i {
            margin-right: 8px;
        }
        .navbar {
            transition: all 0.3s ease;
        }
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }
        .product-image-small {
            max-width: 100px;
            height: auto;
        }
        .order-card {
            margin-bottom: 1rem;
        }
        .status-badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        .rating {
            color: #ffd700;
        }
        .tracking-timeline {
            position: relative;
            padding-left: 30px;
        }
        .tracking-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #0d6efd;
        }
        .nav-pills .nav-link.active {
            background-color: #0d6efd;
        }
        .order-status {
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
               fetch('../php/check_session.php')
                .then(response => response.json())
                .then(data => {
                    const profileContent = document.getElementById('profileContent');
                    if (data.loggedIn) {
                        profileContent.innerHTML = `
                            <li><span class="dropdown-item-text">Hi, ${data.fullname}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../users/profile.php"><i class="fas fa-user-circle"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="../shop/orders.php"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        `;
                    } else {
                        profileContent.innerHTML = `
                            <li><a class="dropdown-item" href="../users/login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                            <li><a class="dropdown-item" href="../users/register.php"><i class="fas fa-user-plus"></i> Register</a></li>
                        `;
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        
      </script>
      <script>
        function handleKeyPress(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                event.target.click();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('chatbot-toggle-btn');
            const chatbotContainer = document.getElementById('chatbot-container');
            let isOpen = false;
            if (toggleBtn && chatbotContainer) {
                toggleBtn.onclick = function() {
                    isOpen = !isOpen;
                    chatbotContainer.style.display = isOpen ? 'block' : 'none';
                    toggleBtn.innerHTML = isOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-robot"></i>';
                };
                document.addEventListener('mousedown', function(e) {
                    if (isOpen && !chatbotContainer.contains(e.target) && !toggleBtn.contains(e.target)) {
                        chatbotContainer.style.display = 'none';
                        toggleBtn.innerHTML = '<i class="fas fa-robot"></i>';
                        isOpen = false;
                    }
                });
            }
        });
      </script>
      
</head>
<body>
<nav id="navScroll" class="navbar navbar-expand-lg navbar-light fixed-top" tabindex="0">
        <div class="container">
          <a class="navbar-brand pe-4 fs-4" href="../index.php">
            <img src="../favicon/favicon.ico" alt="Skye Logo" style="height:40px; width:auto; vertical-align:middle; margin-right:8px;">
            <span class="ms-1 fw-bolder">Skye Blinds Interior Design Services</span>
          </a>
      
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link" href="../index.php#gallery">Gallery</a>
                </li>
                <!-- Products Dropdown Start -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#products" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Products
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                    <li><a class="dropdown-item" href="../shop/productsdetail.php">Product Details</a></li>
                    <li><a class="dropdown-item" href="../shop/products.php">Product Listing</a></li>
                  </ul>
                </li>
                <!-- Products Dropdown End -->
                <li class="nav-item">
                  <a class="nav-link" href="../index.php#services">Services</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../users/contact.php">Contact</a>  
                </li>
              </ul>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <a class="dropdown-item" href="../shop/cart.php">
                        <i class="fas fa-shopping-cart"></i>
                          <?php if ($cartCount > 0): ?>
                              <span class="position-absolute start-200 translate-middle badge rounded-pill bg-danger">
                                <?php echo $cartCount; ?>
                                <span class="visually-hidden">items in cart</span>
                            </span>
                        <?php endif; ?>
                    </a>
              </div>
              <!-- Add Profile Icon -->
              <div class="nav-item dropdown">
                <a href="#" class="profile-icon" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end profile-menu" aria-labelledby="profileDropdown">
                    <div id="profileContent">
                        <!-- Content will be populated by JavaScript -->
                    </div>
                </ul>
            </div>
          </div>
        </div>
      </nav>
 <!-- CHATBOT TOGGLE BUTTON -->
 <button id="chatbot-toggle-btn" style="position:fixed;bottom:30px;right:30px;z-index:2000;background:linear-gradient(135deg,#4776E6,#8E54E9);color:#fff;border:none;border-radius:50%;width:60px;height:60px;box-shadow:0 4px 16px rgba(71,118,230,0.18);display:flex;align-items:center;justify-content:center;font-size:2rem;cursor:pointer;">
        <i class="fas fa-robot"></i>
    </button>

    <!-- Chatbot UI Container (hidden by default) -->
    <div id="chatbot-container" style="display:none; position:fixed; bottom:100px; right:30px; z-index:2000;">
        <div id="welcome-screen" class="welcome-screen">
            <div class="welcome-container">
                <div class="robot-container">
                    <img src="../favicon/AIchatbot.gif" alt="AI Chatbot" class="robot-animation">
                    <div class="speech-bubble">
                        <p>Hola, need our help?</p>
                    </div>
                </div>
                <button id="get-started-btn" class="get-started-btn">Get Started</button>
            </div>
        </div>
        <!-- Chat Interface -->
        <div id="chat-screen" class="chat-screen" style="display: none;">
            <div class="chat-header">
                <img src="../favicon/AIchatbot.gif" alt="AI Assistant" class="ai-avatar">
                <div class="header-text">
                    <h2>Skye Assistant</h2>
                    <p>Online</p>
                </div>
            </div>
            <div class="chat-messages" id="chat-messages">
                <h2 style="text-align: center; margin-top: 20px;">Welcome to Skye Blinds Interior Design Services!</h2>
            </div>
            <div class="chat-input">
                <input type="text" id="user-input" placeholder="Type your message...">
                <button id="send-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <script src="../js/chatbot.js"></script>
    