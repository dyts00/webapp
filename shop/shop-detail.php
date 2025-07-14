<?php session_start(); ?>
<!doctype html>
<html class="h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="description" content="Skye Interior Design Services - Product Details">
    <meta name="author" content="Skye Interior Design Services">
    <meta name="HandheldFriendly" content="true">
    <title>Shop Detail - Skye Blinds Interior Design Services</title>
    <!-- CSS FILES -->
    <link rel="stylesheet" href="css/theme.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;300;400;600;700&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/owl.carousel.min.css" rel="stylesheet">
    <link href="css/card.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon/favicon.ico">
  </head>
  <body class="bg-gray-100" data-bs-spy="scroll" data-bs-target="#navScroll">
    <!-- Navbar (from index.html) -->
    <nav id="navScroll" class="navbar navbar-expand-lg navbar-light fixed-top" tabindex="0">
      <div class="container">
        <a class="navbar-brand pe-4 fs-4" href="index.html">
          <img src="favicon/favicon.ico" alt="Skye Logo" style="height:40px; width:auto; vertical-align:middle; margin-right:8px;">
          <span class="ms-1 fw-bolder">Skye Blinds Interior Design Services</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link" href="index.html#gallery">Gallery</a>
                </li>
                <!-- Products Dropdown Start -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="index.html#products" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Products
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                    <li><a class="dropdown-item" href="shop-detail.html">Product Details</a></li>
                    <li><a class="dropdown-item" href="shop-listing.html">Product Listing</a></li>
                  </ul>
                </li>
                <!-- Products Dropdown End -->
                <li class="nav-item">
                  <a class="nav-link" href="index.html#services">Services</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.html#about">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.html#contact">Contact</a>  
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Wishlist</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Cart</a>
                </li>
              </ul>
        </div>
      </div>
    </nav>

    <main style="padding-top:80px;">
      <!-- Header Section -->
      <header class="site-header d-flex justify-content-center align-items-center mb-4" style="min-height:120px;">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-12 text-center" data-aos="fade-down">
              <h1 class="display-6">Products Detail</h1>
            </div>
          </div>
        </div>
      </header>

      <!-- Shop Detail Bar -->
      <section class="bg-white py-3 mb-4 rounded shadow-sm" data-aos="fade-up">
        
      </section>

      <!-- Product Sections (content unchanged, just styled and animated) -->
      <section class="shop-detail-section section-padding" data-aos="fade-right">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 col-12 m-auto">
              <div class="custom-block shop-detail-custom-block bg-white p-4 rounded shadow-sm">
                <h3 class="mb-3">Combi Blinds</h3>
                <p>Combi blinds are a versatile and stylish window treatment option that combines the functionality of both sheer and blackout blinds. They allow you to control light and privacy effortlessly.</p>
                <p>Perfect for modern homes and offices, combi blinds come in a variety of colors and patterns to match your interior design.</p>
                <form method="post" action="cart.php">
                  <input type="hidden" name="add_product" value="combi_blinds">
                  <button type="submit" class="btn btn-warning btn-sm rounded-pill">Add to Cart</button>
                </form>
              </div>
            </div>
            <div class="col-lg-6 col-12" data-aos="fade-left">
              <div class="shop-image-wrap text-center">
                <img src="images/slideshow/combi.jpg" class="shop-image img-fluid rounded shadow" alt="Combi Blinds">
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="shop-detail-section section-padding section-bg" data-aos="fade-left">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 col-12" data-aos="fade-right">
              <div class="shop-image-wrap text-center">
                <img src="images/slideshow/blackout.jpg" class="shop-image img-fluid rounded shadow" alt="Blackout Blinds">
              </div>
            </div>
            <div class="col-lg-6 col-12 m-auto">
              <div class="custom-block shop-detail-custom-block bg-white p-4 rounded shadow-sm">
                <h3 class="mb-3">Blackout Blinds</h3>
                <p>Blackout blinds are designed to block out sunlight completely, making them ideal for bedrooms, media rooms, or any space where you need maximum light control.</p>
                <p>They are available in various fabrics and colors to suit your preferences.</p>
                <form method="post" action="cart.php">
                  <input type="hidden" name="add_product" value="blackout_blinds">
                  <button type="submit" class="btn btn-warning btn-sm rounded-pill">Add to Cart</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="shop-detail-section section-padding section-bg" data-aos="fade-right">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 col-12" data-aos="fade-left">
              <div class="shop-image-wrap text-center">
                <img src="images/home/Roman-Blinds.jpg" class="shop-image img-fluid rounded shadow" alt="Roman Blinds">
              </div>
            </div>
            <div class="col-lg-6 col-12 m-auto">
              <div class="custom-block shop-detail-custom-block bg-white p-4 rounded shadow-sm">
                <h3 class="mb-3">Roman Blinds</h3>
                <p>"Elegance Meets Functionality" - Roman blinds bring a touch of sophistication to any room. Their soft, pleated design adds warmth and texture to your interiors.</p>
                <p>Available in a wide range of fabrics, patterns, and colors, Roman blinds are perfect for creating a cozy and stylish ambiance in your living spaces.</p>
                <form method="post" action="cart.php">
                  <input type="hidden" name="add_product" value="roman_blinds">
                  <button type="submit" class="btn btn-warning btn-sm rounded-pill">Add to Cart</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="shop-detail-section section-padding" data-aos="fade-left">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 col-12 m-auto">
              <div class="custom-block shop-detail-custom-block bg-white p-4 rounded shadow-sm">
                <h3 class="mb-3">Roller Blinds</h3>
                <p>"Simplicity at Its Best" - Roller blinds are a timeless choice for modern homes. They offer a sleek and minimalistic look while providing excellent light control and privacy.</p>
                <p>Choose from blackout, sunscreen, or light-filtering fabrics to suit your needs. Roller blinds are easy to operate and maintain, making them a practical yet stylish solution.</p>
                <form method="post" action="cart.php">
                  <input type="hidden" name="add_product" value="roller_blinds">
                  <button type="submit" class="btn btn-warning btn-sm rounded-pill">Add to Cart</button>
                </form>
              </div>
            </div>
            <div class="col-lg-6 col-12" data-aos="fade-right">
              <div class="shop-image-wrap text-center">
                <img src="images/home/rollerblinds.jpg" class="shop-image img-fluid rounded shadow" alt="Roller Blinds">
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="shop-detail-section section-padding section-bg" data-aos="fade-right">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 col-12" data-aos="fade-left">
              <div class="shop-image-wrap text-center">
                <img src="images/home/venetians.jpg" class="shop-image img-fluid rounded shadow" alt="Venetian Blinds">
              </div>
            </div>
            <div class="col-lg-6 col-12 m-auto">
              <div class="custom-block shop-detail-custom-block bg-white p-4 rounded shadow-sm">
                <h3 class="mb-3">Venetian Blinds</h3>
                <p>"Classic Style, Modern Appeal" - Venetian blinds are a versatile option that complements any decor. Their adjustable slats allow you to control light and privacy effortlessly.</p>
                <p>Available in wood, aluminum, or PVC, Venetian blinds are durable and easy to clean, making them ideal for kitchens, bathrooms, and offices.</p>
                <form method="post" action="cart.php">
                  <input type="hidden" name="add_product" value="venetian_blinds">
                  <button type="submit" class="btn btn-warning btn-sm rounded-pill">Add to Cart</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="shop-detail-section section-padding" data-aos="fade-left">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 col-12 m-auto">
              <div class="custom-block shop-detail-custom-block bg-white p-4 rounded shadow-sm">
                <h3 class="mb-3">Zebra Blinds</h3>
                <p>"The Perfect Balance" - Zebra blinds combine the best of sheer and solid fabrics, offering a unique way to control light and privacy. Their alternating stripes create a modern and dynamic look.</p>
                <p>Ideal for living rooms and offices, Zebra blinds are available in a variety of colors and textures to match your style.</p>
                <form method="post" action="cart.php">
                  <input type="hidden" name="add_product" value="zebra_blinds">
                  <button type="submit" class="btn btn-warning btn-sm rounded-pill">Add to Cart</button>
                </form>
              </div>
            </div>
            <div class="col-lg-6 col-12" data-aos="fade-right">
              <div class="shop-image-wrap text-center">
                <img src="images/home/zebra.jpg" class="shop-image img-fluid rounded shadow" alt="Zebra Blinds">
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="shop-detail-section section-padding pb-0 mt-5" data-aos="fade-up">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-12 mb-4">
              <div class="shop-thumb bg-white rounded shadow-sm h-100">
                <div class="shop-image-wrap text-center">
                  <img src="images/slideshow/vertical2.jpg" class="shop-image img-fluid rounded" alt="Vertical Blinds">
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-12 mb-4">
              <div class="shop-thumb bg-white rounded shadow-sm h-100">
                <div class="shop-image-wrap text-center">
                  <img src="images/slideshow/panel.jpg" class="shop-image img-fluid rounded" alt="Panel Blinds">
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-12 mb-4">
              <div class="shop-thumb bg-white rounded shadow-sm h-100">
                <div class="shop-image-wrap text-center">
                  <img src="images/slideshow/Crease-Combi-Blinds.jpg" class="shop-image img-fluid rounded" alt="Crease Combi Blinds">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

        <div class="container my-5" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12 text-center">
            <div class="p-4 bg-white rounded shadow-sm">
                <h5 class="mb-3">Have you decided which product to purchase?</h5>
                <a href="shop-listing.html" class="btn btn-dark btn-xl">
                    Proceed to Shop Listing
                    <i class="bi bi-arrow-right ms-2"></i>
                  </a>
            </div>
            </div>
        </div>
        </div>

        <!-- Add review form at the bottom -->
        <section class="container my-5">
          <h4>Leave a Review</h4>
          <form method="post" action="reviews.php">
            <input type="hidden" name="product" value="combi_blinds">
            <div class="mb-2">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="mb-2">
              <textarea name="review" class="form-control" placeholder="Your Review" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
          </form>
        </section>
    </main>

    <!-- Footer (from index.html) -->

    <!-- JS Dependencies -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/some.js"></script>
    <script src="js/aos.js"></script>
    <script>
      AOS.init({ duration: 800 });
    </script>
    <script>
      // Navbar scroll shadow (from index.html)
      let scrollpos = window.scrollY;
      const header = document.querySelector(".navbar");
      const header_height = header.offsetHeight;
      const add_class_on_scroll = () => header.classList.add("scrolled", "shadow-sm");
      const remove_class_on_scroll = () => header.classList.remove("scrolled", "shadow-sm");
      window.addEventListener('scroll', function() {
        scrollpos = window.scrollY;
        if (scrollpos >= header_height) { add_class_on_scroll(); }
        else { remove_class_on_scroll(); }
      });
    </script>
  </body>
</html>