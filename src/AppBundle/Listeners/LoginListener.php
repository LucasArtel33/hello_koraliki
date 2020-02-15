<?php


namespace AppBundle\Listeners;

use AppBundle\Entity\Orders;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;


class LoginListener
{
    private $entityManager;

    public function __construct(RegistryInterface $entityManager) {
        $this->entityManager = $entityManager;
    }


    public function onLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $cookieId = $event->getRequest()->cookies->get('hellokoraliki_cart');

        $this->fromCookieToUser($user, $cookieId);
    }

    public function onRegistration(FilterUserResponseEvent $event)
    {
        $user = $event->getUser();
        $cookieId = $event->getRequest()->cookies->get('hellokoraliki_cart');

        $this->fromCookieToUser($user, $cookieId);
    }

    private function fromCookieToUser($user, $cookieId)
    {
        $orderRepository = $this->entityManager->getRepository(Orders::class);
        $orderInCookie = $orderRepository->findOrderByCookie($cookieId);

        if (!empty($orderInCookie))
        {
            $productInCookie = $orderInCookie->getProducts();
            $productsInCookie = [];
            foreach ($productInCookie as $product)
            {
                $productsInCookie[] = $product->getId();
            }

            $orderOfUser = $orderRepository->findOrderByUser($user);

            if (!empty($orderOfUser))
            {
                $products = $orderOfUser->getProducts();
                $productsOfUser = [];
                foreach ($products as $product) {
                    $productsOfUser[] = $product->getId();
                }

                $entityManager = $this->entityManager->getManager();

                foreach ($orderInCookie as $product)
                {
                    if (!in_array($product, $productsOfUser)) {
                        $product->addOrder($orderOfUser);
                        $orderOfUser->addProduct($product);
                        $entityManager->persist($orderOfUser);
                        $entityManager->persist($product);
                    }
                }
                $entityManager->remove($orderInCookie);
                $entityManager->flush();
            } else {
                $orderInCookie->setUser($user);
                $orderInCookie->setCookieId(null);
                $entityManager = $this->entityManager->getManager();
                $entityManager->persist($orderInCookie);
                $entityManager->flush();

            }
        }
    }
}