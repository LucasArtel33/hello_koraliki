<?php


namespace AppBundle\Controller\admin;


use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use AppBundle\Form\StockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminUpdateProductController extends Controller
{
    /**
     * @Route("/admin/update_stock/{id}", name="updateStock")
     */
    public function updatestockAction($id, Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        $stockForm = $this->createForm(StockType::class, $product);
        $stockFormView = $stockForm->createView();

        $stockForm->handleRequest($request);

        if($stockForm->isSubmitted() && $stockForm->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->render('adminViews/adminUpdateStockSuccess.html.twig');
        }

        return $this->render('adminViews/adminUpdateStock.html.twig',
            [
                'stockForm' => $stockFormView,
                'product' => $product,
            ]
        );
    }

    /**
     * @Route("/admin/update_produit/{id}", name="updateProduit")
     */
    public function updateProductAction($id, Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        $productForm = $this->createForm(ProductType::class, $product);
        $productFormView = $productForm->createView();

        $productForm->handleRequest($request);

        if($productForm->isSubmitted() && $productForm->isValid())
        {
            $productUpdate = new Product();

            $stockProduct = $product->getStock();
            $priceProduct = $product->getPrice();
            $nameProduct = $product->getName();
            $descriptionProduct = $product->getDescription();
            $highlightProduct = $product->getHighlight();
            $categoryProduct = $product->getCategory();
            $imgProduct = $product->getImg();

            $productUpdate->setStock($stockProduct);
            $productUpdate->setPrice($priceProduct);
            $productUpdate->setName($nameProduct);
            $productUpdate->setDescription($descriptionProduct);
            $productUpdate->setHighlight($highlightProduct);
            $productUpdate->setCategory($categoryProduct);
            $productUpdate->setImg($imgProduct);
            $productUpdate->setEnabled(1);

            $product->setEnabled(0);
            $product->setHighlight(0);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->persist($productUpdate);
            $entityManager->flush();

        }

        return $this->render('adminViews/adminUpdateProduct.html.twig',
            [
                'productForm' => $productFormView,
            ]
        );
    }

}