<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
use AppBundle\Entity\Status_orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class PublicCartController extends Controller
{
    /**
     * @Route("/add_cart/{idProduct}", name="addCart")
     */
    public function addCartAction($idProduct)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $productOrder = $productRepository->find($idProduct);

        $statusRepository = $this->getDoctrine()->getRepository(Status_orders::class);
        $statusOrder = $statusRepository->find(1);
        $order = new Orders();

        $order->setStatusOrder($statusOrder);
        $order->addProduct($productOrder);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        $products = $productRepository->findBy(['highlight' => '1']);

        return $this->render('publicViews/index.html.twig',
            [
                'products' => $products,
            ]
        );
    }
}