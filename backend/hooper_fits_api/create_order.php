<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');

// ✅ Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
error_log('📦 ORDER DATA RECEIVED: ' . print_r($data, true)); // Debug log

$buyer_id = $data['buyer_id'] ?? null;
$total_amount = $data['total_amount'] ?? 0;
$items = $data['items'] ?? [];

if (!$buyer_id || $total_amount <= 0 || empty($items)) {
    echo json_encode(['success' => false, 'error' => 'Missing required data: buyer_id, total_amount, or items']);
    exit;
}

try {
    $conn->autocommit(false);
    
    // Step 1: Create ORDER
    $order_sql = "INSERT INTO orders (buyer_id, total_amount, status) VALUES (?, ?, 'pending')";
    $order_stmt = $conn->prepare($order_sql);
    if (!$order_stmt) {
        throw new Exception('Order prepare failed: ' . $conn->error);
    }
    $order_stmt->bind_param("dd", $buyer_id, $total_amount); // ✅ FIXED: "dd" not "id"
    $order_stmt->execute();
    $order_id = $conn->insert_id;
    $order_stmt->close();
    
    // Step 2: Create ORDER_ITEMS & Update STOCK
    $item_sql = "INSERT INTO order_items (order_id, product_id, seller_id, quantity, price) VALUES (?, ?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_sql);
    if (!$item_stmt) {
        throw new Exception('Item prepare failed: ' . $conn->error);
    }
    
    $stock_sql = "UPDATE products SET stock = stock - ? WHERE id = ?";
    $stock_stmt = $conn->prepare($stock_sql);
    if (!$stock_stmt) {
        throw new Exception('Stock prepare failed: ' . $conn->error);
    }
    
    foreach ($items as $item) {
        $product_id = $item['product_id'] ?? $item['id'];
        $seller_id = $item['seller_id'] ?? null;
        $quantity = $item['quantity'];
        $price = $item['price'];
        
        // Insert order item
        $item_stmt->bind_param("iiidi", $order_id, $product_id, $seller_id, $quantity, $price);
        if (!$item_stmt->execute()) {
            throw new Exception('Item insert failed: ' . $item_stmt->error);
        }
        
        // Update product stock
        $stock_stmt->bind_param("ii", $quantity, $product_id);
        if (!$stock_stmt->execute()) {
            throw new Exception('Stock update failed: ' . $stock_stmt->error);
        }
    }
    
    $item_stmt->close();
    $stock_stmt->close();
    
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'order_id' => $order_id,
        'message' => 'Order created successfully!'
    ]);
    
} catch (Exception $e) {
    $conn->rollback();
    error_log('❌ ORDER ERROR: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $conn->autocommit(true);
}
?>