<?php
/**
 * Created by PhpStorm.
 * User: adrienparaiso
 * Date: 09/06/2019
 * Time: 01:44
 */

namespace App\Controller;

use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class GenerationPDFController extends Controller
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/PDFGenerator", name="PDFGenerator")
     */

    public function index()
    {

        return $this->render('PdfGeneration.html.twig');

    }

}