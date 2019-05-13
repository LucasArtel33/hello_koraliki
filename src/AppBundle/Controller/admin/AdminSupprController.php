<?php


namespace AppBundle\Controller\admin;

use AppBundle\Entity\Product;
use AppBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminSupprController extends Controller
{
    public function searchSuppr($request)
    {
        $searchForm = $this->createForm(SearchType::class);
        $searchFormViews = $searchForm->createView();

        $searchForm->handleRequest($request);

        if($searchForm->isSubmitted() && $searchForm->isValid())
        {
            $search = $searchForm->getData();

            $productRepository = $this->getDoctrine()->getRepository(Product::class);
            $product = $productRepository->findBy(['name' => $search]);

            return $this->render('adminViews/adminSupprProduct.html.twig',
                [
                    'searchForm' => $searchFormViews,
                    'products' => $product,
                ]
            );
        }

        return $searchFormViews;
    }

    /**
     * @Route("/admin/suppr_product", name="supprProduct")
     */
    public function supprProductAction(Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['enabled' => '1']);

        $searchFormViews = $this->searchSuppr($request);

        return $this->render('adminViews/adminSupprProduct.html.twig',
            [
                'searchForm' => $searchFormViews,
                'products' => $products,
            ]
        );
    }

    /**
     * @Route("/admin/suppr_product/{category}", name="supprProductCategory")
     */
    public function supprProductCategory($category, Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findBy(['category' => $category, 'enabled' => '1']);

        $searchFormViews = $this->searchSuppr($request);

        return $this->render('adminViews/adminSupprProduct.html.twig',
            [
                'products' => $products,
                'searchForm' => $searchFormViews,

            ]
        );
    }

    /**
     * @Route("/admin/suppr_product_{id}", name="supprProductId")
     */
    public function supprProductIdAction($id)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        $product->setEnabled(0);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('supprProduct');
    }
}