<?php
declare(strict_types=1);

require("../models/User.php");
require("../connection/connection.php");
header('Content-Type: application/json');


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
?>
