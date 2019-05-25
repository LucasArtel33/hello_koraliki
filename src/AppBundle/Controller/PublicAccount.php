<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Address;
use AppBundle\Entity\Orders;
use AppBundle\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublicAccount extends Controller
{
    /**
     * @Route("/mes_informations", name="informationClient")
     */
    public function informationClientAction()
    {
        return $this->render('publicViews/informationClient.html.twig');
    }

    /**
     * @Route("/ajout_adresse", name="addAddress")
     */
    public function addAddressAction(Request $request)
    {
        $address = new Address();
        $addressForm = $this->createForm(AddressType::class, $address);
        $addressFormView = $addressForm->createView();

        $addressForm->handleRequest($request);

        if($addressForm->isSubmitted() && $addressForm->isValid())
        {
            $user = $this->getUser();

            $address->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->render('publicViews/addAddress.html.twig',
                [
                    'addressForm' => $addressFormView,
                ]
            );
        }

        return $this->render('publicViews/addAddress.html.twig',
            [
                'addressForm' => $addressFormView,
            ]
        );
    }

    /**
     * @Route("/historique_Commande", name="historiqueOrders")
     */
    public function historiqueOrdersAction()
    {
        $user = $this->getUser();

        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
        $orders = $orderRepository->findBy(['user' => $user]);
//        dump($orders);die;

        return $this->render('publicViews/suiviCommande.html.twig',
            [
                'orders' => $orders,
            ]
        );
    }


}