<?php


namespace AppBundle\Controller\admin;


use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminImageController extends Controller
{
    private function uploadImage($image,$imageName)
    {
        try {
            $image->move(
                $this->getParameter('upload_img_product'),
                $imageName
            );
        } catch (FileException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @Route("/admin/add_image", name="addImage")
     */
    public function addImageAction(Request $request)
    {
        $image = new Image();
        $imageForm = $this->createForm(ImageType::class, $image);
        $imageFormView = $imageForm->createView();

        $imageForm->handleRequest($request);

        if($imageForm->isSubmitted() && $imageForm->isValid())
        {
            $image1 = $image->getImg1();
            $image2 = $image->getImg2();
            $image3 = $image->getImg3();

            $imageName1 = md5(uniqid()).'.'.$image1->guessExtension();
            $imageName2 = md5(uniqid()).'.'.$image2->guessExtension();
            $imageName3 = md5(uniqid()).'.'.$image3->guessExtension();

            $this->uploadImage($image1,$imageName1);
            $this->uploadImage($image2,$imageName2);
            $this->uploadImage($image3,$imageName3);

            $image->setImg1($imageName1);
            $image->setImg2($imageName2);
            $image->setImg3($imageName3);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('addImageSuccess');
        }

        return $this->render('adminViews/adminImage.html.twig',
            [
                'imageForm' => $imageFormView
            ]
        );
    }

    /**
     * @Route("/admin/add_image/success", name="addImageSuccess")
     */
    public function addImageSuccessAction()
    {
        $imageRepository = $this->getDoctrine()->getRepository(Image::class);
        $image = $imageRepository->findBy([],['id' => 'DESC'],1);

        return $this->render('adminViews/adminAddImageSuccess.html.twig',
            [
                'image' => $image,
            ]
        );
    }
}