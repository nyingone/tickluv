<?php

namespace App\Src\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct(string $defaultLocale = "fr_FR")
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelrequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->hasPreviousSession()){
            return;
        }

        if ($locale = $request->attributes->get('locale')) {
            $request->getSession()->set('locale', $locale);
        } else {
            $request->setLocale($request->getSession()->get('locale', $this->defaultLocale));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]]
        ];
    }
}
