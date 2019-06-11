<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;

use App\Entity\MyDate;
use App\Entity\User;
use App\Repository\ActionRepository;
use http\Env\Response;
use phpDocumentor\Reflection\DocBlock\Serializer;
use PhpParser\Node\Expr\Array_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Constraints\DateTime;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/{formula}/dashboard", name="dashboard", defaults={"formula"=""})
     * @Method({"GET", "POST"})
     */

    public function index(Request $request)
    {

        $formula = $request->attributes->get('formula');
        $user = $this->getUser();

        $state = $user->isState();
        $user->setFormula($formula);
        $interval = 0;
//        $endPeriod = false;
//        $trialPeriod = $user->isTrialPeriod();


        if ($formula == User::TRIAL_PEREIOD) {
            //$dateOfTrialPeriod = $user->getDateOfTrialPeriod()->format('Y-m-d');
            $dateOfEndPeriod = $user->getDateOfTrialPeriod()->modify('+30 day');
            $dateOfEndPeriod->format('Y-m-d');
            $today = new \DateTime();
            $today->format('Y-m-d');

            if ($today == $dateOfEndPeriod) {
                $user->setState(false);

            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $interval = date_diff($today, $dateOfEndPeriod);
            $interval = $interval->format('%d');

        }


        $em = $this->getDoctrine()->getManager();
        $monthData = array(
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre'
        );
        $today = new MyDate();
        $month=$monthData[$today->getMonth()];
        $year=$today->format('Y');
        $lastMonth= $monthData[$today->getLastMonth()];
        $lastMonthSpending= $em->getRepository('App:Action')->getLastMonthSpending($user);
        $lastMonthTurnover=  $em->getRepository('App:Action')->getLastMonthTurnover($user);
        $monthTurnover= $em->getRepository('App:Action')->getMonthTurnover($user);
        $yearturnover =  $em->getRepository('App:Action')->getYearTurnover($user);
        $numberofwaitinvoices =$em->getRepository('App:Action')->getWaitInvoices($user);
        $numberofinvoicestoPay =$em->getRepository('App:Action')->getInvoicesToPay($user);

        foreach ($lastMonthTurnover[0] as $key => $value){
            if($key='lastmonthturnover'){
                $valOne=$value;
                foreach ($lastMonthSpending[0] as $key => $value){
                    if($key='lastmonthspending'){
                        $valTwo=$value;
                    }
                }
            }
        }
        foreach ($monthTurnover[0] as $key => $value){
            if($key='turnoverOfThisYear'){
                $valTree=$value;
            }
        }
        $evolution=round( ((($valTree/$valOne)-1)*100), 2 );
        $lastmonthResult= $valOne-$valTwo;

        $em->persist($user);
        $em->flush();



        return $this->render('dashboard.html.twig', array(
            'month'=>$month,
            'evolution' => $evolution,
            'lastmonth' => $lastMonth,
            'year' =>$year,
            'state' => $state,
            'interval' => $interval,
            'formula' => $formula,
            'bool' => false,
            'infoGlobal' => array(
                'invoicetopay'=>$numberofinvoicestoPay,
                'lastmontresult' =>$lastmonthResult,
                'monthturnover' => $monthTurnover,
                'yearturnover' => $yearturnover,
                'numberWaitInvoices' => $numberofwaitinvoices,
                'lastmonthturnover' => $lastMonthTurnover,
                'lastmonthspending' => $lastMonthSpending
            )
        ));

    }


    /**
     * @Route("/ajaxDashboard", name="ajaxDashboard",options = {"expose" : true})
     * @Method({"GET"})
     */
    public function ajaxAction(){
        $monthData = array(
            1 => 'Janvier',
            2 => 'Fevrier',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Aout',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Decembre'
        );

        $data=array();
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        for($i=1 ; $i <= 12 ; $i++){
            $res= $em->getRepository('App:Action')->getAllMonthTurnoverOfThisYear($user,$i);
            foreach ($res as $key => $value){
                foreach ($value as $k => $v){
                   if($k='turnover'){
                      if (is_null($v)){
                            array_push($data,0);
                      }else{
                            array_push($data,$v);
                      }
                    }
                }
            }
        }
        $mydata= json_encode($data);
        dump($data);
        dump($mydata);
        return $this->json($mydata);
    }
}