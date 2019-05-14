<?php


namespace AppBundle\Controller\admin;


use AppBundle\Entity\Product;
use AppBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminGestionProduct extends Controller
{
    private function searchProduct($request)
    {
        $searchForm = $this->createForm(SearchType::class);
        $searchFormViews = $searchForm->createView();

        $searchForm->handleRequest($request);

        if($searchForm->isSubmitted() && $searchForm->isValid())
        {
            $search = $searchForm->getData();

            $productRepository = $this->getDoctrine()->getRepository(Product::class);
            $product = $productRepository->findBy(['name' => $search]);

            return $this->render('adminViews/adminUpdateProductSelect.html.twig',
                [
                    'searchForm' => $searchFormViews,
                    'products' => $product,
                ]
            );
        }

        return $searchFormViews;
    }

    /**
     * @Route("/admin/product_select", name="adminProductSelect")
     */
    public function updateProductSelectAction (Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['enabled' => '1']);

        $searchFormViews = $this->searchProduct($request);

        return $this->render('adminViews/adminGestionProduct.html.twig',
            [
                'searchForm' => $searchFormViews,
                'products' => $products,
            ]
        );
    }

    /**
     * @Route("/admin/product_select/{category}", name="adminProductSelectCategory")
     */
    public function supprProductCategory($category, Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => $category, 'enabled' => '1']);

        $searchFormViews = $this->searchProduct($request);

        return $this->render('adminViews/adminGestionProduct.html.twig',
            [
                'products' => $products,
                'searchForm' => $searchFormViews,

            ]
        );
    }
}