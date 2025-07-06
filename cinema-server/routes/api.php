<?php

$apis = [
    '/User'             => ['controller' => 'Usercontroller', 'method' => 'getUser'],
    '/add_Users'         => ['controller' => 'Usercontroller', 'method' => 'AddUsers'],  
    '/delete_user'      => ['controller' => 'Usercontroller', 'method' => 'deleteUser'],
    '/update_user'      => ['controller' => 'Usercontroller', 'method' => 'UpdateUser'],

    '/get_movies'      => ['controller' => 'Moviecontroller', 'method' => 'getMovies'],

    '/login'         => ['controller' => 'AuthController', 'method' => 'login'],
    '/register'         => ['controller' => 'AuthController', 'method' => 'register'],

];
