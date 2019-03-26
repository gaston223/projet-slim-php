<?php

use App\Controller\ProjectController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';
//echo 'Bonjour';

$config = ['settings' => [
    'addContentLengthHeader' => false,
]];
$app = new \Slim\App($config);
//Configuration de TWIG
// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(dirname(__DIR__). '/templates', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container[ProjectController::class]=function ($container) {
    return new ProjectController($container->get('view'));
};

//$app = new App();

$route = $app->get("/", function (
    ServerRequestInterface $request,
    ResponseInterface $response,
    ?array $args
) {

    //on retourne une reponse

    //return $response->getBody()->write('<h1>Bonjour</h1>');
    return $this->view->render($response, 'home.twig');
});
$route->setName('homepage');


//routes groupées

$app->group('/projet', function () {
    // Route pour detail du projet
    $this->get("/{id:\d+}", ProjectController::class.':show')->setName('app_project_show');

    $this->get("/creation", ProjectController::class.':creation')->setName('app_project_create');
});

//Création et renvoi de la réponse au navigateur

$app->run();
