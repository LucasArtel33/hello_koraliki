<?php


namespace AppBundle\Controller\admin;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminProductController extends Controller
{
    /**
     * @Route("/admin/add_product", name="addProduct")
     */
    public function addProductAction(Request $request)
    {
        $product = new Product();
        $productForm = $this->createForm(ProductType::class, $product);
        $productFormView = $productForm->createView();

        $productForm->handleRequest($request);

        if($productForm->isSubmitted() && $productForm->isValid())
        {
            $product->setEnabled(1);
            $product->setHighlight(0);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('addProductSucess');
        }

        return $this->render('adminViews/adminProduct.html.twig',
            [
                'productForm' => $productFormView,
            ]
        );
    }

    /**
     * @Route("/admin/add_product/success", name="addProductSucess")
     */
    public function addProductSucessaction()
    {
        return $this->render('adminviews/adminAddProductSuccess.html.twig');

    }

}