<?php
include_once('../header.php');


$userId = $_SESSION['user_id'];
$successMessage = '';

// POST actions (add/update/remove)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['product_id'], $_POST['quantity'])) {
                    $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)
                                         ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
                    $stmt->execute([$userId, $_POST['product_id'], $_POST['quantity']]);
                    $successMessage = 'Item added to cart successfully!';
                }
                break;

            case 'update':
                if (isset($_POST['cart_id'], $_POST['quantity'])) {
                    $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
                    $stmt->execute([$_POST['quantity'], $_POST['cart_id'], $userId]);
                }
                break;

            case 'remove':
                if (isset($_POST['cart_id'])) {
                    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
                    $stmt->execute([$_POST['cart_id'], $userId]);
                }
                break;

            case 'checkout':
                if (isset($_POST['selected_items']) && !empty($_POST['selected_items'])) {
                    $_SESSION['checkout_items'] = $_POST['selected_items'];
                    header('Location: checkout.php');
                    exit();
                }
        }
    }
}

// Fetch ng carts items
$stmt = $pdo->prepare("
    SELECT c.*, p.name, p.price, p.images, p.stock
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$subtotal = 0;
$shipping = 100; // Fixed sf
foreach ($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$total = $subtotal + $shipping;
?>
<body data-bs-spy="scroll" data-bs-target="#navScroll" style="background:#fff;">
    <nav id="navScroll" class="navbar navbar-expand-lg navbar-light fixed-top" aria-label="Main navigation">
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#products" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                            <li><a class="dropdown-item" href="productsdetail.php">Product Details</a></li>
                            <li><a class="dropdown-item" href="products.php">Product Listing</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../users/contact.php">Contact</a>
                    </li>
                </ul>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <a class="dropdown-item" href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                          <?php if ($cartCount > 0): ?>
                              <span class="position-absolute start-200 translate-middle badge rounded-pill bg-danger">
                                <?php echo $cartCount; ?>
                                <span class="visually-hidden">items in cart</span>
                            </span>
                        <?php endif; ?>
                    </a>
              </div>
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

    <main class="container py-5" style="margin-top: 60px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Shopping Cart</h2>
            <?php if (!empty($cartItems)): ?>
                <div class="cart-count">
                    <span class="badge bg-primary rounded-pill fs-6">
                        <?php 
                        $totalItems = array_reduce($cartItems, function($sum, $item) {
                            return $sum + $item['quantity'];
                        }, 0);
                        echo $totalItems . ' ' . ($totalItems === 1 ? 'item' : 'items'); 
                        ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if ($successMessage): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($successMessage); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <div class="card">
            <div class="cart-empty">
                <i class="fas fa-shopping-cart mb-3"></i>
                <h3>Your cart is empty</h3>
                <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
                <div class="continue-shopping">
                    <a href="products.php" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
            </div>
        <?php else: ?>
            <form method="POST" action="cart.php">
                <input type="hidden" name="action" value="checkout">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <?php foreach ($cartItems as $item): ?>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-auto">
                                            <input type="checkbox" name="selected_items[]" 
                                                   value="<?= htmlspecialchars($item['id']) ?>" 
                                                   class="cart-item-checkbox form-check-input"
                                                   checked>
                                        </div>
                                        <div class="col-auto">
                                            <img src="data:image/jpeg;base64,<?= base64_encode($item['images']) ?>" 
                                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                                 class="cart-item-image">
                                        </div>
                                        <div class="col">
                                            <h5><?= htmlspecialchars($item['name']) ?></h5>
                                            <p class="text-muted mb-0">₱<?= number_format($item['price'], 2) ?></p>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group quantity-input">
                                                <button type="button" class="btn btn-outline-secondary quantity-decrease">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantity[<?= $item['id'] ?>]" 
                                                       value="<?= $item['quantity'] ?>" 
                                                       min="1" max="<?= $item['stock'] ?>" 
                                                       class="form-control text-center quantity-value"
                                                       data-cart-id="<?= $item['id'] ?>">
                                                <button type="button" class="btn btn-outline-secondary quantity-increase">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="fw-bold">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-link text-danger remove-item" 
                                                    data-cart-id="<?= $item['id'] ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card cart-summary">
                            <div class="card-body">
                                <h4 class="card-title">Order Summary</h4>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>₱<?= number_format($subtotal, 2) ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping Fee</span>
                                    <span>₱<?= number_format($shipping, 2) ?></span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold">₱<?= number_format($total, 2) ?></span>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" id="checkoutBtn">
                                    <i class="fas fa-shopping-cart me-2"></i>Proceed to Checkout
                                </button>
                                <a href="products.php" class="btn btn-outline-secondary w-100 mt-2">
                                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity
            document.querySelectorAll('.quantity-decrease, .quantity-increase').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity-value');
                    const currentValue = parseInt(input.value);
                    const maxValue = parseInt(input.getAttribute('max'));
                    
                    if (this.classList.contains('quantity-decrease')) {
                        if (currentValue > 1) {
                            input.value = currentValue - 1;
                            updateQuantity(input);
                        }
                    } else {
                        if (currentValue < maxValue) {
                            input.value = currentValue + 1;
                            updateQuantity(input);
                        }
                    }
                });
            });

            // Quantity manual input
            document.querySelectorAll('.quantity-value').forEach(input => {
                input.addEventListener('change', function() {
                    updateQuantity(this);
                });
            });

            // remove item
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove this item?')) {
                        const cartId = this.dataset.cartId;
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.innerHTML = `
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="cart_id" value="${cartId}">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            // Update quantity
            function updateQuantity(input) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="cart_id" value="${input.dataset.cartId}">
                    <input type="hidden" name="quantity" value="${input.value}">
                `;
                document.body.appendChild(form);
                form.submit();
            }

            // Handle Checkout
            function updateCheckoutButton() {
                const checkedItems = document.querySelectorAll('.cart-item-checkbox:checked');
                const checkoutBtn = document.getElementById('checkoutBtn');
                checkoutBtn.disabled = checkedItems.length === 0;
            }

            document.querySelectorAll('.cart-item-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateCheckoutButton);
            });

            updateCheckoutButton();
        });

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
</body>
</html>