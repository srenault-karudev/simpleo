<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use App\Entity\Person;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CustomerController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }



//    public function index()
//    {
//        return $this->render('newcustomer.html.twig');
//    }

    /**
     * @Route("/newcustomer", name="new_customer")
     */

    public function newCustomer(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('App\Form\CustomerType',$person);

        $person->setFirstname("steven");

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $person->setFirstname("steven");
            $em =  $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('customer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}