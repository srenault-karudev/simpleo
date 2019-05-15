<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-05-12
 * Time: 16:28
 */

namespace App\EventListener;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RegisterListener implements  EventSubscriberInterface
{

    private $router;
    private $token;

    public function __construct(RouterInterface $router,TokenStorageInterface $token)
    {
        $this->router = $router;
        $this->token = $token;


    }


    public function onEditProfilCompleted(\FOS\UserBundle\Event\FormEvent $event)
    {


//       dump($this->token); die();
        $user = $this->token->getToken()->getUser();
        $formula = $user->getFormula();


        $url = $this->router->generate('dashboard',array('formula' => $formula));
        $response = new RedirectResponse($url);
        $event->setResponse($response);


    }

    public static function getSubscribedEvents()
    {
        return [
        FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onEditProfilCompleted',

        ];
    }

}