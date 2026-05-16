<?php
// get_profile.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

ob_start();
$conn = new mysqli("localhost", "root", "", "hooper_fits");
ob_end_clean();

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "DB failed: " . $conn->connect_error]);
    exit();
}

$seller_id = intval($_GET['user_id'] ?? 0);
if (!$seller_id) {
    echo json_encode(["success" => false, "error" => "Missing user_id"]);
    exit();
}

// ✅ SAME AUTH AS DASHBOARD
$result = $conn->query("SELECT role FROM users WHERE id = $seller_id");
if (!$result || $result->num_rows === 0) {
    echo json_encode(["success" => false, "error" => "User ID $seller_id not found"]);
    exit();
}

$row = $result->fetch_assoc();
if (!in_array($row['role'], ['seller', 'admin'])) {
    echo json_encode(["success" => false, "error" => "User $seller_id role '{$row['role']}' - must be seller/admin"]);
    exit();
}

// ✅ Fetch profile data
$result = $conn->query("
    SELECT name, profile_image 
    FROM users 
    WHERE id = $seller_id
");

if ($result && $result->num_rows > 0) {
    $profile = $result->fetch_assoc();
    $profile['success'] = true;
    echo json_encode($profile);
} else {
    echo json_encode(["success" => true, "name" => "", "profile_image" => null]);
}

$conn->close();
?>