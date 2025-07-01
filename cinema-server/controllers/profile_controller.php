<?php
declare(strict_types=1);

require_once("../models/User.php");
require_once("../connection/connection.php"); 
header('Content-Type: application/json');

$userId = $_GET['id'] ?? null;

if (!$userId || !is_numeric($userId)) {
    echo json_encode(["success" => false, "message" => "Invalid or missing user ID."]);
    exit();
}

$user = User::find($mysqli, (int)$userId); 

if ($user === null) {
    echo json_encode(["success" => false, "message" => "User not found."]);
} else {
    $userData = [
        "id" => $user->getId(),
        "fullname" => $user->getFullname(),
        "email" => $user->getEmail(),
        "mobile_number" => $user->getMobileNumber(),
        "date_of_birth" => $user->getDateOfBirth(),
        "communication_prefs" => $user->getCommunicationPrefs(),
        "membership_level" => $user->getMembershipLevel(),
        "created_at" => $user->getCreatedAt(),
        "age_verified" => $user->getAgeVerified()
    ];

    echo json_encode(["success" => true, "user" => $userData]);
}

$mysqli->close();
?>