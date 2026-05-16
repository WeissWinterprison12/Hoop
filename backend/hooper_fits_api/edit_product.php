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

$product_id = intval($_POST['product_id'] ?? 0);
$seller_id = intval($_POST['seller_id'] ?? 0);

if (!$product_id || !$seller_id) {
    echo json_encode(['success' => false, 'error' => 'Missing product_id or seller_id']);
    exit;
}

// ✅ VERIFY SELLER FIRST
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

$product_name = trim($_POST['product_name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);

$upload_dir = 'uploads/products/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($file_extension, $allowed_extensions)) {
        $image_path = 'product_' . $product_id . '_' . time() . '.' . $file_extension;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_path)) {
            echo json_encode(['success' => false, 'error' => 'Failed to save image']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid image format']);
        exit;
    }
}

// ✅ VERIFY PRODUCT BELONGS TO SELLER
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();
$current_product = $result->fetch_assoc();

if (!$current_product) {
    echo json_encode(['success' => false, 'error' => 'Product not found or access denied']);
    exit;
}

// Delete old image
if ($image_path && $current_product['image'] && file_exists($upload_dir . $current_product['image'])) {
    unlink($upload_dir . $current_product['image']);
}

$sql = "UPDATE products SET product_name = ?, description = ?, price = ?, stock = ?";
$params = [$product_name, $description, $price, $stock];
$types = "ssdi";

if ($image_path) {
    $sql .= ", image = ?";
    $params[] = $image_path;
    $types .= "s";
}

$sql .= " WHERE id = ? AND seller_id = ?";
$params[] = $product_id;
$params[] = $seller_id;
$types .= "ii";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode([
        'success' => true, 
        'message' => 'Product updated successfully!',
        'seller_id' => $seller_id
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'No changes made or update failed']);
}

$stmt->close();
$conn->close();
?>