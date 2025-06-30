<?php
declare(strict_types=1);

require_once("../models/User.php");
require_once("../connection/connection.php"); // Ensure this path is correct
header('Content-Type: application/json');

// Get the user ID from the request (e.g., from query parameter)
$userId = $_GET['id'] ?? null;

if (!$userId || !is_numeric($userId)) {
    echo json_encode(["success" => false, "message" => "Invalid or missing user ID."]);
    exit();
}

$user = User::find($mysqli, (int)$userId); // Cast to int for type safety

if ($user === null) {
    echo json_encode(["success" => false, "message" => "User not found."]);
} else {
    // Prepare user data for display, EXCLUDING the password
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
        // DO NOT include password here for security
    ];

    echo json_encode(["success" => true, "user" => $userData]);
}

$mysqli->close();
?>