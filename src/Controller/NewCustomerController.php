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

class NewCustomerController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/newcustomer", name="newcustomer")
     */

//    public function index()
//    {
//        return $this->render('newcustomer.html.twig');
//    }

    public function index(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('App\Form\CustomerType',$person);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form = $form->getData();


            return $this->redirectToRoute('dashboard');
        }

        return $this->render('newcustomer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}