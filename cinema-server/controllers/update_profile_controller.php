<?php
declare(strict_types=1);

require_once("../models/User.php");
require_once("../connection/connection.php"); 

header('Content-Type: application/json');

$userId = $_POST['userId'] ?? null;
$fullname = $_POST['fullname'] ?? null;
$email = $_POST['email'] ?? null;
$mobile_number = $_POST['mobile_number'] ?? null;
$date_of_birth = $_POST['date_of_birth'] ?? null;
$communication_prefs = $_POST['communication_prefs'] ?? null;

if (!$userId || !is_numeric($userId)) {
    echo json_encode(["success" => false, "message" => "Invalid or missing user ID."]);
    exit();
}

$updateData = [];
if ($fullname !== null) $updateData['fullname'] = $fullname;
if ($email !== null) $updateData['email'] = $email;
if ($mobile_number !== null) $updateData['mobile_number'] = $mobile_number;
if ($date_of_birth !== null) $updateData['date_of_birth'] = $date_of_birth;
if ($communication_prefs !== null) $updateData['communication_prefs'] = $communication_prefs;


if (empty($updateData)) {
    echo json_encode(["success" => false, "message" => "No data provided for update."]);
    exit();
}

try {
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