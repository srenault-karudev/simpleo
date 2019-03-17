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
     * @Route("/form_company/{id}", name="form_company",defaults={"id"=""})
     * @Method({"GET", "POST"})
     */

    public function companyForm (Request $request,Company $company = null)
    {
        if($company == null){
            $company = new Company();
            $user = $this->getUser();
            $company->setUser($user);
        }

        $form = $this->createForm('App\Form\CompanyType',$company);

        $user = $this->getUser();
        $company->setUser($user);

        $form->handleRequest($request);
        if($company->getStartDateSocialYear() < $company->getEndDateSocialYear()) {
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

//
//    /**
//     * Displays a form to edit an existing company entity.
//     *
//     * @Route("/{id}/edit", name="company_edit")
//     * @Method({"GET", "POST"})
//     * @param Request $request
//     * @param Company $company
//     * @return
//     */
//    public function editAction(Request $request, Company $company)
//    {
//        $deleteForm = $this->createDeleteForm($company);
//        $form = $this->createForm('App\Form\CompanyType', $company);
//        $form->handleRequest($request);
//
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('dashboard');
//        }
//
//        return $this->render('company.html.twig', array(
//            'company' => $company,
//            'form' => $form->createView(),
//            'mode' => 'Modifier',
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    /**
//     * Deletes a company entity.
//     *
//     * @Route("/{id}", name="company_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, Company $company)
//    {
//        $form = $this->createDeleteForm($company);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($company);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('dashboard');
//    }
//
//    /**
//     * Creates a form to delete a company entity.
//     *
//     * @param Company $company The company entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Company $company)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('company_delete', array('id' => $company->getId())))
//            ->setMethod('DELETE')
//            ->getForm();
//    }

}