<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


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
     * @Route("/dashboard", name="dashboard")
     */

    public function index()
    {
        $user = $this->getUser();
        $endPeriod = false;
        $trialPeriod = $user->isTrialPeriod();
        if($trialPeriod == 1 ){

            //$dateOfTrialPeriod = $user->getDateOfTrialPeriod()->format('Y-m-d');
            $dateOfEndPeriod = $user->getDateOfTrialPeriod()->modify('+5 day');
            $dateOfEndPeriod->format('Y-m-d');
            $today = new \DateTime();
            $today->format('Y-m-d');


          if($today == $dateOfEndPeriod){
              $endPeriod = true;
          }
            $interval= date_diff($today, $dateOfEndPeriod);
            $interval = $interval->format('%d');
            
        }

        return $this->render('dashboard.html.twig',array(
            'endPeriod' => $endPeriod,
            'interval' => $interval,
            'trialPeriod' => $trialPeriod
            ));

    }
}