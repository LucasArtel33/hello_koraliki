<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
use AppBundle\Entity\Status_orders;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class PublicCartTestController extends Controller
{
    private function findOrder($user, $orderRepository,  $cookieId)
    {
        if(is_object($user))
        {
            $userId = $user->getId();
            $order = $orderRepository->findOrderByUser($userId);
        } else {
            $order = $orderRepository->findOrderByCookie($cookieId);
        }
        return $order;
    }

    private function redirectToCategory($user,$productOrder)
    {
        //      Je recupere la categorie du produit pour rediriger le client sur la page categorie apres l'ajout au panier
        $category = $productOrder->getCategory();
        $category = $category->getId();

        if ($category == 1) {
            $category = 'allBracelet';
        } elseif ($category == 2) {
            $category = 'allCollier';
        } elseif ($category == 3) {
            $category = 'allBoucle';
        }

        if ($user != null){
            return $this->render('publicViews/ajoutPanier.html.twig',
                [
                    'category' => $category,
                    'template' => 'baseLog.html.twig'
                ]
            );
        } else {
            return $this->render('publicViews/ajoutPanier.html.twig',
                [
                    'category' => $category,
                    'template' => 'base.html.twig'
                ]
            );
        }
    }

    /**
     * @Route("/add_cart/{idProduct}", name="addCart")
     */
    public function addCartAction(Request $request, $idProduct)
    {
        $user = $this->getUser();
        $cookieId = $request->cookies->get('hellokoraliki_cart');

        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $productOrder = $productRepository->find($idProduct);

        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);

        $order = $this->findOrder($user, $orderRepository,$cookieId);

        if(!is_null($order))
        {
            $products = $order->getProducts();
            $productInOrder = [];
            foreach ($products as $product)
            {
                $productInOrder[] = $product->getId();
            }
            if(!in_array($productOrder->getId(), $productInOrder))
            {
                $productOrder->addOrder($order);
                $order->addProduct($productOrder);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($order);
                $entityManager->persist($productOrder);
                $entityManager->flush();

                return $this->redirectToCategory($user,$productOrder);

            } else {
                return $this->redirectToCategory($user,$productOrder);
            }
        } else {

            $order = new Orders();
            $productOrder->addOrder($order);
            $statusRepository = $this->getDoctrine()->getRepository(Status_orders::class);
            $statusOrder = $statusRepository->find(1);
            $order->setStatusOrder($statusOrder);
            $order->addProduct($productOrder);
            $order->setUser($user);
            $order->setCookieId($cookieId);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->persist($productOrder);
            $entityManager->flush();

            return $this->redirectToCategory($user,$productOrder);
        }
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function showPanierAction(Request $request)
    {
        $user = $this->getUser();
        $cookieId = $request->cookies->get('hellokoraliki_cart');


        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);

        $order = $this->findOrder($user, $orderRepository,$cookieId);

        if(empty($order))
        {
            if ( $user != null){
                return $this->render('publicViews/emptyCart.html.twig',
                        [
                            'template' =>'baseLog.html.twig'
                        ]
                    );
            } else {
                return $this->render('publicViews/emptyCart.html.twig',
                    [
                        'template' =>'base.html.twig'
                    ]
                );
            }

        }
        $product = $order->getProducts();
        $total = 0;
        foreach ($product as &$value )
        {
            $price = $value->getPrice();
            $total += $price;
        }
        $total +=5;
        if( $user != null){
            return $this->render('publicViews/publicPanier.html.twig',
                [
                    'products' => $product,
                    'total' => $total,
                    'template' => 'baseLog.html.twig'
                ]
            );
        } else {
            return $this->render('publicViews/publicPanier.html.twig',
                [
                    'products' => $product,
                    'total' => $total,
                    'template' => 'base.html.twig'
                ]
            );
        }
    }

    /**
     * @Route("/revove_cart/{id}", name="removeCart")
     */
    public function removeCartAction(Request $request, $id)
    {
        $user = $this->getUser();
        $cookieId = $request->cookies->get('hellokoraliki_cart');

        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);

        $order = $this->findOrder($user, $orderRepository,$cookieId);
        $entityManager = $this->getDoctrine()->getManager();

        if (count($order->getProducts()) == 1)
        {
            $entityManager->remove($order);
            $entityManager->flush();
            return $this->redirectToRoute('panier');
        }

        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $productOrder = $productRepository->find($id);

        $order->removeProduct($productOrder);
        $productOrder->removeOrder($order);

        $entityManager->persist($order);
        $entityManager->persist($productOrder);
        $entityManager->flush();

        return $this->redirectToRoute('panier');
    }

}