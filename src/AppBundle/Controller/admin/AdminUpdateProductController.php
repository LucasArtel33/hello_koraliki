<?php


namespace AppBundle\Controller\admin;


use AppBundle\Entity\Product;
use AppBundle\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminUpdateProductController extends Controller
{
    public function searchUpdate($request)
    {
        $searchForm = $this->createForm(SearchType::class);
        $searchFormViews = $searchForm->createView();

        $searchForm->handleRequest($request);

        if($searchForm->isSubmitted() && $searchForm->isValid())
        {
            $search = $searchForm->getData();

            $productRepository = $this->getDoctrine()->getRepository(Product::class);
            $product = $productRepository->findBy(['name' => $search]);

            return $this->render('adminViews/adminUpdateProduct.html.twig',
                [
                    'searchForm' => $searchFormViews,
                    'products' => $product,
                ]
            );
        }

        return $searchFormViews;
    }
    /**
     * @Route("/admin/update_product_select", name="updateProductSelect")
     */
    public function updateProductSelectAction (Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['enabled' => '1']);

        $searchFormViews = $this->searchUpdate($request);

        return $this->render('adminViews/adminUpdateProduct.html.twig',
            [
                'searchForm' => $searchFormViews,
                'products' => $products,
            ]
        );
    }

    /**
     * @Route("/admin/update_product_select/{category}", name="updateCategory")
     */
    public function supprProductCategory($category, Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => $category, 'enabled' => '1']);

        $searchFormViews = $this->searchUpdate($request);

        return $this->render('adminViews/adminUpdateProduct.html.twig',
            [
                'products' => $products,
                'searchForm' => $searchFormViews,

            ]
        );
    }

    /**
     * @Route('/admin/update_product/{id}", name="updateProduct")
     */
}