<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

ob_start();
$conn = new mysqli("localhost", "root", "", "hooper_fits");
ob_end_clean();

if ($conn->connect_error) {
    http_response_code(500);
    echo "event: error\ndata: " . json_encode(['error' => 'Database connection failed']) . "\n\n";
    exit();
}

$seller_id = intval($_GET['seller_id'] ?? 0);
if (!$seller_id) {
    http_response_code(400);
    echo "event: error\ndata: " . json_encode(['error' => 'Seller ID required']) . "\n\n";
    exit();
}

$result = $conn->query("SELECT id FROM users WHERE id = $seller_id AND role IN ('seller', 'admin')");
if (!$result || $result->num_rows === 0) {
    echo "event: error\ndata: " . json_encode(['error' => 'Invalid seller ID']) . "\n\n";
    exit();
}

echo "event: connected\ndata: " . json_encode(['message' => 'Connected to real-time orders', 'seller_id' => $seller_id]) . "\n\n";
ob_flush();
flush();

$last_order_id = 0;
$conn->set_charset("utf8");


while (true) {

    $result = $conn->query("
        SELECT DISTINCT
            o.id,
            o.buyer_id,
            oi.product_id,
            oi.seller_id,
            oi.quantity,
            oi.price,
            o.total_amount,
            o.status,
            o.created_at,
            p.product_name,
            p.image,
            u.name as buyer_name,
            u.contact as buyer_phone
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        LEFT JOIN users u ON o.buyer_id = u.id
        WHERE oi.seller_id = $seller_id 
        AND o.id > $last_order_id 
        AND o.status = 'pending'
        ORDER BY o.created_at DESC
        LIMIT 5
    ");
    
    if ($result) {
        $new_orders = [];
        while ($row = $result->fetch_assoc()) {
            $last_order_id = max($last_order_id, intval($row['id']));
            
            $new_orders[] = [
                'id' => $row['id'],
                'order_id' => $row['id'],
                'buyer_name' => $row['buyer_name'] ?: 'Anonymous',
                'buyer_phone' => $row['buyer_phone'] ?: 'No contact',
                'product_name' => $row['product_name'],
                'image' => $row['image'],
                'quantity' => intval($row['quantity']),
                'price' => floatval($row['price']),
                'shipping' => 50.00, // Fixed from checkout
                'total' => floatval($row['total_amount']),
                'date' => date('M j, Y H:i', strtotime($row['created_at'])),
                'status' => $row['status'],
                'payment' => 'Cash on Delivery',
                'isLive' => true
            ];
        }
        
        foreach ($new_orders as $order) {
            echo "event: new_order\ndata: " . json_encode($order) . "\n\n";
            ob_flush();
            flush();
        }
    }
    
    sleep(2);
}

$conn->close();
?>