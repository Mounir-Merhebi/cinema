<?php
declare(strict_types=1);

require_once("../models/User.php");
require_once("../connection/connection.php"); // Ensure this path is correct

header('Content-Type: application/json');

// Get the user ID from the POST request (safer for deletion)
$userId = $_POST['userId'] ?? null;

// Validate the user ID
if (!$userId || !is_numeric($userId)) {
    echo json_encode(["success" => false, "message" => "Invalid or missing user ID for deletion."]);
    exit();
}

try {
    // Attempt to delete the user using the User model
    // You might need to add a static delete method to your User.php model
    $deleteSuccess = User::delete($mysqli, (int)$userId); // Assuming you add a delete method

    if ($deleteSuccess) {
        echo json_encode(["success" => true, "message" => "Account deleted successfully."]);
    } else {
        // This might happen if the user ID doesn't exist, or a DB error occurred
        echo json_encode(["success" => false, "message" => "Failed to delete account. User might not exist or a server error occurred."]);
    }
} catch (Exception $e) {
    error_log("Error deleting user: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "An unexpected error occurred during deletion."]);
} finally {
    $mysqli->close();
}

?>