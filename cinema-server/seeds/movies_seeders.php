<?php
   require("../connection/connection.php");
   require("../models/Movie.php");

    $movies = [
        [
            'title' => 'Dune: Part Two',
            'description' => 'Paul Atreides unites with Chani and the Fremen while seeking revenge against the conspirators who destroyed his family.',
            'release_date' => '2024-03-01',
            'rating' => 8.7,   
            'poster_url' => '../assets/dne2.jpg', 
            'cast' => 'Timothée Chalamet, Zendaya, Rebecca Ferguson',
            'trailer_link' => 'https://www.youtube.com/watch?v=Way9Dexny3w'
        ],
        [
            'title' => 'Oppenheimer',
            'description' => 'The story of J. Robert Oppenheimer\'s role in the development of the atomic bomb during World War II.',
            'release_date' => '2023-07-21',
            'rating' => 8.6,
            'poster_url' => '/cinema-server/posters/oppenheimer.jpg', 
            'cast' => 'Cillian Murphy, Emily Blunt, Matt Damon',
            'trailer_link' => 'https://www.youtube.com/watch?v=SDbyxM_jD9A'
        ],
        [
            'title' => 'Interstellar',
            'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
            'release_date' => '2014-11-07',
            'rating' => 8.4,
            'poster_url' => '/cinema-server/posters/interstellar.jpg', 
            'cast' => 'Matthew McConaughey, Anne Hathaway, Jessica Chastain',
            'trailer_link' => 'https://www.youtube.com/watch?v=zSWdADRvqVc'
        ],
        [
            'title' => 'Inception',
            'description' => 'A thief who steals corporate secrets through use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
            'release_date' => '2010-07-16',
            'rating' => 8.8,
            'poster_url' => '/cinema-server/posters/inception.jpg', 
            'cast' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page',
            'trailer_link' => 'https://www.youtube.com/watch?v=YoHD9XEInc0'
        ]
    ];

    foreach ($movies as $movie) {
        $newMovies = Movie::create($mysqli, $movie);
    }

    $mysqli->close();