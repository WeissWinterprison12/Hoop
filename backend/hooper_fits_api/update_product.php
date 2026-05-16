<?php
// update_product.php - UPDATE existing product
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $seller_id = $_POST['seller_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
    // Handle image upload if provided
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../uploads/products/";
        $image_name = $product_id . "_" . time() . ".jpg";
        $target_file = $target_dir . $image_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = "uploads/products/" . $image_name;
        }
    }
    
    // UPDATE query
    $pdo = new PDO("mysql:host=localhost;dbname=your_db", $user, $pass);
    $stmt = $pdo->prepare("
        UPDATE products 
        SET product_name=?, description=?, price=?, stock=?, 
            image=COALESCE(?, image), updated_at=NOW()
        WHERE id=? AND seller_id=?
    ");
    
    $success = $stmt->execute([
        $product_name, $description, $price, $stock,
        $image_path, $product_id, $seller_id
    ]);
    
    echo json_encode([
        'success' => $success && $stmt->rowCount() > 0,
        'error' => $success ? null : 'Update failed'
    ]);
}
?>