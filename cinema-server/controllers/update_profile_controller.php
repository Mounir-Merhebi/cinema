<?php
declare(strict_types=1);

require_once("../models/User.php");
require_once("../connection/connection.php"); // Ensure this path is correct

header('Content-Type: application/json');

// Get data from POST request
// Using $_POST directly for simplicity with application/x-www-form-urlencoded
// For JSON requests, you would use file_get_contents('php://input') and json_decode
$userId = $_POST['userId'] ?? null;
$fullname = $_POST['fullname'] ?? null;
$email = $_POST['email'] ?? null;
$mobile_number = $_POST['mobile_number'] ?? null;
$date_of_birth = $_POST['date_of_birth'] ?? null;
$communication_prefs = $_POST['communication_prefs'] ?? null;
// Password change should typically be handled by a separate endpoint for security

// Basic validation
if (!$userId || !is_numeric($userId)) {
    echo json_encode(["success" => false, "message" => "Invalid or missing user ID."]);
    exit();
}

// Prepare data array for the update method
$updateData = [];
if ($fullname !== null) $updateData['fullname'] = $fullname;
if ($email !== null) $updateData['email'] = $email;
if ($mobile_number !== null) $updateData['mobile_number'] = $mobile_number;
if ($date_of_birth !== null) $updateData['date_of_birth'] = $date_of_birth;
if ($communication_prefs !== null) $updateData['communication_prefs'] = $communication_prefs;

// You might want to add more robust validation for each field here (e.g., email format, phone number format)

if (empty($updateData)) {
    echo json_encode(["success" => false, "message" => "No data provided for update."]);
    exit();
}

try {
    // Attempt to update the user
    $updateSuccess = User::update($mysqli, (int)$userId, $updateData);

    if ($updateSuccess) {
        echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update profile. No changes made or user not found."]);
    }
} catch (Exception $e) {
    error_log("Error updating user: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "An unexpected error occurred during profile update."]);
} finally {
    $mysqli->close();
}

?>