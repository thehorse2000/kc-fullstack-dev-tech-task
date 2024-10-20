<?php

require_once './database/conn.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$requestUri = $_SERVER['REQUEST_URI'];

// Route handlers
if ($requestUri === '/categories') {
    require_once 'controllers/CategoriesController.php';

    $controller = new CategoriesController($pdo);
    echo json_encode($controller->getAll());
} elseif (str_starts_with($requestUri, '/categories/')) {
    require_once 'controllers/CategoriesController.php';

    // Extract the id from the request
    $id = substr($requestUri, strlen('/categories/'));

    $controller = new CategoriesController($pdo);
    echo json_encode($controller->getById($id));
} elseif ($requestUri === '/courses') {
    require_once 'controllers/CoursesController.php';

    $controller = new CoursesController($pdo);
    echo json_encode($controller->getAll());
} elseif (str_starts_with($requestUri, '/courses/')) {
    require_once 'controllers/CoursesController.php';

    // Extract the id from the request
    $id = substr($requestUri, strlen('/courses/'));
    $controller = new CoursesController($pdo);
    echo json_encode($controller->getById($id));
} else {
    // Handle other routes or show a 404 page
    header('HTTP/1.1 404 Not Found');
    exit();
}
