<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

ob_start();

$conn = new mysqli("localhost", "root", "", "hooper_fits");

ob_end_clean();

if ($conn->connect_error) {
    echo json_encode(["error" => "DB failed: " . $conn->connect_error]);
    exit();
}

$seller_id = intval($_GET['user_id'] ?? 11);

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

$data = [
    "user_id" => $seller_id,
    "totalOrders" => 0,
    "totalSales" => 0,
    "totalProducts" => 0,
    "monthlyRevenue" => 0,
    "newCustomers" => 0,
    "orders" => []
];

$result = $conn->query("SELECT COUNT(*) as total FROM orders WHERE seller_id = $seller_id");
$data['totalOrders'] = $result ? intval($result->fetch_assoc()['total']) : 0;

$result = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE seller_id = $seller_id AND status IN ('completed','shipped')");
$data['totalSales'] = $result ? floatval($result->fetch_assoc()['total']) : 0;

$result = $conn->query("SELECT COUNT(*) as total FROM products WHERE seller_id = $seller_id");
$data['totalProducts'] = $result ? intval($result->fetch_assoc()['total']) : 0;

$result = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE seller_id = $seller_id AND MONTH(created_at) = MONTH(NOW())");
$data['monthlyRevenue'] = $result ? floatval($result->fetch_assoc()['total']) : 0;

$result = $conn->query("SELECT COUNT(DISTINCT buyer_id) as total FROM orders WHERE seller_id = $seller_id AND MONTH(created_at) = MONTH(NOW())");
$data['newCustomers'] = $result ? intval($result->fetch_assoc()['total']) : 0;

$result = $conn->query("
    SELECT 
        id,
        CONCAT('Order #', id) as product,
        ROUND(total_amount, 2) as price,
        COALESCE(payment_method, 'Cash') as payment,
        status,
        DATE_FORMAT(created_at, '%b %d, %Y') as date
    FROM orders 
    WHERE seller_id = $seller_id 
    ORDER BY created_at DESC 
    LIMIT 5
");

$orders = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
$data['orders'] = $orders;

$conn->close();
echo json_encode($data, JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
?>