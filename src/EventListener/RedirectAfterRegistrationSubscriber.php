<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-01-17
 * Time: 11:27
 */

namespace App\EventListener;


use App\Entity\User;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onRegistrationSuccess(FormEvent $event)
    {


        $url = $this->router->generate('fos_user_security_login');
        $response = new RedirectResponse($url);
        $event->setResponse($response);

    }

    /**
     * @Method({"GET"})
     */
    public function onRegistrationCompleted(\FOS\UserBundle\Event\FilterUserResponseEvent $event)
    {
        $trialPeriod = $event->getRequest()->get('trialPeriod');
        $user = $event->getUser();

        if ($trialPeriod != null or $trialPeriod != 0) {
            $user->setFormula(User::TRIAL_PEREIOD);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',

        ];
    }


}