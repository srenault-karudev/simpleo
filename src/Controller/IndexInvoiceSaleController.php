<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use App\Entity\Action;
use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\PropertySearch;
use App\Entity\Record;
use App\Form\PropretySearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class IndexInvoiceSaleController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @Route("/index_journal_facture_vente", name="index_journal_facture_vente",options = {"expose" : true})
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $search= new PropertySearch();
        $em = $this->getDoctrine()->getManager();
        $invoices = $em->getRepository('App:Invoice')->getInvoices($this->getUser(),0);;
        $form=$this->createForm(PropretySearchType::class,$search);
        $form->handleRequest($request);
        $data = $paginator->paginate(
            $invoices,
            $request->query->getInt('page', 1),5
        );
        $data->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        return $this->render('Facture_Vente/index_invoice_sale.html.twig', array(
            'properties' => $data,
            'form'=> $form->createView()
        ));
    }

    /**
     * @Route("/new_invoice_sale", name="new_invoice_sale")
     * @Method({"GET"})
     */

    public function newInvoice(Request $request, Action $action = null){

        $form = $this->createForm('App\Form\Action_saleType', $action);
        $form2 = $this->createForm('App\Form\Invoice_SaleType', $action);


        //$em = $this->getDoctrine()->getManager();
        //$records = $em->getRepository('App:Record')->getRecords();


        //dump($request->query->get('value'));


        return $this->render('Facture_Vente/new_invoice_sale.html.twig',array(
            'form' => $form->createView(),

            'form2'=> $form2->createView(),

        ));

    }


    /**
     *
     * @Route("/invoice_sale_delete{id}/delete", name="invoice_sale_delete")
     * Method({"GET"})
     */
    public function deleteAction(Request $request, Invoice $invoice)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($invoice);
        $em->flush();
        return $this->redirectToRoute('index_journal_facture_vente');
    }


    /**
     * @Route("/ajaxInvoiceSaleRoute", name="ajaxInvoiceRouteSale",options = {"expose" : true})
     * @Method({"GET"})
     */
    public function firstAjaxAction(Request $request)
    {


        $actions = $request->query->get('data')[0];

        $em = $this->getDoctrine()->getManager();

        $customerId = $request->query->get('data')[1];
        $date_string = $request->query->get('data')[2];
        $user = $this->getUser();


        $dueDate = new \DateTime($date_string);

        $customerRepository = $em->getRepository('App:Person')->getCustomer($this->getUser(), $customerId);


        /* Enregistrement de la facture en base de donnée    */

        $invoice = new Invoice();

        $htPrice = $invoice->calcultHtPrice($actions);
        $ttcPrice = $invoice->calculTtcPrice($actions);
        $invoice->setUser($user);
        $date = new \DateTime($date_string);
        $invoice->setDate($date);
        $invoice->setInvoiceType(false);
        $invoice->setPriceHt($htPrice);
        $invoice->setPriceTt($ttcPrice);

        $invoice->setDueDate($dueDate->modify('+3 month'));
        $customer = new Customer();
        $customer->setUser($user);

        foreach ($customerRepository as $cR) {
            $invoice->setClient($cR);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($invoice);
        $em->flush();


        /* Enregistrement de l'action qui regroupe tout les factures en base de donnée    */

        foreach ($actions as $a) {
            $regiser = $a[0];
            $article = $a[1];
            $tva = $a[2];
            $qtte = $a[3];
            $amountTava = $a[4];
            $unitAmount = $a[5];

            $record = $em->getRepository('App:Record')->getRecord($regiser);

            $action = new Action();
            foreach ($record as $r) {
                $action->setRecord($r);
            }

            $action->setArticle($article);
            $action->setTva($tva);
            $action->setTvaAmount($amountTava);
            $action->setQuantity($qtte);
            $action->setUnitAmount($unitAmount);
            $action->setTotalAmountTtc();
            $invoice->setPaiement(null);

            $action->setInvoice($invoice);

            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();
        }


        return $this->json([]);
    }



    /**
     * @Route("/indexSaleAjaxAction", name="indexSaleAjaxAction",options = {"expose" : true})
     * @Method({"GET"})
     */
    public function indexSaleAjaxAction(Request $request)
    {

        $invoiceId = $request->query->get('invoiceId');
        $etat = $request->query->get('etat');
        $numRecord = $request->get('numRecord');


        $em = $this->getDoctrine()->getManager();
        $invoice = $em->getRepository('App:Invoice')->find($invoiceId);


        if ($etat == "false") {
            $invoice->setStateOfPaiement(false);
        } else {
            $invoice->setStateOfPaiement(true);
            $paimentRepository = $em->getRepository('App:Record')->getRecord($numRecord);
            foreach ($paimentRepository as $pR) {
                $invoice->setPaiement($pR);
            }

        }


        if (($invoice->isStateOfPaiement() == true)) {
            $invoice->setPaimentDate(new \DateTime());
        }

        $em->persist($invoice);
        $em->flush();

        return $this->json([]);
    }







    /**
     * @Route("/generate_index_sale/{id}",name="generate_index_sale")
     * @Method({"GET"})
     */
    public function generatePdf(Invoice $invoice){

        $snappy = $this->container->get('knp_snappy.pdf');
        $user = $this->getUser();

        $html = $this->renderView('pdf/facturePdf.html.twig', array(
            'invoice'  => $invoice,
            'user'  => $user,
        ));

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachement; filename="Facture_'.$invoice->getId(). '.pdf"' // inline for browser ou attachement for download
            )
        );

    }


}