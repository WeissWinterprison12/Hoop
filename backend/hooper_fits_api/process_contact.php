<?php
// Complete CORS Headers - Handle ALL preflight requests
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

$host = 'localhost';
$dbname = 'hooper_fits'; // UPDATE YOUR DB NAME
$username = 'root';
$password = ''; // UPDATE YOUR DB PASSWORD

try {
    // Only process POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Only POST method allowed');
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON data');
    }
    
    // Validate required fields
    $required_fields = ['sender_id', 'receiver_id', 'fullname', 'email', 'message'];
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            throw new Exception('Missing required field: ' . $field);
        }
    }
    
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }
    
    // Database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Format message
    $message = "🏀 Hooper's Fits Contact Form\n\n";
    $message .= "👤 Name: " . htmlspecialchars($input['fullname']) . "\n";
    $message .= "📧 Email: " . htmlspecialchars($input['email']) . "\n";
    $message .= "💬 Message:\n" . htmlspecialchars($input['message']) . "\n";
    $message .= "🆔 Sender ID: " . $input['sender_id'];
    
    // Insert into messages table
    $stmt = $pdo->prepare("
        INSERT INTO messages (sender_id, receiver_id, message, sent_at) 
        VALUES (:sender_id, :receiver_id, :message, NOW())
    ");
    
    $stmt->execute([
        'sender_id' => (int)$input['sender_id'],
        'receiver_id' => (int)$input['receiver_id'],
        'message' => $message
    ]);
    
    $message_id = $pdo->lastInsertId();
    
    echo json_encode([
        'success' => true,
        'message_id' => $message_id,
        'message' => 'Your message has been sent successfully! We\'ll reply within 24-48 hours.',
        'data' => $input
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