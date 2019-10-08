<?php


namespace AppBundle\Controller\admin;

use AppBundle\Entity\Image;
use AppBundle\Entity\Product;
use AppBundle\Form\AddProductType;
use AppBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminProductController extends Controller
{
    private function uploadImage($result,$imageNumber,$image)
    {
        $processedImage = $result['img'.$imageNumber];
        $processedImageName = md5(uniqid()).'.'.$processedImage->guessExtension();
        try {
            $processedImage->move(
                $this->getParameter('upload_img_product'),
                $processedImageName
            );
        } catch (FileException $e) {
            throw new \Exception($e->getMessage());
        }
        if($imageNumber == 1){
            $image->setImg1($processedImageName);
        } elseif ($imageNumber == 2){
            $image->setImg2($processedImageName);
        } elseif ($imageNumber == 3){
            $image->setImg3($processedImageName);
        }
    }

    /**
     * @Route("/admin/add_product", name="addProduct")
     */
    public function addProductAction(Request $request)
    {
        $image = new Image();
        $product = new Product();
        $addProductForm = $this->createForm(AddProductType::class);
        $addProductFormView = $addProductForm->createView();

        $addProductForm->handleRequest($request);

        if($addProductForm->isSubmitted() && $addProductForm->isValid())
        {
            $result = $addProductForm->getData();
            $format = ['jpg', 'jpeg', 'png'];

            $extentionImg1 = $result['img1']->guessExtension();
            if (!in_array($extentionImg1 ,$format))
            {
                $error1 = 'Le format de l\'image n\'est pas correct.';
                return $this->render('adminViews/adminAddProduct.html.twig',
                    [
                        'productAddForm' => $addProductFormView,
                        'error1' => $error1
                    ]
                );
            }
            if (filesize($result['img1']) > 2000000 )
            {
                $error1 = 'L\'image est trop volumineuse';
                return $this->render('adminViews/adminAddProduct.html.twig',
                    [
                        'productAddForm' => $addProductFormView,
                        'error1' => $error1
                    ]
                );
            }

            $this->uploadImage($result, 1,$image);
            if (!empty($result['img2'])){
                $this->uploadImage($result, 2,$image);
            }
            if (!empty($result['img3'])) {
                $this->uploadImage($result, 3, $image);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            $product->setImg($image);
            $product->setCategory($result['category']);
            $product->setStock($result['stock']);
            $product->setPrice($result['price']);
            $product->setName($result['name']);
            $product->setDescription($result['description']);
            $product->setEnabled(1);
            $product->setHighlight(0);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('addProductSuccess');
        }

        return $this->render('adminViews/adminAddProduct.html.twig',
            [
                'productAddForm' => $addProductFormView,
            ]
        );

    }

    /**
     * @Route("/admin/add_product/success", name="addProductSuccess")
     */
    public function addProductSucessaction()
    {
        return $this->render('adminviews/adminAddProductSuccess.html.twig');

    }

}