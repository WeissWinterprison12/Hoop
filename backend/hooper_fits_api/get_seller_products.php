<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include "db.php";

$seller_id = intval($_GET['seller_id'] ?? 0);  // 6 or 7

if ($seller_id == 0) {
    echo json_encode(['success' => false, 'error' => 'No seller ID']);
    exit;
}

// ✅ CRITICAL: SAME SECURITY AS SELLER_DASHBOARD.PHP
$result = $conn->query("SELECT role FROM users WHERE id = $seller_id");
if (!$result || $result->num_rows === 0) {
    echo json_encode(["error" => "User ID $seller_id not found"]);
    exit();
}

$row = $result->fetch_assoc();
if (!in_array($row['role'], ['seller', 'admin'])) {
    echo json_encode(["error" => "User $seller_id role '{$row['role']}' - must be seller/admin"]);
    exit();
}

// ✅ YOUR QUERY (PERFECT) - only shows seller's products
$stmt = $conn->prepare("SELECT * FROM products WHERE seller_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    'success' => true, 
    'seller_id' => $seller_id,
    'products' => $products
]);

$stmt->close();
$conn->close();
?>