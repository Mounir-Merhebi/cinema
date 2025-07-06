<?php
declare(strict_types=1); 
require(__DIR__ . "/../models/User.php");
require(__DIR__ . "/../connection/connection.php");
require_once __DIR__ . '/../services/UserService.php';
require(__DIR__ . "/../services/ResponseService.php");

class AuthController{


public function register() {
  
    global $mysqli;
   

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$mobile_number = $_POST['mobile_number'];
$password = $_POST['password'];
$dateOfBirth = $_POST['date_of_birth'];


if (empty($fullname) || empty($email) || empty($mobile_number) || empty($password) || empty($dateOfBirth)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format"]);
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

}

public function login(){
 global $mysqli;

$email = $_POST['email'] ?? '';
$providedPassword = $_POST['password'] ?? '';

if (empty($email) || empty($providedPassword)) {
    echo json_encode(["success" => false, "message" => "Email and password are required."]);
    exit();
}

$user = User::findByEmail($mysqli, $email);

if ($user === null) {
    echo json_encode(["success" => false, "message" => "Invalid credentials."]);
} else {
    if ($user->verifyPassword($providedPassword)) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful!",
            "userId" => $user->getId() 
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid credentials."]);
    }
}
$mysqli->close();
}

}