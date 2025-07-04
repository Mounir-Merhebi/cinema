<?php

declare(strict_types=1);
require_once("../connection/connection.php"); 
require_once("../models/User.php");         


$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$mobile_number = $_POST['mobile_number'] ?? '';
$password = $_POST['password'] ?? '';
$dateOfBirth = $_POST['date_of_birth'] ?? '';


if (empty($fullname) || empty($email) || empty($mobile_number) || empty($password) || empty($dateOfBirth)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email forma"]);
    exit();
}

if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters long or more"]);
    exit();
}
$existingUserByEmail = User::findByEmail($mysqli, $email);
if ($existingUserByEmail !== null) {
    echo json_encode(["success" => false, "message" => "Email already registered"]);
    exit();
}

$hashedPassword = User::hashPassword($password);

$userData = [
    'fullname' => $fullname,
    'email' => $email,
    'mobile_number' => $mobile_number,
    'password' => $hashedPassword,
    'date_of_birth' => $dateOfBirth,
    'communication_prefs' => 'email_enabled', 
    'membership_level' => 'Standard',        
];

$newUserId = User::create($mysqli, $userData);

if ($newUserId !== false) {
    echo json_encode(["success" => true, "message" => "Registration successful! User ID: " . $newUserId]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed. Please try again."]);
}

$mysqli->close();
?>
