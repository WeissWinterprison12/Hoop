<?php
// update_profile_name.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "error" => "POST required"]);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$user_id = intval($input['user_id'] ?? 0);
$name = trim($input['name'] ?? '');

if (!$user_id || strlen($name) < 2) {
    echo json_encode(["success" => false, "error" => "Invalid user_id or name"]);
    exit();
}

ob_start();
$conn = new mysqli("localhost", "root", "", "hooper_fits");
ob_end_clean();

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "DB failed: " . $conn->connect_error]);
    exit();
}

// ✅ SAME AUTH AS DASHBOARD
$result = $conn->query("SELECT role FROM users WHERE id = $user_id");
if (!$result || $result->num_rows === 0) {
    echo json_encode(["success" => false, "error" => "User ID $user_id not found"]);
    exit();
}

$row = $result->fetch_assoc();
if (!in_array($row['role'], ['seller', 'admin'])) {
    echo json_encode(["success" => false, "error" => "User $user_id role '{$row['role']}' - must be seller/admin"]);
    exit();
}

// ✅ Update name
$stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
$stmt->bind_param("si", $name, $user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Name update failed"]);
}

$conn->close();
?>