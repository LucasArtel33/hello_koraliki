<?php


namespace AppBundle\Controller\admin;

use AppBundle\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminSupprController extends Controller
{
    /**
     * @Route("/admin/confirm_suppr/{id}", name="confirmSuppr")
     */
    public function confirmSupprAction($id)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        return $this->render('adminViews/adminSupprConfirm.html.twig',
            [
                "product" => $product,
            ]);
    }

    /**
     * @Route("/admin/suppr_product/{id}", name="supprProduct")
     */
    public function supprProductIdAction($id)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        $product->setEnabled(0);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('adminProductSelect');
    }

    /**
     * @Route("/admin/annule_suppr", name="annuleSuppr")
     */
    public function annuleSupprAction()
    {
        return $this->redirectToRoute('adminProductSelect');
    }
}