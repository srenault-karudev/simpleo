<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use App\Entity\Customer;
use App\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CustomerController extends Controller
{
//
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/index_customer", name="index_customer")
     */

    public function indexAction(Request $request)
    {
        

        $em = $this->getDoctrine()->getManager();
        $customers = $em->getRepository('App:Person')->getCustomers();


        $reservations  = $this->get('knp_paginator')->paginate(
            $customers,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );
        return $this->render('customer/index.html.twig', array(
            'customers' => $customers,));
    }

    /**
     * @Route("/form_customer/{id}", name="form_customer",defaults={"id"=""})
     * @Method({"GET", "POST"})
     */

    public function customerForm (Request $request,Customer $customer = null)
    {

        if($customer == null){
            $customer = new Customer();

        }
        $form = $this->createForm('App\Form\CustomerType',$customer);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('index_customer');
        }

        return $this->render('customer/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**

       * @Route("/show_customer/{id}", name="customers_show")
        * @Method("GET")
         */
public function show(Customer $customer){
        return $this->render('customer/show.html.twig',array(
            'customer' => $customer,
        ));
}



    /**
     * Deletes a customers entity.
     *
     * @Route("/customer_delete{id}/delete", name="customers_delete")
     * Method({"GET"})
     */
    public function deleteAction(Request $request, Customer $customer)
    {
       // $this->denyAccessUnlessGranted(Customer::DELETE,$customers);

        $em = $this->getDoctrine()->getManager();
        $em->remove($customer);
        $em->flush();
        return $this->redirectToRoute('index_customer');
    }




}