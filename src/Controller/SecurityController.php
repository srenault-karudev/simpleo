<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-02-01
 * Time: 17:36
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/", name="login")
     */
    public function index()
    {
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

}