<?php

require './vendor/autoload.php';

set_include_path("C:\MAMP\htdocs\simple-php-api");
include_once "api\\post\\PostController.php";

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\App;

// ROUTES

$app->get('/post', function (ServerRequestInterface $request, ResponseInterface $response) {
    $postController = new PostController($request, $response);
    return $postController->getAll();
});

// $app->get('/post/:id', function ($id) use ($app) {
//     $postController = new PostController($app);
//     $postController->getSingle($id);
// });

// $app->post('/post', function () use ($app) {
//     $postController = new PostController($app);
//     $postController->create();
// });

// $app->put('/post/:id', function ($id) use ($app) {
//     $postController = new PostController($app);
//     $postController->update($id);
// });

// $app->delete('/post/:id', function ($id) use ($app) {
//     $postController = new PostController($app);
//     $postController->delete($id);
// });

$app->run();