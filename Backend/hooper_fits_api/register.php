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

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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

/* INSERT USER */
$stmt = $conn->prepare("INSERT INTO users (username, address, contact, email, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $username, $address, $contact, $email, $hashedPassword);

if($stmt->execute()){
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Registration failed: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>