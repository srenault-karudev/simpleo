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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class CompanyController extends Controller
{

    /**
     * @Route("/company",name="company")
     */
    public function index()
    {

        return $this->render('company.html.twig');

    }

    /**
     * @Route("/form_company/{id}", name="company_form",defaults={"id"=""})
     * @Method({"GET", "POST"})
     */

    public function companyForm( AuthenticationUtils $authenticationUtils = null, Request $request, Company $company = null)
    {
        $user = $this->getUser();
        $formula = $user->getFormula();
        if ($company == null) {
            $company = new Company();
            $company->setUser($user);
        }

        if ($authenticationUtils != null) {
            $error = $authenticationUtils->getLastAuthenticationError();
        }
        $form = $this->createForm('App\Form\CompanyType', $company);

        $user = $this->getUser();
        $company->setUser($user);

        $form->handleRequest($request);

        if ($company->getStartDateSocialYear() < $company->getEndDateSocialYear()) {
            if ($form->isSubmitted() && $form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($company);
                $em->flush();

                if ($user->getFormula() == null) {
                    return $this->redirectToRoute('choiceMode');
                } else {
                    return $this->redirectToRoute('dashboard',array('formula'=>$formula));
                }
            }
        }

        return $this->render('company.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }


}