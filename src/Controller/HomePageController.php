<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;



use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomePageController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/homepage", name="homepage")
     * @Method({"GET", "POST"})
     */

    public function index(Request $request)
    {
        $form = $this->createForm('App\Form\HomePageType');
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $trialEmail = $form->get('trialEmail')->getData();

            //return $this->redirectToRoute('dashboard');
            return $this->redirectToRoute('fos_user_registration_register',array('trialPeriod' => true, 'trialEmail'=>$trialEmail));

        }

        return $this->render('/homepage.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}