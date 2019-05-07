<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class AfterLoginRedirection
 *
 * @package AppBundle\AppListener
 */
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;



    /**
     * AfterLoginRedirection constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     *
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $roles = $token->getRoles();
        $user = $token->getUser();
        $company = $user->getCompany();
        $formula = $user->getFormula();
//        $dateOfEndPeriod = $user->getDateOfTrialPeriod();
//        $today = new \DateTime();
//        $today->format('Y-m-d');

        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_ADMIN', $rolesTab, true)||(in_array('ROLE_USER', $rolesTab, true)) && !$company ) {
            // c'est un aministrateur : on le rediriger vers l'espace admin
            $redirection = new RedirectResponse($this->router->generate('company_form'));
        } else {


//          if($today == $today){
//              $user->setEnabled(false);
//              $this->em->persist($user);
//              $this->em->flush();
//          }
            if($user->getFormula() == null){
                $redirection = new RedirectResponse($this->router->generate('choiceMode'));
            }
            else{
                $redirection = new RedirectResponse($this->router->generate('dashboard',array("formula" => $formula)));
            }

        }

        return $redirection;
    }
}