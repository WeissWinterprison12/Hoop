<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

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

$buyer_id = $data['buyer_id'] ?? null;
$product_id = $data['product_id'] ?? null;

if (!$buyer_id || !$product_id) {
    echo json_encode(['success' => false, 'error' => 'Missing buyer_id or product_id']);
    exit;
}

try {
    $sql = "DELETE FROM cart WHERE buyer_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $buyer_id, $product_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true, 
                'message' => 'Item removed from cart',
                'removed_count' => $stmt->affected_rows
            ]);
        } else {
            echo json_encode(['success' => true, 'message' => 'Item not found in cart']);
        }
    } else {
        throw new Exception('Delete failed: ' . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    error_log('❌ REMOVE CART ERROR: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>