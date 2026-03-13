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

if(!$data){
    echo json_encode([
        "status" => "error",
        "error" => "request"
    ]);
    exit();
}

$username = $data->username;
$password = $data->password;

/* FIND USER */
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    /* VERIFY PASSWORD */
    if(password_verify($password, $user["password"])){

        echo json_encode([
            "status" => "success"
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "error" => "password"
        ]);

    }

} else {

    echo json_encode([
        "status" => "error",
        "error" => "username"
    ]);

}

$stmt->close();
$conn->close();

?>