<?php
// update_profile.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "error" => "POST required"]);
    exit();
}

ob_start();
$conn = new mysqli("localhost", "root", "", "hooper_fits");
ob_end_clean();

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "DB failed: " . $conn->connect_error]);
    exit();
}

$user_id = intval($_POST['user_id'] ?? 0);
if (!$user_id) {
    echo json_encode(["success" => false, "error" => "Missing user_id"]);
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

// ✅ Handle file upload
$upload_dir = "uploads/profiles/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['profile_image'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!in_array($file_extension, $allowed)) {
        echo json_encode(["success" => false, "error" => "Invalid file type"]);
        exit();
    }
    
    $new_filename = $user_id . '_' . time() . '.' . $file_extension;
    $upload_path = $upload_dir . $new_filename;
    
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        // Delete old image
        $old_image = $conn->query("SELECT profile_image FROM users WHERE id = $user_id")->fetch_assoc()['profile_image'];
        if ($old_image && file_exists("uploads/profiles/" . basename($old_image))) {
            unlink("uploads/profiles/" . basename($old_image));
        }
        
        // Update database
        $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
        $stmt->bind_param("si", $upload_path, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "image" => $upload_path]);
        } else {
            echo json_encode(["success" => false, "error" => "DB update failed"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "File upload failed"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file uploaded"]);
}

$conn->close();
?>