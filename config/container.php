<?php

// Get container
use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\ProjectController;
use Psr\Container\ContainerInterface;

$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(dirname(__DIR__). '/templates', [
        'cache' => false,
        'strict_variables'=>true,
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
