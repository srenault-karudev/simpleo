<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:55
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function index()
    {
        return $this->redirect($this->generateUrl('fos_user_registration_register'));
    }


    protected function setFlash($action, $value)
    {
        $value = $this->container->get('translator')->trans($value, array(), 'FOSUserBundle');
        $this->container->get('session')->setFlash($action, $value);
    }

}