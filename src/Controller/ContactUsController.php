<?php
/**
 * Created by PhpStorm.
 * User: lahmar
 * Date: 13/03/19
 * Time: 17:40
 */

namespace App\Controller;


use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContactUsController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/contactus", name="contactus")
     */

    public function index()
    {
        return $this->render('contactus.html.twig');
    }
}