<?php
include_once('../header.php');

$userId = $_SESSION['user_id'];
$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo '<div class="container py-5"><div class="alert alert-danger">Order not specified. <a href="orders.php">Back to Orders</a></div></div>';
    exit;
}

// Fetch order
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$orderId, $userId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo '<div class="container py-5"><div class="alert alert-danger">Order not found. <a href="orders.php">Back to Orders</a></div></div>';
    exit;
}

// Fetch order items
$stmt = $pdo->prepare("SELECT oi.*, p.name as product_name, p.color, p.images FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmt->execute([$orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<body>
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
                  <a class="nav-link" href="../index.php#about">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../users/contact.php">Contact</a>
                </li>
            </ul>
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
        <h2 class="mb-4">Order Details</h2>
        <div class="container py-4">
            <a href="orders.php" class="btn btn-outline-primary mb-5">&larr; Back to Orders</a>
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Order #<?= htmlspecialchars($order['order_number']) ?></h4>
                                <span class="badge 
                                    <?php
                                        switch($order['order_status']) {
                                            case 'pending': echo 'bg-warning'; break;
                                            case 'processing': echo 'bg-info'; break;
                                            case 'shipped': echo 'bg-primary'; break;
                                            case 'delivered': echo 'bg-success'; break;
                                            case 'cancelled': echo 'bg-danger'; break;
                                            default: echo 'bg-secondary';
                                        }
                                    ?>
                                    px-3 py-2">
                                    <?= ucfirst($order['order_status']) ?>
                                </span>
                            </div>
                        </div>

<div class="col-md-4">
                    <div class="card shadow-sm border-0 position-sticky" style="top: 100px;">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Order Number</span>
                                    <strong><?= htmlspecialchars($order['order_number']) ?></strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Status</span>
                                    <span class="badge 
                                        <?php
                                            switch($order['order_status']) {
                                                case 'pending': echo 'bg-warning'; break;
                                                case 'processing': echo 'bg-info'; break;
                                                case 'shipped': echo 'bg-primary'; break;
                                                case 'delivered': echo 'bg-success'; break;
                                                case 'cancelled': echo 'bg-danger'; break;
                                                default: echo 'bg-secondary';
                                            }
                                        ?>">
                                        <?= ucfirst($order['order_status']) ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Order Date</span>
                                    <span><?= date('M d, Y', strtotime($order['created_at'])) ?></span>
                                </div>
                            </div>
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span>₱<?= number_format($order['total_amount'] - $order['shipping_fee'], 2) ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Shipping Fee</span>
                                    <span>₱<?= number_format($order['shipping_fee'], 2) ?></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h6 mb-0">Total</span>
                                <span class="h5 mb-0 text-primary">₱<?= number_format($order['total_amount'], 2) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Order Date</small>
                                        <strong><?= date('M d, Y', strtotime($order['created_at'])) ?></strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Payment Method</small>
                                        <strong><?= strtoupper($order['payment_method']) ?></strong>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Total Amount</small>
                                        <strong class="text-primary">₱<?= number_format($order['total_amount'], 2) ?></strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Shipping Fee</small>
                                        <strong>₱<?= number_format($order['shipping_fee'], 2) ?></strong>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <small class="text-muted d-block">Shipping Address</small>
                                <p class="mb-0 mt-1"><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                            </div>
                        </div>
                    </div>



                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Order Items</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($items as $item): ?>
                                    <div class="list-group-item py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-md-2">
                                                <?php if (!empty($item['images'])): ?>
                                                    <img src="data:image/jpeg;base64,<?= base64_encode($item['images']) ?>" 
                                                         class="img-fluid rounded shadow-sm" 
                                                         alt="<?= htmlspecialchars($item['product_name']) ?>">
                                                <?php else: ?>
                                                    <div class="bg-light text-center rounded py-4">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-9 col-md-6">
                                                <h6 class="mb-1"><?= htmlspecialchars($item['product_name']) ?></h6>
                                                <p class="text-muted small mb-0">Color: <?= htmlspecialchars($item['color']) ?></p>
                                            </div>
                                            <div class="col-4 col-md-1 text-center">
                                                <small class="text-muted d-block mb-1">Qty</small>
                                                <span class="fw-bold"><?= $item['quantity'] ?></span>
                                            </div>
                                            <div class="col-4 col-md-1 text-center">
                                                <small class="text-muted d-block mb-1">Price</small>
                                                <span class="fw-bold">₱<?= number_format($item['price'], 2) ?></span>
                                            </div>
                                            <div class="col-4 col-md-2 text-end">
                                                <small class="text-muted d-block mb-1">Subtotal</small>
                                                <span class="fw-bold text-primary">₱<?= number_format($item['subtotal'], 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </main>
    
</body>