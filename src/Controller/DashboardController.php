<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
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
        dump($user);
        dump($formula);
        $state = $user->isState();
//        $user->setFormula($formula);
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
//        if($formula == User::SIMPLE_ID){
//          //  $user->setFormula($formula);
//            $user->setState(true);
//
//        }
//
//        if($formula == User::COMPLETE_ID) {
//           // $user->setFormula($formula);
//            $user->setState(true);
//        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();


        return $this->render('dashboard.html.twig', array(
            'state' => $state,
            'interval' => $interval,
            'formula' => $formula,
            'bool' => false
        ));

    }
}