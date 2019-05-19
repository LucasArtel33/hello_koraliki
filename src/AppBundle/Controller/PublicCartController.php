<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
use AppBundle\Entity\Status_orders;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class PublicCartController extends Controller
{
    /**
     * @Route("/add_cart/{idProduct}", name="addCart")
     */
    public function addCartAction($idProduct)
    {
//      je recupere l'utilisateur
        $user = $this->getUser();
//      je verifie qu'un utilisateur est connecter
        if($user != null)
        {
//          je recupere l'id de l'utilisateur
            $userId = $user->getId();

//          Je recupere un array qui contient, si il en existe une, une commande lie a
//          l'utilisateur au status 1 soit 'panier'
            $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
            $order = $orderRepository->findBy(['statusOrder' => 1, 'user' => $userId]);
//          je verifie qu'il y a une commande dans le panier, sinon j'en initialise une nouvelle

//          si il n'y a pas de commande j'en initie une nouvelle
            if(empty($order))
            {
                $order = new Orders();
            }
            else{
//          sinon je recupere la commande dans
                $order =$order['0'];
            }
//          je recupere le produit cible avec l'id recup dans la wildcard
            $productRepository = $this->getDoctrine()->getRepository(Product::class);
            $productOrder = $productRepository->find($idProduct);

            $productOrder->addOrder($order);

            $user->addOrder($order);

            $statusRepository = $this->getDoctrine()->getRepository(Status_orders::class);
            $statusOrder = $statusRepository->find(1);

            $order->setStatusOrder($statusOrder);
            $order->addProduct($productOrder);
            $order->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($order);
            $entityManager->persist($productOrder);
            $entityManager->flush();

            return $this->render('publicViews/ajoutPanier.html.twig');
        }
        return $this->render('publicViews/connection.html.twig');
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function showPanierAction()
    {

    }
}