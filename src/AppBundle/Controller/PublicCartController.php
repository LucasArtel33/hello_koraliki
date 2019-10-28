<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
use AppBundle\Entity\Status_orders;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class PublicCartController extends Controller
{

    /**
     * @Route("/panier", name="panier")
     */
    public function showPanierAction()
    {
//        $user = $this->getUser();
//
//        $userId = $user->getId();
//
//        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
//        //        $order = $orderRepository->findBy(['statusOrder' => 1, 'user' => $userId]);
//        $order = $orderRepository->findProductByOrder($userId);
//        if(empty($order))
//        {
//            return $this->render('publicViews/emptyCart.html.twig');
//        }
//        $product = $order->getProducts();
//        $total = 0;
//        foreach ($product as &$value )
//        {
//            $price = $value->getPrice();
//            $total += $price;
//        }
//        $total +=5;
//        return $this->render('publicViews/publicPanier.html.twig',
//
//            [
//                'products' => $product,
//                'total' => $total
//            ]
//        );
    }

    /**
     * @Route("/revove_cart/{id}", name="removeCart")
     */
    public function removeCartAction($id)
    {
//        $user = $this->getUser();
//        $userId = $user->getId();
//
//        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
//        $order = $orderRepository->findOneBy(['statusOrder' => 1, 'user' => $userId]);
//
//        $productRepository = $this->getDoctrine()->getRepository(Product::class);
//        $productOrder = $productRepository->find($id);
//
//        $order->removeProduct($productOrder);
//        $productOrder->removeOrder($order);
//
//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->persist($order);
//        $entityManager->persist($productOrder);
//        $entityManager->flush();
//
//        return $this->redirectToRoute('panier');
    }

}