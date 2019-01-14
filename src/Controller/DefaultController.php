<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-14
 * Time: 01:00
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DefaultController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index(Request $request): Response
    {
        return new Response($this->twig->render('layout.html.twig', [
                'name' => $request->get("name", 'World')
            ]
        ));
    }
}