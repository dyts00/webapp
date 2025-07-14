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
</body>