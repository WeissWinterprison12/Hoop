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
$reason = $data['reason'] ?? '';

if (!$buyer_id) {
    echo json_encode(['success' => false, 'error' => 'Missing buyer_id']);
    exit;
}

try {
    include 'db.php';
    
    // Simply CLEAR the cart table
    $sql = "DELETE FROM cart WHERE buyer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $buyer_id);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Cart cleared successfully!',
            'reason' => $reason,
            'deleted_rows' => $stmt->affected_rows
        ]);
    } else {
        throw new Exception('Failed to clear cart');
    }
    
} catch (Exception $e) {
    error_log('Cancel error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>