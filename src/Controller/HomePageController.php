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

$email = $request->get('trialEmail');


//          $user = new User();
//          $user->setUsername('UtilisateurEssai');
//          $user->setUsernameCanonical('UtilisateurEssai');
//          $user->setEmail($email);
//          $user->setEnabled(1);
//          $user->setPassword('123456');


            return $this->redirectToRoute('fos_user_security_login');
        }



        return $this->render('/homepage.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}