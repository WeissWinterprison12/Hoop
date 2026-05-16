<?php
header('Content-Type: application/json');
include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$message_id = $data['message_id'];
$seller_id = $data['seller_id'];

$stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ? AND receiver_id = ?");
$result = $stmt->execute([$message_id, $seller_id]);

echo json_encode(['success' => $result]);
?>