<?php


namespace AppBundle\Controller\admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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