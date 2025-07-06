<?php 

require(__DIR__ . "/../models/Movie.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/MovieService.php");
require(__DIR__ . "/../services/ResponseService.php");

class MovieController{
    
    public function getMovies(){

        global $mysqli;

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
    }

}