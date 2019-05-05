<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-04-30
 * Time: 20:05
 */

namespace App\Controller;


use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends Controller
{

    /**
     * @Route("/{formula}/payement", name = "payement", defaults={"formula"=""}, schemes={"%secure_channel%"})
     * @Method({"GET", "POST"})
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

        dump($request);
        if ($request->isMethod('POST')) {

            $token = $request->request->get('stripeToken');
            $stripeClient = $this->get('stripe_client');
            if (!$user->getStripeCustomerId()) {
                $stripeClient->createCustomer($user, $token);
            } else {
                $stripeClient->updateCustomerCard($user, $token);
            }


            if($formula == User::SIMPLE_ID){
                $amount = 3000;
            }elseif ($formula == User::COMPLETE_ID){
                $amount = 5000;
            }
            $description = 'formule'.$formula;
            $stripeClient->CreateInvoiceItem($amount,$user,$description);

            $stripeClient->createInvoice($user,true);


            //$this->addFlash('success', 'Order Complete! Yay!');
            return $this->redirectToRoute('dashboard', array('formula' => $formula));

        }

        return $this->render('payement.html.twig',
            array(
                'formula' => $formula,
                'stripe_public_key' => $this->getParameter('stripe_public_key')
            ));
    }
}