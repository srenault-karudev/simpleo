<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-14
 * Time: 01:00
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



class DefaultController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{

    /**
     * @Route("/", name="login")
     */
    public function index()
    {
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }
}