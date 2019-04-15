<?php
/**
 * Created by PhpStorm.
 * User: lahmar
 * Date: 13/03/19
 * Time: 17:40
 */

namespace App\Controller;


use App\Entity\ContactUs;
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

/*    public function index()
    {
        return $this->render('contactus.html.twig');
    }*/

    public function index (\Symfony\Component\HttpFoundation\Request $request)
    {
        $contact = new ContactUs();
        $form = $this->createForm('App\Form\ContactUsType',$contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =  $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }


        return $this->render('contactus.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}