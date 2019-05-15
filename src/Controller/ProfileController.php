<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-05-12
 * Time: 13:53
 */

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProfileController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/Profile", name="profile")
     */

    public function index()
    {

        return $this->redirectToRoute('fos_user_profile_edit');

    }

}