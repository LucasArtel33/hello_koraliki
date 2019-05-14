<?php


namespace AppBundle\Controller\admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdminUpdateProductController extends Controller
{
    /**
     * @Route("/admin/update_product/{id}", name="updateProduct")
     */
    public function updateProductAction()
    {
        return $this->render('adminViews/adminUpdateProduct.html.twig');
    }

}