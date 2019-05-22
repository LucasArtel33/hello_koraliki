<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicCollierController extends Controller
{
    /**
     * @Route("/collier", name="allCollier")
     */
    public function allCollierAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '2', 'enabled' => '1']);

        $user = $this->getUser();

        if($user != null)
        {
            return $this->render('publicViews/collier.html.twig',
                [
                    'template' => 'baseLog.html.twig',
                    'products' => $products,
                ]
            );
        }

        return $this->render('publicViews/collier.html.twig',
            [
                'template' => 'base.html.twig',
                'products' => $products,
            ]
        );
    }

    /**
     * @Route("/collier/asc", name="collier_asc")
     */
    public function collierAscAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '2', 'enabled' => '1'],['price' => 'ASC']);

        $user = $this->getUser();

        if($user != null)
        {
            return $this->render('publicViews/collier.html.twig',
                [
                    'template' => 'baseLog.html.twig',
                    'products' => $products,
                ]
            );
        }

        return $this->render('publicViews/collier.html.twig',
            [
                'products' => $products,
                'template' => 'base.html.twig',
            ]
        );
    }

    /**
     * @Route("/collier/desc", name="collier_desc")
     */
    public function collierDescAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => '2', 'enabled' => '1'],['price' => 'DESC']);

        $user = $this->getUser();

        if($user != null)
        {
            return $this->render('publicViews/collier.html.twig',
                [
                    'template' => 'baseLog.html.twig',
                    'products' => $products,
                ]
            );
        }

        return $this->render('publicViews/collier.html.twig',
            [
                'template' => 'base.html.twig',
                'products' => $products,
            ]
        );
    }

    /**
     * @Route("/collier/{id}", name="collier")
     */
    public function collierAction($id)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        $products = $productRepository->findBy(['category' => '2', 'enabled' => '1'] );
        $moreProduct = [];
        for($i = 0; $i < 5; $i = count($moreProduct)){
            $rand_keys = array_rand($products, 1);
            if ($products[$rand_keys]->getid() != $id){
                if(!in_array($products[$rand_keys], $moreProduct))
                    $moreProduct[] = $products[$rand_keys];
            }
        }

        $user = $this->getUser();

        if($user != null)
        {
            return $this->render('publicViews/product.html.twig',
                [
                    'template' => 'baseLog.html.twig',
                    'products' => $products,
                ]
            );
        }
        return $this->render('publicViews/product.html.twig',
            [
                'template' => 'base.html.twig',
                'product' => $product,
                'moreProduct' => $moreProduct,
            ]
        );
    }
}