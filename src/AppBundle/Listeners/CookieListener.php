<?php


namespace AppBundle\Listeners;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;


class CookieListener
{

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $cookie = $event->getRequest()->cookies;

        if(!$cookie->has('hellokoraliki_cart'))
        {
            $responce = $event->getResponse();
            $responce->headers->setCookie(new Cookie('hellokoraliki_cart', md5(uniqid())));
        }
    }
}