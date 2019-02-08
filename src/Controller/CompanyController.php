<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-02-05
 * Time: 16:49
 */

namespace App\Controller;


use App\Entity\Company;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{

    /**
     * @Route("/company", name="company")
     */
    public function index()
    {

        return $this->render('company.html.twig');

    }

    /**
     * @Route("/new_company", name="new_company")
     */

    public function newAction (Request $request)
    {
        $company = new Company();
        $form = $this->createForm('App\Form\CompanyType',$company);

        $user = $this->getUser();
        $company->setUser($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =  $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

           return $this->redirectToRoute('dashboard');
        }

        return $this->render('company.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}