<?php

use Slim\Http\Request;
use Slim\Http\Response;

# Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    # Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/posts', "Marcosricardoss\Restful\Controller\PostController:getPosts");
$app->get('/posts/{id}', "Marcosricardoss\Restful\Controller\PostController:getPost");

$app->group('/posts', function () {
    $this->map(['POST'], '', "Marcosricardoss\Restful\Controller\PostController:create");    
    $this->delete('/{id}', "Marcosricardoss\Restful\Controller\PostController:delete");
})->add("Marcosricardoss\Restful\Middleware\AuthMiddleware");

$app->group('/auth', function () {
    $this->post('/login', "Marcosricardoss\Restful\Controller\AuthController:login");
    $this->post('/register', "Marcosricardoss\Restful\Controller\AuthController:register");    
    $this->post('/logout', "Marcosricardoss\Restful\Controller\AuthController:logout")
         ->add("Marcosricardoss\Restful\Middleware\AuthMiddleware");

});