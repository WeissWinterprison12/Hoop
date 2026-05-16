<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

include "db.php";

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    echo json_encode(["status" => "error", "errorField" => "request"]);
    exit();
}

$username = trim($data->username ?? '');
$password = $data->password ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "errorField" => "both"]);
    exit();
}

$stmt = $conn->prepare("
    SELECT id, username, password, name, role 
    FROM users 
    WHERE username = ?
");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user["password"])) {
        echo json_encode([
            "status" => "success",
            "user_id" => $user['id'],
            "username" => $username,
            "name" => $user['name'] ?? $username,
            "role" => $user['role']  // Now uses database role!
        ]);
    } else {
        echo json_encode(["status" => "error", "errorField" => "password"]);
    }
} else {
    echo json_encode(["status" => "error", "errorField" => "username"]);
}

$stmt->close();
$conn->close();
?>