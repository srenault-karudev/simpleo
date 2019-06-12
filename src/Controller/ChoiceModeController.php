<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-04-27
 * Time: 12:20
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ChoiceModeController extends Controller
{

    /**
     * @Route("/choiceMode", name = "choiceMode")
     */
    public function index()
    {

         $user = $this->getUser();
         $state = $user->isState();

        $stateTrialPeriod = $user->isStateTrialPeriod();

        return $this->render('choiceMode.html.twig',array("state" => $state,"stateTrialPeriod" =>$stateTrialPeriod));
    }

}