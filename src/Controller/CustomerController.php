<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;

use App\Repository\PersonRepository;
use App\Entity\Customer;
use App\Form\PropretySearchType;
use App\Entity\Person;
use App\Entity\PropertySearch;
use App\Entity\Provider;
use Knp\Component\Pager\PaginatorInterface;
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



    public function indexAction(PaginatorInterface $paginator,Request $request)
    {

       $em = $this->getDoctrine()->getManager();
        $search= new PropertySearch();
            $customers = $em->getRepository('App:Person')->getCustomers();

//        $query = $em->createQuery($customers);
//
//        $paginations  = $this->get('knp_paginator')->paginate(
//            $query,
//            $request->query->getInt('page', 1), /*page number*/
//            10 /*limit per page*/
//        );

        $form=$this->createForm(PropretySearchType::class,$search);
        $form->handleRequest($request);
        $properties = $paginator->paginate(
            $customers,

            $request->query->getInt('page', 1),5
        );
        $properties->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        return $this->render('customer/index.html.twig', array(
            'properties' => $properties,
            'form'=> $form->createView()
        ));
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
        $customer->setPersonType('customer');

        $customer->setUser($this->getUser());
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