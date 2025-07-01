<?php
declare(strict_types=1);

require_once("../models/User.php");
require_once("../connection/connection.php"); 

header('Content-Type: application/json');
$userId = $_POST['userId'] ?? null;

if (!$userId || !is_numeric($userId)) {
    echo json_encode(["success" => false, "message" => "Invalid or missing user ID for deletion."]);
    exit();
}

try {
    $deleteSuccess = User::delete($mysqli, (int)$userId);

    if ($deleteSuccess) {
        echo json_encode(["success" => true, "message" => "Account deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete account. User might not exist or a server error occurred."]);
    }
} catch (Exception $e) {
    error_log("Error deleting user: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "An unexpected error occurred during deletion."]);
} finally {
    $mysqli->close();
}

?>