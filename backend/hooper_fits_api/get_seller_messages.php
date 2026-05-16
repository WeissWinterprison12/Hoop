<?php
header('Content-Type: application/json');
include 'config.php';

$seller_id = $_SESSION['user_id'] ?? 1;

$stmt = $pdo->prepare("
    SELECT m.*, u.username as sender_username, u.fullname 
    FROM contact_messages m 
    LEFT JOIN users u ON m.sender_id = u.id 
    WHERE m.receiver_id = ? 
    ORDER BY m.created_at DESC
");
$stmt->execute([$seller_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'messages' => $messages]);
?>