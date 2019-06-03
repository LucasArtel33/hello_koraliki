<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Address;
use AppBundle\Entity\Orders;
use AppBundle\Entity\Status_orders;
use AppBundle\Form\AddressOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicOrderController extends Controller
{
    /**
     * @Route("/commande", name="commande")
     */
    public function commandeAction(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->getId();
//      je recupere les adresse deja saisie par l'utilisateur
        $addressRepository = $this->getDoctrine()->getRepository(Address::class);
        $allAddress = $addressRepository->findBy(['user' => $user]);

        if ($request->isMethod('POST'))
        {
                $request->request->get($request->query->get('address'));
                $address = $request->get('address');
//              Traitement du formulaire d'une nouvelle adresse
                if( $address == 'newAddress')
                {
//                  je recupere les donnees saisie
                    $name = $request->get('addressName');
                    $address1 = $request->get('address1');
                    $address2 = $request->get('address2');
                    $zipcode = $request->get('zipCode');
                    $city = $request->get('city');
                    $country = $request->get('country');
//                  je l'ai set dans un nouvel objet Address
                    $newAddress = new Address();
                    $newAddress->setName($name);
                    $newAddress->setAddress1($address1);
                    $newAddress->setAddress2($address2);
                    $newAddress->setZipcode($zipcode);
                    $newAddress->setCity($city);
                    $newAddress->setCountry($country);
                    $newAddress->setUser($user);
//                  j'envoi la nouvelle adresse en BDD
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($newAddress);
                    $entityManager->flush();

                }
                else{
                    $name = $address;
                }
//              je recupere l'adresse soit selectionner soit la nouvelle adresse saisie
                $addressExp = $addressRepository->findBy(['name' => $name]);
                $addressExp = $addressExp[0];
//              je recupere l'order du client.
                $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
                $order = $orderRepository->findOneBy(['statusOrder' => 1, 'user' => $userId]);
//              je recupere le statut de commande 'payer'
                $statusRepository = $this->getDoctrine()->getRepository(Status_orders::class);
                $statusOrder = $statusRepository->find(2);
//              je set les parametre a mon object order
                $order->setAddress($addressExp);
                $order->setStatusOrder($statusOrder);

                //              GESTION DU STOCK

                $orderProducts = $orderRepository->findProductByOrder($userId);

                $product = $orderProducts->getProducts();
                foreach ($product as &$value)
                {
                    $entityManager = $this->getDoctrine()->getManager();
                    $stock = $value->getStock();
                    $newStock = $stock - 1;
                    $value->setStock($newStock);
                    $entityManager->persist($value);
                    $entityManager->flush();
                }
//              je stock en BDD

                $entityManager->persist($order);
                $entityManager->flush();

                return new Response('commande ok');

        }

        return $this->render('publicViews/commande.html.twig',
            [
                'allAddress' => $allAddress,
            ]
        );
    }
}