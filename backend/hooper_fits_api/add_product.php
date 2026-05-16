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

$seller_id = intval($_POST['seller_id'] ?? 0);

// ✅ SAME SECURITY CHECK AS DASHBOARD
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

$upload_dir = 'uploads/products/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$product_name = trim($_POST['product_name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);
$image_name = null;

// Handle image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image_name = time() . '_' . basename($_FILES['image']['name']);
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
        echo json_encode(['success' => false, 'error' => 'Image upload failed']);
        exit;
    }
}

if (empty($product_name) || $price <= 0 || $stock <= 0) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid required fields']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO products (seller_id, product_name, description, price, image, stock) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issdsi", $seller_id, $product_name, $description, $price, $image_name, $stock);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true, 
        'id' => $conn->insert_id,
        'seller_id' => $seller_id
    ]);
} else {
    if ($image_name && file_exists($upload_dir . $image_name)) {
        unlink($upload_dir . $image_name);
    }
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>