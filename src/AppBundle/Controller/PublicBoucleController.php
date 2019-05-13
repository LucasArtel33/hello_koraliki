<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PublicBoucleController extends Controller
{

    /**
     * @Route("/boucle", name="allBoucle")
     */
    public function allBoucleAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '3']);

        $nombre = count($products);

        return $this->render('publicViews/boucle.html.twig',
            [
                'products' => $products,
                'nombre' => $nombre,
            ]
        );
    }

    /**
     * @Route("/boucle/asc", name="boucle_asc")
     */
    public function boucleAscAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '3'],['price' => 'ASC']);

        $nombre = count($products);

        return $this->render('publicViews/boucle.html.twig',
            [
                'products' => $products,
                'nombre' => $nombre,
            ]
        );
    }

    /**
     * @Route("/boucle/desc", name="boucle_desc")
     */
    public function boucleDescAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '3'],['price' => 'DESC']);

        $nombre = count($products);

        return $this->render('publicViews/boucle.html.twig',
            [
                'products' => $products,
                'nombre' => $nombre,
            ]
        );
    }

    /**
     * @Route("/boucle/{id}", name="boucle")
     */
    public function boucleAction($id)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        $products = $productRepository->findBy(['category' => '3'] );
        $moreProduct = [];
        for($i = 0; $i < 5; $i = count($moreProduct)){
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