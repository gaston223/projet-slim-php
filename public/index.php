<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';
//echo 'Bonjour';

$app = new App();

$route = $app->get("/", function (
    ServerRequestInterface $request,
    ResponseInterface $response,
    ?array $args
) {

    //on retourne une reponse

    return $response->getBody()->write('<h1>Bonjour</h1>');
});$route->setName('homepage');


//routes groupées

$app->group('/projet',function(){
    // Route pour detail du projet
    $this->get("/{id:\d+}",function (ServerRequestInterface $request, ResponseInterface $response, ?array $args
        ) {
            //on retourne une reponse
            return $response->getBody()->write('<h1>Détail du projet</h1>');
        })->setName('app_project_show');

    $this->get("/creation",function (ServerRequestInterface $request, ResponseInterface $response, ?array $args
    ) {
        //on retourne une reponse
        return $response->getBody()->write('<h1>Création du projet</h1>');
    })->setName('app_project_create');
});

//Création et renvoi de la réponse au navigateur

$app->run();
