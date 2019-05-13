<?php


namespace AppBundle\Controller\admin;

use AppBundle\Entity\Product;
use AppBundle\Form\HighlightType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminHighlightController extends Controller
{
    /**
     * @Route("/admin/highlight", name="adminHighlight")
     */
    public function adminHighlightAction(Request $request)
    {
        $highlightForm = $this->createForm(HighlightType::class);
        $highlightFormView = $highlightForm->createView();

        $highlightForm->handleRequest($request);

        if($highlightForm->isSubmitted() && $highlightForm->isValid())
        {
            $productRepository = $this->getDoctrine()->getRepository(Product::class);
            $unsetHighlight = $productRepository->findBy(['highlight' => 1]);

            $unsetHighlight[0]->setHighlight(0);
            $unsetHighlight[1]->setHighlight(0);
            $unsetHighlight[2]->setHighlight(0);
            $produit = $highlightForm->getData();

            $produit1 = $productRepository->findBy(['name' => $produit['product1']]);
            $produit2 = $productRepository->findBy(['name' => $produit['product2']]);
            $produit3 = $productRepository->findBy(['name' => $produit['product3']]);

            $produit1[0]->setHighlight(1);
            $produit2[0]->setHighlight(1);
            $produit3[0]->setHighlight(1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($unsetHighlight[0]);
            $entityManager->persist($unsetHighlight[1]);
            $entityManager->persist($unsetHighlight[2]);
            $entityManager->persist($produit1[0]);
            $entityManager->persist($produit2[0]);
            $entityManager->persist($produit3[0]);
            $entityManager->flush();
        }

        return $this->render('adminViews/adminHighlight.html.twig',
            [
                'highlightForm' => $highlightFormView
            ]);
    }
}