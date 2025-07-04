<?php
require("../connection/connection.php");

$sql = "CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    release_date DATE,
    rating DECIMAL(3, 1),
    poster_url VARCHAR(255),
    cast TEXT,
    trailer_link VARCHAR(255)
);";

if ($mysqli->query($sql) === TRUE) {
    echo "Table 'movies' created successfully.<br>";
} else {
    echo "Error creating table: " . $mysqli->error . "<br>";
}

?>

