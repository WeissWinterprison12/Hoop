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
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

$username = trim($data->username ?? '');
$securityAnswer = trim($data->security_answer ?? '');
$newPassword = $data->newPassword ?? '';

if (empty($username) || empty($securityAnswer) || empty($newPassword)) {
    echo json_encode(["status" => "error", "message" => "Username, security answer, and password required"]);
    exit();
}

// Password validation (same as register)
if (strlen($newPassword) < 8 || preg_match('/[^A-Za-z0-9]/', $newPassword)) {
    echo json_encode(["status" => "error", "message" => "Password must be 8-20 alphanumeric characters"]);
    exit();
}
if (!preg_match('/[a-z]/', $newPassword)) {
    echo json_encode(["status" => "error", "message" => "Password must contain lowercase letters"]);
    exit();
}
if (!preg_match('/[A-Z]/', $newPassword)) {
    echo json_encode(["status" => "error", "message" => "Password must contain uppercase letters"]);
    exit();
}
if (!preg_match('/\d/', $newPassword)) {
    echo json_encode(["status" => "error", "message" => "Password must contain numbers"]);
    exit();
}

// Find user by username and verify security answer
$stmt = $conn->prepare("
    SELECT id, username, security_question, security_answer 
    FROM users 
    WHERE username = ? 
    LIMIT 1
");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    $stmt->close();
    $conn->close();
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

// Verify security answer (case insensitive)
if (strtolower(trim($user['security_answer'])) !== strtolower($securityAnswer)) {
    echo json_encode(["status" => "error", "message" => "Incorrect security answer"]);
    $conn->close();
    exit();
}

// Hash new password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update password
$updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$updateStmt->bind_param("si", $hashedPassword, $user['id']);

if ($updateStmt->execute() && $updateStmt->affected_rows > 0) {
    error_log("Password reset for: " . $user['username']);
    
    echo json_encode([
        "status" => "success",
        "message" => "✅ Password reset successful for " . $username
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update password"]);
}

$updateStmt->close();
$conn->close();
?>