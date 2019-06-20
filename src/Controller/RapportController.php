<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;



use PhpParser\Node\Expr\Array_;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RapportController extends Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/Rapport", name="rapport")
     */

    public function index(Request $request)
    {
        $form = $this->createForm('App\Form\RapportType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $year = $form->get('year')->getData();
            return $this->generateRes($year);

        }

        return $this->render('rapport.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/generate_bilan",name="generate_bilan")
     * @Method({"GET"})
     */
    public function generateBilan($year){

        $snappy = $this->container->get('knp_snappy.pdf');
        $user = $this->getUser();


        $html = $this->renderView('pdf/bilanPdf.html.twig', array(
            'user'  => $user,

        ));

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachement; filename="Bilan.pdf"' // inline for browser ou attachement for download
            )
        );

    }


    /**
     * @Route("/generate_res",name="generate_res")
     * @Method({"GET"})
     */
    public function generateRes($year){
        $snappy = $this->container->get('knp_snappy.pdf');
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();


        $myarray = array();
        $myarrayTwo= array();
        $array3=array();
        array_push($myarray,$em->getRepository('App:Action')->getMarchandisesBuy($user,$year));
        array_push($myarray,$em->getRepository('App:Action')->getVariationsOfStock($user,$year));
        array_push($myarray,$em->getRepository('App:Action')->getSupplyBuy($user,$year));
        array_push($myarray,$em->getRepository('App:Action')->getStockVariation($user,$year));
        array_push($myarray,$em->getRepository('App:Action')->getOtherExterneExpences($user,$year));
        array_push($myarray,$em->getRepository('App:Action')->getTaxesVersementsAssimiles($user,$year));
        array_push($myarray,$em->getRepository('App:Action')->getSalariesExpenses($user,$year));
        array_push($myarray, $em->getRepository('App:Action')->getSocialExpenses($user,$year));
        array_push($myarray,$em->getRepository('App:Action')->getDonationOfAmortissement($user,$year) );
        array_push($myarray,$em->getRepository('App:Action')->getDonationOfDotation($user,$year) );
        array_push($myarray,$em->getRepository('App:Action')->getOthersCharges($user,$year));
        array_push($myarray,$em->getRepository('App:Action')->getFinanceExpences($user,$year));

        array_push($myarrayTwo, $em->getRepository('App:Action')->getExceptionnelExpences($user,$year));
        array_push($myarrayTwo, $em->getRepository('App:Action')->getImpotsOnBenef($user,$year));




        array_push($array3, $em->getRepository('App:Action')->getMarchandiseSale($user,$year));
        array_push($array3, $em->getRepository('App:Action')->getProdSale($user,$year));
        array_push($array3, $em->getRepository('App:Action')->getProdStock($user,$year));
        array_push($array3, $em->getRepository('App:Action')->getProdIm($user,$year));
        array_push($array3, $em->getRepository('App:Action')->getSubExpl($user,$year));
        array_push($array3, $em->getRepository('App:Action')->getOtherProduct($user,$year));



        $arrayOf= array();
        $totalOne=0;
        foreach ($myarray as $key => $value){
            foreach($value[0] as $k => $v){
                if($v != null){
                    $totalOne=$totalOne+$v;
                }
                array_push($arrayOf,$v);
            }
        }

        $arrayOfTwo= array();
        $totalTwo=0;
        foreach ($myarrayTwo as $key => $value){
            foreach($value[0] as $k => $v){
                if($v != null){
                    $totalTwo=$totalTwo+$v;
                }
                array_push($arrayOfTwo,$v);
            }
        }


        $totalCharges=$totalTwo+$totalOne;


        $arrayOfTree= array();
        $total3=0;
        foreach ($array3 as $key => $value){
            foreach($value[0] as $k => $v){
                if($v != null){
                    $total3=$total3+$v;
                }
                array_push($arrayOfTree,$v);
            }
        }

        $html = $this->renderView('pdf/resPdf.html.twig', array(
            'user'  => $user,
            'informations'=> array(
                'marchandisesBuy'=>$arrayOf[0],
                'variationStockMarchandise'=>$arrayOf[1],
                'supplyBuy'=>$arrayOf[2],
                'stockVariationApprovisionnement'=>$arrayOf[3],
                'otherExterneExpences'=>$arrayOf[4],
                'taxesVersementsAssimiles'=>$arrayOf[5],
                'salariesExpences'=> $arrayOf[6],
                'socialExpenses'=>$arrayOf[7],
                'donationOfAmortissement'=>$arrayOf[8],
                'donationOfDotation'=>$arrayOf[9],
                'othersCharges'=> $arrayOf[10],
                'getFinanceExpences'=> $arrayOf[11],
                'totalOne'=>$totalOne,

                'exceptionnelExpences'=>$arrayOfTwo[0],
                'impotsOnBenef'=>$arrayOfTwo[1],
                'totalcharge'=>$totalCharges,

                'marchandiseSale'=>$arrayOfTree[0],
                'prodSale'=>$arrayOfTree[1],
                'prodstock'=>$arrayOfTree[2],
                'prodim'=>$arrayOfTree[3],
                'subexpl'=>$arrayOfTree[4],
                'otherproduct'=>$arrayOfTree[5],
                'total3'=>$total3,




            )
        ));
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachement; filename="Compte_de_résultat.pdf"' // inline for browser ou attachement for download
            )
        );
    }
}