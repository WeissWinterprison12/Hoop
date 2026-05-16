<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$buyer_id = $data['buyer_id'] ?? null;
$total = $data['total'] ?? 0;
$items = $data['items'] ?? [];

// ✅ Validation
if (!$buyer_id || $total <= 0 || empty($items)) {
    echo json_encode(['success' => false, 'error' => 'Missing required data']);
    exit;
}

try {
    include 'db.php';
    $conn->autocommit(false);
    
    // ✅ FIXED: Match YOUR orders table structure (NO subtotal/shipping columns!)
    $order_sql = "INSERT INTO orders (buyer_id, total_amount, status) VALUES (?, ?, 'pending')";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bind_param("id", $buyer_id, $total);
    $order_stmt->execute();
    $order_id = $conn->insert_id;
    $order_stmt->close();
    
    error_log("✅ Order created: ID=$order_id, buyer_id=$buyer_id, total=$total");
    
    // Step 2: Process items
    $item_sql = "INSERT INTO order_items (order_id, product_id, seller_id, quantity, price) VALUES (?, ?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_sql);
    
    $stock_sql = "UPDATE products SET stock = stock - ? WHERE id = ?";
    $stock_stmt = $conn->prepare($stock_sql);
    
    foreach ($items as $item) {
        $product_id = $item['id'];
        $seller_id = $item['seller_id'] ?? null;
        $quantity = $item['quantity'];
        $price = $item['price'];
        
        error_log("Processing item: product_id=$product_id, seller_id=$seller_id, qty=$quantity");
        
        // Insert order item
        $item_stmt->bind_param("iiidi", $order_id, $product_id, $seller_id, $quantity, $price);
        $item_stmt->execute();
        
        // Update stock
        $stock_stmt->bind_param("ii", $quantity, $product_id);
        $stock_stmt->execute();
    }
    
    $item_stmt->close();
    $stock_stmt->close();
    
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'order_id' => $order_id,
        'message' => 'Order placed successfully!'
    ]);
    
} catch (Exception $e) {
    $conn->rollback();
    error_log('Place order error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $conn->autocommit(true);
}
?>