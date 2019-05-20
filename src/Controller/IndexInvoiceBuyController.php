<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use App\Entity\Action;
use App\Entity\Invoice;
use App\Entity\Record;
use Knp\Component\Pager\PaginatorInterface;
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
     */
    public function newInvoice(Request $request, Action $action = null, Invoice $invoice = null){
        $form = $this->createForm('App\Form\Action_buyType', $action);
        $form2 = $this->createForm('App\Form\Invoice_BuyType', $action);
        dump($request);
        return $this->render('Facture_Devis/new_invoice_buy.html.twig',array(
            'form' => $form->createView(),
            'form2'=> $form->createView()
        ));


    }

    /**
     * @Route("/ajaxInvoiceBuyRoute", name="ajaxInvoiceBuyRoute")
     * @Method({"POST"})
     */
    public function firstAjaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $t1 = $request->request->all(); // tableau des champs POST
            //var_dump($t1);
            // exit;

            return new \Symfony\Component\HttpFoundation\JsonResponse($t1);
        };

        return $this->render('Facture_Devis/new_invoice_buy.html.twig');

    }
}