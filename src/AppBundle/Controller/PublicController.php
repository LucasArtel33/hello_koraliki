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

        $user = $this->getUser();

        if($user != null)
        {
            return $this->render('publicViews/indexLogin.html.twig',
                [
                    'products' => $products,
                ]
            );
        }
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
        $user = $this->getUser();

        if($user != null)
        {
            return $this->render('publicViews/univers.html.twig',
                [
                    'template' => 'baseLog.html.twig',
                ]
            );
        }
        return $this->render('publicViews/univers.html.twig',
            [
                'template' => 'base.html.twig',
            ]
        );
    }




}

