<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-04-30
 * Time: 20:05
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends  Controller
{

    /**
     * @Route("/{formula}/payement", name = "payement", defaults={"formula"=""})
     */
    public function index(Request $request)
    {
        $formula = $request->attributes->get('formula');
        $user = $this->getUser();
        $user->setFormula($formula);
        $user->setState(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->render('payement.html.twig',array('formula' => $formula));
    }
}