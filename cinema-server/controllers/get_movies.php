<?php

require_once("../connection/connection.php"); 
require_once("../models/Movie.php");


header('Content-Type: application/json');
$moviesData = [];

try {
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    $movies = Movie::all($mysqli);

    foreach ($movies as $movie) {
        $moviesData[] = $movie->toArray();
    }
    echo json_encode(['success' => true, 'movies' => $moviesData]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error fetching movies: ' . $e->getMessage()]);
} finally {
    if (isset($mysqli) && !$mysqli->connect_error) {
        $mysqli->close();
    }
}
?>
