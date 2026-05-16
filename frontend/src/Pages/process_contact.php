<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'hooper_fits'; // Replace with your database name
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON data');
    }
    
    // Required fields validation
    $required_fields = ['sender_id', 'receiver_id', 'fullname', 'email', 'message'];
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            throw new Exception('Missing required field: ' . $field);
        }
    }
    
    // Email validation
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }
    
    // Database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Insert message into database
    $stmt = $pdo->prepare("
        INSERT INTO messages (sender_id, receiver_id, message, sent_at) 
        VALUES (:sender_id, :receiver_id, :message, NOW())
    ");
    
    $message = "Contact Form Message\n\n";
    $message .= "From: " . $input['fullname'] . " <" . $input['email'] . ">\n";
    $message .= "Message: " . $input['message'];
    
    $stmt->execute([
        'sender_id' => $input['sender_id'],
        'receiver_id' => $input['receiver_id'],
        'message' => $message
    ]);
    
    $message_id = $pdo->lastInsertId();
    
    // Log success
    error_log("Contact message saved: ID $message_id from sender_id {$input['sender_id']}");
    
    echo json_encode([
        'success' => true,
        'message_id' => $message_id,
        'message' => 'Message sent successfully!'
    ]);
    
} catch (Exception $e) {
    error_log("Contact form error: " . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>