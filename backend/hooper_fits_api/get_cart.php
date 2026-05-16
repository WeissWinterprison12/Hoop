<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

include 'db.php';

$buyer_id = $_GET['buyer_id'] ?? null;
if (!$buyer_id) {
    echo json_encode(['success' => false, 'error' => 'Missing buyer_id']);
    exit;
}

try {
    $sql = "SELECT 
                c.id,
                c.product_id,
                c.quantity,
                p.product_name,
                p.image,
                p.price,
                p.seller_id
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.buyer_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $buyer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cart = [];
    while ($row = $result->fetch_assoc()) {
        $dbImagePath = trim($row['image'] ?? '');
        
        // ✅ YOUR EXACT PATH: hooper_fits_api/uploads/products/
        $fullImageUrl = '';
        
        if (!empty($dbImagePath)) {
            // If database stores full relative path like "uploads/products/shoes.jpg"
            if (strpos($dbImagePath, 'uploads') === 0) {
                $fullImageUrl = 'http://localhost/' . ltrim($dbImagePath, '/');
            } 
            // If database stores just filename "shoes.jpg"
            else {
                $fullImageUrl = 'http://localhost/hooper_fits_api/uploads/products/' . basename($dbImagePath);
            }
        }
        
        // ✅ FINAL FALLBACK
        if (empty($fullImageUrl) || $fullImageUrl === 'http://localhost/hooper_fits_api/uploads/products/') {
            $fullImageUrl = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2Y4ZjkxYSIvPjx0ZXh0IHg9IjUwJSIgeT0iNDUiIGZvbnQtc2l6ZT0iMTIiIGZpbGw9IiM2NjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg==';
        }
        
        $cartItem = [
            'id' => $row['product_id'],
            'name' => $row['product_name'],
            'image' => $fullImageUrl,  // ✅ PERFECT URL FOR YOUR FOLDER!
            'price' => (float)$row['price'],
            'quantity' => (int)$row['quantity'],
            'seller_id' => $row['seller_id'] ?? null
        ];
        
        $cart[] = $cartItem;
        
        // ✅ DEBUG
        error_log("🖼️ {$row['product_name']}: DB='{$dbImagePath}' → URL='{$fullImageUrl}'");
    }
    
    echo json_encode([
        'success' => true,
        'cart' => $cart,
        'debug' => [
            'buyer_id' => $buyer_id,
            'path_info' => 'Using: hooper_fits_api/uploads/products/',
            'sample_url' => !empty($cart) ? $cart[0]['image'] : 'no items'
        ]
    ]);
    
} catch (Exception $e) {
    error_log('Cart error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>