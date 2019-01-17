<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 14:07
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
//    public function loginAction(Request $request)
//    {
//        $authChecker = $this->container->get('security.authorization_checker');
//        $router = $this->container->get('router');
//
//        if ($authChecker->isGranted('ROLE_ADMIN')) {
//            return new RedirectResponse($router->generate('dashboard'), 307);
//        }
//
//        if ($authChecker->isGranted('ROLE_USER')) {
//            return new RedirectResponse($router->generate('dashboard'), 307);
//        }
//    }
}