<?php
require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;

$order_id = $_POST['order_id'] ?? null;
$amount = isset($_POST['amount']) ? intval($_POST['amount']) : null;

if (!$order_id || !$amount) {
    die('Invalid payment request.');
}

$redirect_url = 'https://yourdomain.com/shop/order_confirmed.php?order_id=' . urlencode($order_id);

$client = new Client([
    'base_uri' => 'https://api.paymongo.com/v1/',
    'auth' => ['sk_test_H9KjUA3SKLYKWwkWBtjVf8pv', ''], // Replace with your PayMongo secret key
]);

try {
    $response = $client->post('sources', [
        'json' => [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'redirect' => [
                        'success' => $redirect_url,
                        'failed' => $redirect_url . '?status=failed'
                    ],
                    'type' => 'gcash',
                    'currency' => 'PHP'
                ]
            ]
        ]
    ]);
    $body = json_decode($response->getBody(), true);
    $checkout_url = $body['data']['attributes']['redirect']['checkout_url'];
    header("Location: $checkout_url");
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
