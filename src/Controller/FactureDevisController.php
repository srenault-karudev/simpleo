<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FactureDevisController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/Facture_Devis", name="facturedevis")
     */

    public function index()
    {

        return $this->render('facture_devis.html.twig');

    }
}