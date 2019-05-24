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
use Stripe\Person;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class IndexInvoiceBuyController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @Route("/index_journal_facture_achat", name="index_journal_facture_achat")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $invoices = $em->getRepository('App:Invoice')->getInvoices($this->getUser());;
        $data = $paginator->paginate(
            $invoices,
            $request->query->getInt('page', 1),5
        );
        $data->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        return $this->render('Facture_Devis/index_invoice_buy.html.twig', array(
            'properties' => $data));
    }


    /**
     * @Route("/new_invoice_buy", name="new_invoice_buy")
     * @Method({"GET"})
     */

    public function newInvoice(Request $request, Action $action = null)
    {

        $form = $this->createForm('App\Form\Action_buyType', $action);
        $form2 = $this->createForm('App\Form\Invoice_BuyType', $action);

        //$em = $this->getDoctrine()->getManager();
        //$records = $em->getRepository('App:Record')->getRecords();


        //dump($request->query->get('value'));


        return $this->render('Facture_Devis/new_invoice_buy.html.twig', array(
            'form' => $form->createView(),
            'form2' => $form2->createView()
        ));


    }

    /**
     * @Route("/ajaxInvoiceBuyRoute", name="ajaxInvoiceBuyRoute",options = {"expose" : true})
     * @Method({"GET"})
     */
    public function firstAjaxAction(Request $request, Action $action = null)
    {


        $actions = $request->query->get('data')[0];

        $em = $this->getDoctrine()->getManager();


        $paiementNum = $request->query->get('data')[1];
        $customerId = $request->query->get('data')[2];
        $date_string = $request->query->get('data')[3];
        $file = $request->query->get('data')[4];
        $user = $this->getUser();


        $customerRepository = $em->getRepository('App:Person')->getCustomer($this->getUser(), $customerId);
        $paimentRepository = $em->getRepository('App:Record')->getRecord($paiementNum);




        /* Enregistrement de la facture en base de donnée    */

        $invoice = new Invoice();

        $htPrice = $invoice->calcultHtPrice($actions);
        $ttcPrice = $invoice->calculTtcPrice($actions);
        $invoice->setUser($user);
        $date = new \DateTime($date_string);
        $invoice->setDate($date);
        $invoice->setInvoiceType(true);
        $invoice->setPriceHt($htPrice);
        $invoice->setPriceTt($ttcPrice);
        $customer = new Customer();
        $customer->setUser($user);

        foreach ($customerRepository as $cR) {
            $invoice->setClient($cR);
        }
        foreach ($paimentRepository as $pR) {
            $invoice->setPaiement($pR);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($invoice);
        $em->flush();



        /* Enregistrement de l'action qui regroupe tout les factures en base de donnée    */

        foreach ($actions as $a) {
            $regiser = $a[0];
            $tva = $a[1];
            $qtte = $a[2];
            $amountTava = $a[3];
            $unitAmount = $a[4];

            $record = $em->getRepository('App:Record')->getRecord($regiser);
            dump($record);

            foreach ($record as $r) {
                $action->setRecord($r);
            }


            $action->setTva($tva);
            $action->setTvaAmount($amountTava);
            $action->setQuantity($qtte);
            $action->setUnitAmount($unitAmount);
            $action->setImageFile($file);

            $action->setInvoice($invoice->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();
        }



        return $this->redirectToRoute('index_journal_facture_achat');
    }

}