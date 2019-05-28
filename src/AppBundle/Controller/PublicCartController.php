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
     * @Route("/add_cart/{idProduct}", name="addCart")
     */
    public function addCartAction($idProduct)
    {
//      je recupere l'utilisateur
        $user = $this->getUser();

//      je recupere l'id de l'utilisateur
        $userId = $user->getId();

//      Je recupere un array qui contient, si il en existe une, une commande lie a
//      l'utilisateur au status 1 soit 'panier'
        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
        $order = $orderRepository->findProductByOrder($userId);
//      si il n'y a pas de commande j'en initie une nouvelle
        if(empty($order))
        {
            $order = new Orders();
        }

//      je recupere le produit cible avec l'id recup dans la wildcard
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $productOrder = $productRepository->find($idProduct);

        $category = $productOrder->getCategory();
        $category = $category->getId();
        if($category == 1){
            $category = 'allBracelet';
        }
        elseif ($category == 2){
            $category = 'allCollier';
        }
        elseif( $category == 3){
            $category = 'allBoucle';
        }

//        $productInOrder = $orderRepository->findProductByOrder($userId);
        $products = $order->getProducts();

        foreach ($products as $produit)
        {
            if($idProduct = $produit->getId()){
                return $this->render('publicViews/inCart.html.twig',
                    [
                        'category' => $category,
                    ]
                );
            }
        }

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

        return $this->render('publicViews/ajoutPanier.html.twig',
            [
                'category' => $category,
            ]
        );
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function showPanierAction()
    {
        $user = $this->getUser();

        $userId = $user->getId();

        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
        //        $order = $orderRepository->findBy(['statusOrder' => 1, 'user' => $userId]);
        $order = $orderRepository->findProductByOrder($userId);
        if(empty($order))
        {
            return $this->render('publicViews/emptyCart.html.twig');
        }
        $product = $order->getProducts();
        $total = 0;
        foreach ($product as &$value )
        {
            $price = $value->getPrice();
            $total += $price;
        }
        $total +=5;
        return $this->render('publicViews/publicPanier.html.twig',

            [
                'products' => $product,
                'total' => $total
            ]
        );
    }

    /**
     * @Route("/revove_cart/{id}", name="removeCart")
     */
    public function removeCartAction($id)
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $orderRepository = $this->getDoctrine()->getRepository(Orders::class);
        $order = $orderRepository->findOneBy(['statusOrder' => 1, 'user' => $userId]);

        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $productOrder = $productRepository->find($id);

        $order->removeProduct($productOrder);
        $productOrder->removeOrder($order);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->persist($productOrder);
        $entityManager->flush();

        return $this->redirectToRoute('panier');
    }

}