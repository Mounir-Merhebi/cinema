<?php 
require("../connection/connection.php");


$query = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mobile_number VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,  
    date_of_birth DATE,
    communication_prefs VARCHAR(20),
    membership_level VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    age_verified BOOLEAN DEFAULT 0
)";

if ($mysqli->query($query) === TRUE) {
    echo "Table Users created successfully";
} else {
    echo "Error creating table: " . $mysqli->error;
}

?>