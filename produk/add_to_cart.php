<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['id'] ?? null;

    if ($productId) {
        $_SESSION['cart'][] = $productId;
        echo json_encode(['success' => true, 'message' => 'Product added to cart.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
    }
    exit;
}
?>
