<?php

use Slim\Http\Request;
use Slim\Http\Response;

# Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    # Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/posts', "Marcosricardoss\Restful\Controller\PostController:getPosts");

$app->group('/posts', function () {
    $this->map(['POST'], '', "Marcosricardoss\Restful\Controller\PostController:create");    
})->add("Marcosricardoss\Restful\Middleware\AuthMiddleware");

$app->group('/auth', function () {
    $this->post('/login', "Marcosricardoss\Restful\Controller\AuthController:login");
    $this->post('/register', "Marcosricardoss\Restful\Controller\AuthController:register");    
    $this->post('/logout', "Marcosricardoss\Restful\Controller\AuthController:logout")
         ->add("Marcosricardoss\Restful\Middleware\AuthMiddleware");

});