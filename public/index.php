<?php

use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\ProjectController;
use Psr\Container\ContainerInterface;
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

//On definit une clé ProjectController pour expliquer au conteneur comment instancier Projet Controller
//Cette clé sera appelée automatiquement par le routeur
$container[ProjectController::class]=function (ContainerInterface $container) {
    //On retourne une instance de ProjectController en envoyant Twig
    //On obtient Twig en envoyant la clé View du conteneur
    return new ProjectController($container->get('view'));
};


$container [ContactController::class]=function (ContainerInterface $container) {
    return new ContactController($container->get('view'));
};

$container [AboutController::class]=function (ContainerInterface $container) {
    return new AboutController($container->get('view'));
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

    //Route pour Creation du projet
    $this->get("/creation", ProjectController::class.':creation')->setName('app_project_create');
});

//Route Contact
$app->get("/contact", ContactController::class.':contact')->setName('app_contact');


//Route About
$app->get("/about", AboutController::class.':about')->setName('app_about');


//Création et renvoi de la réponse au navigateur

$app->run();
