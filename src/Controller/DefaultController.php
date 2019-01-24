<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-14
 * Time: 01:00
 */

namespace App\Controller;


class DefaultController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    public function index()
    {
        return $this->redirectToRoute('homepage');
    }
}