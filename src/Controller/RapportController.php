<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RapportController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/Rapport", name="rapport")
     */

    public function index(Request $request)
    {
        $form = $this->createForm('App\Form\RapportType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $month = $form->get('month')->getData();
            $year = $form->get('year')->getData();
            $choix= $form->get('choix')->getData();

            dump($choix);
            return $this->redirectToRoute('rapport');

        }

        return $this->render('rapport.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}