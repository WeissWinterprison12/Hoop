<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

include "db.php";

$data = json_decode(file_get_contents('php://input'), true);
$product_id = intval($data['product_id'] ?? 0);
$seller_id = intval($data['seller_id'] ?? 0);

if (!$product_id || !$seller_id) {
    echo json_encode(['success' => false, 'error' => 'Product ID and seller ID required']);
    exit;
}

// ✅ VERIFY SELLER EXISTS AND HAS RIGHT ROLE
$result = $conn->query("SELECT role FROM users WHERE id = $seller_id");
if (!$result || $result->num_rows === 0) {
    echo json_encode(["error" => "Seller ID $seller_id not found"]);
    exit();
}

$row = $result->fetch_assoc();
if (!in_array($row['role'], ['seller', 'admin'])) {
    echo json_encode(["error" => "User $seller_id role '{$row['role']}' - must be seller/admin"]);
    exit();
}

// ✅ ONLY DELETE OWN PRODUCTS
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo json_encode(['success' => false, 'error' => 'Product not found or access denied']);
    exit;
}

// Delete image file
if ($product['image']) {
    $imagePath = 'uploads/products/' . $product['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

// Delete from database
$deleteStmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
$deleteStmt->bind_param("ii", $product_id, $seller_id);

if ($deleteStmt->execute()) {
    echo json_encode(['success' => true, 'seller_id' => $seller_id]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$deleteStmt->close();
$conn->close();
?>