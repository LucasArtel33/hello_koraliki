<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PublicBraceletController extends Controller
{

    /**
     * @Route("/bracelet", name="allBracelet")
     */
    public function allBraceletAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '1', 'enabled' => '1']);

        $nombre = count($products);

        return $this->render('publicViews/bracelet.html.twig',
            [
                'products' => $products,
                'nombre' => $nombre,
            ]
        );
    }

    /**
     * @Route("/bracelet/asc", name="bracelet_asc")
     */
    public function braceletAscAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '1', 'enabled' => '1'],['price' => 'ASC']);

        $nombre = count($products);

        return $this->render('publicViews/bracelet.html.twig',
            [
                'products' => $products,
                'nombre' => $nombre,
            ]
        );
    }

    /**
     * @Route("/bracelet/desc", name="bracelet_desc")
     */
    public function braceletDescAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '1', 'enabled' => '1'],['price' => 'DESC' ]);

        $nombre = count($products);

        return $this->render('publicViews/bracelet.html.twig',
            [
                'products' => $products,
                'nombre' => $nombre,
            ]
        );
    }

    /**
     * @Route("/bracelet/{id}", name="bracelet")
     */
    public function braceletAction($id)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        $products = $productRepository->findBy(['category' => '1', 'enabled' => '1'] );
        $moreProduct = [];
        for($i = 1; $i < 5; $i = count($moreProduct)){
            $rand_keys = array_rand($products, 1);
            if ($products[$rand_keys]->getid() != $id){
                if(!in_array($products[$rand_keys], $moreProduct))
                    $moreProduct[] = $products[$rand_keys];
            }
        }

        return $this->render('publicViews/product.html.twig',
            [
                'product' => $product,
                'moreProduct' => $moreProduct,

            ]
        );
    }
}