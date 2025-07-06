<?php

require __DIR__ . '/cinema-server/routes/api.php';

$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}
if ($request == '') {
    $request = '/';
}

// Routing logic
if (isset($apis[$request])) {
    $controller_name = $apis[$request]['controller'];
    $method = $apis[$request]['method'];
    require_once __DIR__ . "/cinema-server/controllers/{$controller_name}.php";

    $controller = new $controller_name();
    if (method_exists($controller, $method)) {
        echo $controller->$method(); 
    } else {
        echo json_encode(["success" => false, "message" => "Method {$method} not found in {$controller_name}."]);
    }
} else {
    http_response_code(404);
    echo json_encode(["success" => false, "message" => "404 Not Found"]);
}
