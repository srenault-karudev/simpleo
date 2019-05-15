<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use App\Entity\Devis;
use App\Entity\Person;
use App\Entity\Provider;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DevisController extends Controller
{
//
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/index_devis", name="index_devis")
     */

    public function indexAction(PaginatorInterface $paginator,Request $request)
    {

//
        $em = $this->getDoctrine()->getManager();
        $devis = $em->getRepository('App:Devis')->getDevis($this->getUser());
//        $query = $em->createQuery($devis);
//
//        $paginations  = $this->get('knp_paginator')->paginate(
//            $query,
//            $request->query->getInt('page', 1), /*page number*/
//            10 /*limit per page*/
//        );

        $properties = $paginator->paginate(
            $devis,
            $request->query->getInt('page', 1),5
        );
        $properties->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        return $this->render('devis/index.html.twig', array(
            'properties' => $properties
        ));
    }


    /**
     * @Route("/form_devis/{id}", name="form_devis",defaults={"id"=""})
     * @Method({"GET", "POST"})
     */

    public function devisForm (Request $request,Devis $devis = null)
    {

        if($devis == null){
            $devis = new Devis();

        }

        /*$devis->setPersonType('devis');

        $devis->setUser($this->getUser());
        $form = $this->createForm('App\Form\DevisType',$devis);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($devis);
            $em->flush();

            return $this->redirectToRoute('index_devis');
        }*/

        return $this->render('devis/form.html.twig', [
            //'form' => $form->createView(),
        ]);
    }

}