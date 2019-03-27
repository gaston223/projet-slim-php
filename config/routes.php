<?php

use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\ProjectController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$route = $app->get("/", function (
ServerRequestInterface $request,
ResponseInterface $response,
?array $args
) {

//on retourne une reponse

return $this->view->render($response, 'home.twig');
});
$route->setName('homepage');


//Routes groupées

$app->group('/projet', function () {
//Route pour Creation du projet
$this->get("/creation", ProjectController::class.':creation')->setName('app_project_create');

// Route pour detail du projet
$this->get("/{id:\d+}", ProjectController::class.':show')->setName('app_project_show');

});

//Route Contact
$app->get("/contact", ContactController::class.':contact')->setName('app_contact');


//Route About
$app->get("/about", AboutController::class.':about')->setName('app_about');
