<?php 
include_once('../header.php');

// filters from params
$category = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$price_range = isset($_GET['price-range']) ? (array)$_GET['price-range'] : [];
$min_price = !empty($price_range) ? min($price_range) : 0;
$max_price = !empty($price_range) ? max($price_range) : PHP_FLOAT_MAX;
$condition = isset($_GET['condition']) ? (array)$_GET['condition'] : [];
$type = isset($_GET['type']) ? (array)$_GET['type'] : [];

// sql query with filters
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if (!empty($category)) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

if (!empty($search)) {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$sql .= " AND price BETWEEN ? AND ?";
$params[] = $min_price;
$params[] = $max_price;

if (!empty($condition) && !in_array('all', $condition)) {
    $placeholders = str_repeat('?,', count($condition) - 1) . '?';
    $sql .= " AND condition_type IN ($placeholders)";
    $params = array_merge($params, $condition);
}

$sql .= " AND status = 'active' ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
  <body class="bg-gray-100" data-bs-spy="scroll" data-bs-target="#navScroll">
    

    <main style="padding-top:80px;">
      <div class="container py-vh-5">
        <div class="row mb-5">
          <div class="col-12 text-center" data-aos="fade-down">
            <h2 class="display-6">Products Listing</h2>
            <p class="lead">Browse our selection of quality window treatments</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-5 col-12 mb-5" data-aos="fade-right">
            <form class="custom-form filter-form bg-white p-4 rounded shadow-sm" action="#" method="get" role="form">
              <div>
                <h6 class="filter-form-small-title">Product</h6>
                <select name="looking-for" class="form-select" id="looking-for" aria-label="Default select example">
                  <option value="0" <?php echo (!isset($_GET['looking-for']) || $_GET['looking-for'] == '0') ? 'selected' : ''; ?>>What you looking for?</option>
                  <option value="1" <?php echo (isset($_GET['looking-for']) && $_GET['looking-for'] == '1') ? 'selected' : ''; ?>>Combi Blinds</option>
                  <option value="2" <?php echo (isset($_GET['looking-for']) && $_GET['looking-for'] == '2') ? 'selected' : ''; ?>>Blackout Blinds</option>
                  <option value="3" <?php echo (isset($_GET['looking-for']) && $_GET['looking-for'] == '3') ? 'selected' : ''; ?>>Vertical Blinds</option>
                  <option value="4" <?php echo (isset($_GET['looking-for']) && $_GET['looking-for'] == '4') ? 'selected' : ''; ?>>Panel Blinds</option>
                </select>
              </div>
              <div class="mt-4">
                <h6 class="filter-form-small-title">Price range</h6>
                <div class="form-check">
                  <input name="price-range[]" type="checkbox" class="form-check-input" id="PriceCheckOne" value="500" <?php echo in_array('500', $price_range) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="PriceCheckOne">below ₱299</label>
                </div>
                <div class="form-check">
                  <input name="price-range[]" type="checkbox" class="form-check-input" id="PriceCheckTwo" value="1000" <?php echo in_array('1000', $price_range) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="PriceCheckTwo">₱300 - ₱499</label>
                </div>
                <div class="form-check">
                  <input name="price-range[]" type="checkbox" class="form-check-input" id="PriceCheckThree" value="5000" <?php echo in_array('5000', $price_range) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="PriceCheckThree">₱500 - ₱799</label>
                </div>
                <div class="form-check">
                  <input name="price-range[]" type="checkbox" class="form-check-input" id="PriceCheckFour" value="10000" <?php echo in_array('10000', $price_range) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="PriceCheckFour">₱800 - ₱1000</label>
                </div>
              </div>
              <div class="mt-4">
                <h6 class="filter-form-small-title">Condition</h6>
                <div class="form-check">
                  <input name="condition[]" type="checkbox" class="form-check-input" id="ConditionCheckOne" value="all" <?php echo in_array('all', $condition) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="ConditionCheckOne">All</label>
                </div>
                <div class="form-check">
                  <input name="condition[]" type="checkbox" class="form-check-input" id="ConditionCheckTwo" value="excellent" <?php echo in_array('excellent', $condition) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="ConditionCheckTwo">Excellent</label>
                </div>
                <div class="form-check">
                  <input name="condition[]" type="checkbox" class="form-check-input" id="ConditionCheckThree" value="better" <?php echo in_array('better', $condition) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="ConditionCheckThree">Better</label>
                </div>
                <div class="form-check">
                  <input name="condition[]" type="checkbox" class="form-check-input" id="ConditionCheckFour" value="good" <?php echo in_array('good', $condition) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="ConditionCheckFour">Good</label>
                </div>
              </div>
              <div class="mt-4">
                <h6 class="filter-form-small-title">Type</h6>
                <div class="form-check">
                  <input name="type[]" type="checkbox" class="form-check-input" id="TypeCheckOne" value="single" <?php echo in_array('single', $type) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="TypeCheckOne">Single</label>
                </div>
                <div class="form-check">
                  <input name="type[]" type="checkbox" class="form-check-input" id="TypeCheckTwo" value="family" <?php echo in_array('family', $type) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="TypeCheckTwo">Family</label>
                </div>
              </div>
              <div class="mt-4">
                <button type="submit" class="btn btn-warning w-100">Apply Filters</button>
              </div>
            </form>
          </div>

          <!-- Shop Listing Section -->
          <div class="col-lg-8 col-md-7 col-12">
            <div class="row g-4">
              <?php if(empty($products)): ?>
                <div class="col-12">
                  <div class="alert alert-info">No products found matching your criteria.</div>
                </div>
              <?php else: ?>
                <?php foreach($products as $product): ?>
                  <div class="col-lg-6 col-12" data-aos="fade-up">
                    <div class="shop-thumb bg-white rounded shadow-sm h-100">
                      <div class="shop-image-wrap position-relative">
                        <?php if($product['id']): ?>
                          <a href="productsdetail.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['images']); ?>" 
                                 class="shop-image img-fluid rounded-top" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                          </a>
                        <?php endif; ?>
                        <div class="shop-icons-wrap position-absolute top-0 end-0 p-2">
                          <a href="#" class="shop-icon bi-heart me-2" aria-label="Add to favorites">
                            <span class="visually-hidden">Add to favorites</span>
                          </a>
                          <a href="#" class="shop-icon bi-bookmark" aria-label="Bookmark product">
                            <span class="visually-hidden">Bookmark product</span>
                          </a>
                        </div>
                        <p class="shop-pricing mb-0 mt-3">
                          <span class="badge bg-primary fs-6">₱<?php echo number_format($product['price'], 2); ?></span>
                        </p>
                        <div class="shop-btn-wrap mt-3">
                          <?php if($product['stock'] > 0): ?>
                            <form method="post" action="cart.php" style="display: inline;">
                              <input type="hidden" name="action" value="add">
                              <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                              <input type="hidden" name="quantity" value="1">
                              <button type="submit" class="btn btn-warning btn-sm rounded-pill">Add to Cart</button>
                            </form>
                          <?php else: ?>
                            <span class="btn btn-secondary btn-sm rounded-pill">Out of Stock</span>
                          <?php endif; ?>
                          <a href="productsdetail.php?id=<?php echo htmlspecialchars($product['id']); ?>" 
                             class="btn btn-dark btn-sm rounded-pill">Learn more</a>
                        </div>
                      </div>
                      <div class="shop-body p-3">
                        <h4 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h4>
                        <p class="product-category text-muted small mb-2"><?php echo htmlspecialchars($product['category']); ?></p>
                        <p class="product-description text-muted"><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?></p>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/some.js"></script>
    <script src="../js/aos.js"></script>
    <script>
      AOS.init({ duration: 800 });
    </script>
    <script>
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