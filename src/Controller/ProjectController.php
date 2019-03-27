<?php

namespace App\Controller;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ProjectController
{

    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array|null $args
     * @return ResponseInterface
     */

    public function show(ServerRequestInterface $request, ResponseInterface $response, ?array $args
    )
    {
        $finishedAt = new \DateTime();
        $startedAt = new \DateTime('2019-01-23');
        $project=[
            "id"=>100,
            "name"=>"Projet FULL PHP",
            "startedAt"=>$startedAt,
            "finishedAt"=>$finishedAt,
            "description"=>'<h2>Site avec Slim Framework</h2><p></p>',
            "image"=>'site.png',
            "languages"=>["html5","css3","php","sql"]
        ];

        $project2=[
            "id"=>18,
            "name"=>"Projet FULL JS",
            "startedAt"=>'2019-03-23',
            "finishedAt"=>'2016-09-05',
            "description"=>'<h2>Site avec Slim Framework</h2><p></p>',
            "image"=>'site.png',
            "languages"=>["html5","css3","php","sql"]
        ];

        //on retourne une reponse
        //return $response->getBody()->write('<h1>Détail du projet</h1>');
        return $this->twig->render($response, 'project/show.twig', [
            'project'=>$project,'project2'=>$project2
        ]);
    }

    public function creation(ServerRequestInterface $request, ResponseInterface $response, ?array $args
    )
    {
        //on retourne une reponse
        //return $response->getBody()->write('<h1>Création du projet</h1>');
        return $this->twig->render($response, 'project/creation.twig');
    }
}
