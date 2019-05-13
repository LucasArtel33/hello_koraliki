<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['highlight' => '1']);

        return $this->render('publicViews/index.html.twig',
            [
                'products' => $products,
            ]
        );
    }

    /**
     * @Route("/univers", name="univers")
     */
    public function universAction()
    {
        return $this->render('publicViews/univers.html.twig');
    }




}

