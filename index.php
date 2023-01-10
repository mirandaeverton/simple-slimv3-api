<?php

require './vendor/autoload.php';

set_include_path("C:\MAMP\htdocs\simple-php-api");
include_once "api\\post\\PostController.php";

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// ROUTES

$app->get('/post', function (Request $request, Response $response) {
    $postController = new PostController($request, $response);
    return $postController->getAll();
});

// In Slim v3 the args passed in the URI are not designed by ":" but placed inside {}
$app->get('/post/{id}', function (Request $request, Response $response, $args) {
    $postController = new PostController($request, $response, $args);
    return $postController->getSingle();
});

$app->post('/post', function (Request $request, Response $response) {
    $postController = new PostController($request, $response);
    return $postController->create();
});

$app->put('/post/{id}', function (Request $request, Response $response, $args) {
    $postController = new PostController($request, $response, $args);
    return $postController->update();
});

$app->delete('/post/{id}', function (Request $request, Response $response, $args) {
    $postController = new PostController($request, $response, $args);
    return $postController->delete($id);
});

$app->run();