<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use App\Entity\Devis;
use App\Entity\DevisAction;
use App\Entity\Person;
use App\Entity\Provider;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/index_devis", name="index_devis", options = {"expose" : true})
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

        $devisAction = new DevisAction();


        //$devis->setPersonType('devis');

        $devis->setUser($this->getUser());
        $form = $this->createForm('App\Form\DevisType',$devis);
        $form2 = $this->createForm('App\Form\DevisActionType',$devisAction);


        $form->handleRequest($request);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($devis);
            $em->flush();

            return $this->redirectToRoute('index_devis');
        }

         if ($form2->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($devis);
            $em->flush();

            return $this->redirectToRoute('index_devis');
        }

        return $this->render('devis/form.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/ajaxDevis", name="ajaxDevis",options = {"expose" : true})
     * @Method({"GET"})
     */
    public function firstAjaxAction(Request $request)
    {


        $user = $this->getUser();
        $customerId = $request->query->get('data')[0];
        $reference = $request->query->get('data')[3];
        $dateCreation = $request->query->get('data')[1];
        $dateExpiration = $request->query->get('data')[2];
        $actions = $request->query->get('data')[4];

        $em = $this->getDoctrine()->getManager();  /* Pour accéder à la base de données */


        dump($request->query->get('data')[4]); /* dump = echo */


        /*$devisRepository = $em->getRepository('App:Devis')->getDevis($this->getUser());*/
        $customerRepository = $em->getRepository('App:Person')->getCustomer($this->getUser(), $customerId);




        /* Enregistrement de la facture en base de donnée    */

        $devis = new Devis();
        $devis->setUser($user);
        $devis->setReference($reference);

        $dateCreation2 = new \DateTime($dateCreation);
        $devis->setDateCreation($dateCreation2);

        $dateExpiration2 = new \DateTime($dateExpiration);
        $devis->setDateExpiration($dateExpiration2);


        $montantHT = $devis->calculTotalHT($actions);
        $devis->setMontantHT($montantHT);

        $montantTVA = $devis->calculMontantTVA($actions);
        $devis->setMontantTVA($montantTVA);

        $prixTTC = $devis->additionTTCs($actions);
        $devis->setMontant($prixTTC);


        foreach ($customerRepository as $cR) {
            $devis->setClient($cR);
            $devis->setTelephone($cR->getMobilePhone());
        }


        $em->persist($devis);
        $em->flush();

        /* Enregistrement de l'action qui regroupe tout les factures en base de données  */

        foreach ($actions as $a) {
            $article = $a[0];
            $typeProduit = $a[1];
            $qtte = $a[2];
            $prixHT = $a[3];
            $tauxTVA = $a[4];
            $remise = $a[5];
            $montantTTC= $a[6];

            $recordRepository = $em->getRepository('App:Record')->getRecord($typeProduit);

            $devisAction = new DevisAction();

            foreach ($recordRepository as $rR) {
                $devisAction->setRecord($rR);
            }


            $devisAction->setDevis($devis);
            $devisAction->setArticle($article);
            $devisAction->setQtte($qtte);
            $devisAction->setPrixHT($prixHT);
            $devisAction->setTauxTVA($tauxTVA);
            $devisAction->setRemise($remise);
            $devisAction->setMontantTTC($montantTTC);


//            $file = new File('App/public/uploads/images/products/AttestationDroit.pdf');
//            //$action->setImage($fileString);
//            $action->setImageFile($file);


            $em->persist($devisAction);
            $em->flush();
        }


        return $this->json([]);
    }

    /**
     * @Route("/devis_show/{id}", name="devis_show")
     * @Method("GET")
     */
    public function show(Devis $devis)
    {
        return $this->render('devis/show.html.twig', array(
            'devis' => $devis,
        ));
    }

    /**
     * Deletes a devis entity.
     *
     * @Route("/devis_delete{id}/delete", name="devis_delete")
     * Method({"GET"})
     */
    public function deleteDevis(Request $request, Devis $devis)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($devis);
        $em->flush();
        return $this->redirectToRoute('index_devis');
    }

    /**
     * @Route("/generate_pdf/{id}",name="generate_pdf")
     * @Method({"GET"})
     */
    public function generatePDF(Devis $devis){

        $snappy = $this->container->get('knp_snappy.pdf');
        $user = $this->getUser();

        $html = $this->renderView('pdf/devisPdf.html.twig', array(
            'devis'  => $devis,
            'user'  => $user,
        ));

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachement; filename="DEV2019-'.$devis->getId().'.pdf"' // inline for browser ou attachement for download
            )
        );

    }

    /**
     * @Route("/indexDevisAjaxAction", name="indexDevisAjaxAction",options = {"expose" : true})
     * @Method({"GET"})
     */
    public function indexAjaxAction(Request $request)
    {

        dump($request);

        $devisId = $request->query->get('devisId');
        $state = $request->query->get('state');



        $em = $this->getDoctrine()->getManager();
        $devis = $em->getRepository('App:Devis')->find($devisId);


        if ($state == 1) {
            $etat = "validé";
        }
       elseif ($state == 2){
            $etat = "en attente";
       }
        elseif ($state == 3 ){
            $etat = "refusé";
        }

        $devis->setEtat($etat);



        $em->persist($devis);
        $em->flush();

        return $this->json([]);
    }


}