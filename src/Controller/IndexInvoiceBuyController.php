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
    public function newInvoice(Request $request, Action $action = null){

        $form = $this->createForm('App\Form\Action_buyType', $action);

        $em = $this->getDoctrine()->getManager();
        //$records = $em->getRepository('App:Record')->getRecords();


       //dump($request->query->get('value'));

        $search = new PropertySearch();
        $formSearch = $this->createForm(PropretySearchType::class,$search);

        return $this->render('Facture_Devis/new_invoice_buy.html.twig',[
        'form' => $form->createView(),
        'formSearch'=> $formSearch->createView()
            ]);




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
//    /**
//     *
//     *
//     * @Route("/infos", name="customers_infos", options = {"expose" : true})
//     * @Method("GET")
//     * @return JsonResponse
//     */
//
//    public function infoAction()
//    {
//        return new JsonResponse([
//            'isCompany' => true,
//        ]);
//    }
}