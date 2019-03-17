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
     * @Route("/form_company/{id}", name="company_form",defaults={"id"=""})
     * @Method({"GET", "POST"})
     */

    public function companyForm(Request $request, Company $company = null)
    {
        if ($company == null) {
            $company = new Company();
            $user = $this->getUser();
            $company->setUser($user);
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

                return $this->redirectToRoute('dashboard');
            }
        }

            return $this->render('company.html.twig', [
                'form' => $form->createView(),
            ]);
        }


}