<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

include "db.php";

$data = json_decode(file_get_contents("php://input"));

if(!$data){
    echo json_encode([
        "status" => "error",
        "message" => "No data received"
    ]);
    exit();
}

$username = $data->username;
$address = $data->address;
$email = $data->email;
$password = $data->password;
$contact = $data->contact;
$security_question = $data->security_question;
$security_answer = $data->security_answer;

// Hash both password and security answer for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$hashedSecurityAnswer = password_hash($security_answer, PASSWORD_DEFAULT);

/* CHECK IF EMAIL EXISTS */
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){
    echo json_encode([
        "status" => "error",
        "message" => "Email already exists"
    ]);
    exit();
}

/* CHECK IF USERNAME EXISTS */
$checkUsername = $conn->prepare("SELECT id FROM users WHERE username = ?");
$checkUsername->bind_param("s", $username);
$checkUsername->execute();
$resultUsername = $checkUsername->get_result();

if($resultUsername->num_rows > 0){
    echo json_encode([
        "status" => "error",
        "message" => "Username already exists"
    ]);
    exit();
}

/* INSERT USER WITH SECURITY QUESTION */
$stmt = $conn->prepare("INSERT INTO users (username, address, contact, email, password, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $username, $address, $contact, $email, $hashedPassword, $security_question, $hashedSecurityAnswer);

if($stmt->execute()){
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Registration failed: " . $stmt->error
    ]);
}

$stmt->close();
$check->close();
$checkUsername->close();
$conn->close();
?>