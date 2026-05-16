<?php
// =====================================================
// Hooper Fits - Get All Products API
// =====================================================

// Prevent PHP errors from breaking JSON response
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // =====================================================
    // DATABASE CONFIGURATION
    // =====================================================
    $host = 'localhost';
    $dbname = 'hooper_fits';        // ✅ Your confirmed DB name
    $username = 'root';             // ✅ Default for XAMPP/WAMP
    $password = '';                 // ✅ Usually empty for local
    
    // =====================================================
    // DATABASE CONNECTION
    // =====================================================
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ]
    );
    
    // =====================================================
    // FETCH ALL PRODUCTS
    // Matches your exact table structure:
    // id, seller_id, product_name, description, price, image, stock, created_at
    // =====================================================
    $stmt = $pdo->query("
        SELECT 
            id,
            seller_id,
            product_name,
            description,
            price,
            image,
            COALESCE(stock, 0) as stock,
            created_at
        FROM products 
        ORDER BY created_at DESC, id DESC 
        LIMIT 50
    ");
    
    $products = $stmt->fetchAll();
    
    // =====================================================
    // SUCCESS RESPONSE
    // =====================================================
    echo json_encode([
        'success' => true,
        'products' => $products,
        'count' => count($products),
        'message' => 'Products loaded successfully'
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    // =====================================================
    // DATABASE ERROR
    // =====================================================
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database connection failed',
        'details' => $e->getMessage()
    ]);
} catch (Exception $e) {
    // =====================================================
    // GENERAL ERROR
    // =====================================================
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error',
        'details' => $e->getMessage()
    ]);
}
?>