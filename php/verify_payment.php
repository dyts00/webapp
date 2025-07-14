<?php
require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;

$source_id = $_GET['source_id'] ?? null;

if (!$source_id) {
    die('No payment source provided.');
}

$client = new Client([
    'base_uri' => 'https://api.paymongo.com/v1/',
    'auth' => ['sk_test_H9KjUA3SKLYKWwkWBtjVf8pv', ''],
]);

try {
    $response = $client->get("sources/$source_id");
    $body = json_decode($response->getBody(), true);
    $status = $body['data']['attributes']['status'];
    if ($status === 'chargeable') {
        // Payment is successful, update your order in the database
        echo "Payment successful!";
    } else {
        echo "Payment not completed. Status: $status";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>