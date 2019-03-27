<?php
/**
 * Created by PhpStorm.
 * User: Gaoussou
 * Date: 26/03/2019
 * Time: 16:25
 */

namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ContactController
{
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function contact(ServerRequestInterface $request, ResponseInterface $response, ?array $args)
    {
        return $this->twig->render($response, 'contact.twig');
    }
}
