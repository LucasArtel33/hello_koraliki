<?php


namespace AppBundle\Controller;


use AppBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class PublicPersoController extends Controller
{
    private function sendEmail($data){
        $ContactMail = 'lucas.dev33@gmail.com';
        $ContactPassword = 'cjs[8e5234';

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($ContactMail)
            ->setPassword($ContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("HelloKoraliki mail ". $data["firstname"])
            ->setFrom([$ContactMail => "Message par ".$data["firstname"]." ".$data["lastname"]])
            ->setTo([ $ContactMail => $ContactMail ])
            ->setBody($data["message"]."<br>ContactMail :".$data["email"])
            ->attach(\Swift_Attachment::fromPath('/web/assets/document/'.$laVariable.'.pdf'));

        return $mailer->send($message);
    }

    /**
     * @Route("/personalisation", name="personnalisation")
     */
    public function personalisationAction(Request $request)
    {
        $form = $this->createForm(ContactType::class,null,
            [
                'method' => 'POST',
            ]
        );

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()){
                if($this->sendEmail($form->getData())){
                    return $this->redirectToRoute('messageEnvoyer');
                }else{
                    var_dump("Errooooor :(");
                }
            }
        }

        $user = $this->getUser();

        if($user != null)
        {
            return $this->render('publicViews/personnalisation.html.twig',
                [
                    'template' => 'baseLog.html.twig',
                    'form' => $form->createView(),
                ]
            );
        }

        return $this->render('publicViews/personnalisation.html.twig',
            [
                'template' => 'base.html.twig',
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/message_envoyer", name="messageEnvoyer")
     */
    public function reussiAction()
    {
        return $this->render('publicViews/msgEnvoye.html.twig');
    }
}