<?php

// Get container
use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\ProjectController;
use App\Model\Connection;
use App\Repository\ProjectRepository;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Twig\Extension\DebugExtension;

$container = $app->getContainer();

// Register component on container
$container['view'] = function (ContainerInterface $container) {
    $view = new Twig(dirname(__DIR__). '/templates', [
        'cache' => false,
        'strict_variables'=>true,
        'debug'=>true,
    ]);

    // Ajout de l'extension de debug Twig
    $view->addExtension(new DebugExtension());

    //Extension de la base Twig
    $router = $container->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

//On definit une clé ProjectController pour expliquer au conteneur comment instancier Projet Controller
//Cette clé sera appelée automatiquement par le routeur
$container[ProjectController::class]=function (ContainerInterface $container) {
    //On retourne une instance de ProjectController en envoyant Twig
    //On obtient Twig en envoyant la clé View du conteneur
    return new ProjectController(
        $container->get('view'),
        $container->get(ProjectRepository::class)
    );
};


$container [ContactController::class]=function (ContainerInterface $container) {
    return new ContactController($container->get('view'));
};

$container [AboutController::class]=function (ContainerInterface $container) {
    return new AboutController($container->get('view'));
};

$container [ProjectRepository::class]=function (ContainerInterface $container) {
    return new ProjectRepository($container->get(Connection::class));
};

$container[Connection::class]=function (ContainerInterface $container){
    return new Connection(
     $container ['settings']['database_name'],
     $container ['settings']['database_user'],
     $container ['settings']['database_pass']

    );
};
