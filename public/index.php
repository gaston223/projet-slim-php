<?php

use Slim\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';
//echo 'Bonjour';

//debug des erreurs (a configurer manuellement depuis l'exemple de la doc application/configuration
$config = require dirname(__DIR__) . '/config/config.php';

$app = new App($config);

//Configuration du conteneur d'injection de dépendances
require_once dirname(__DIR__) . '/config/container.php';

//Configuration des routes
require_once dirname(__DIR__) . '/config/routes.php';


//$app = new App();


//Création et renvoi de la réponse au navigateur

$app->run();
