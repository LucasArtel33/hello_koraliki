<?php


namespace AppBundle\Controller\admin;


use AppBundle\Entity\Image;
use AppBundle\Entity\Product;
use AppBundle\Form\AddProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class adminController extends Controller
{
    /**
     * @Route("/admin", name="adminHome")
     */
    public function adminHomeAction()
    {
        return $this->render('adminViews/adminHome.html.twig');
    }

}














