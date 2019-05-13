<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('attr' => ['placeholder' => 'Prénom', 'class' => 'firstname'],
                'constraints' => array(
                    new NotBlank(array("message" => "Merci de renseigner votre prénom."))
                )
            ))
            ->add('lastname', TextType::class, array('attr' => array('placeholder' => 'Nom', 'class' => 'lastname'),
                'constraints' => array(
                    new NotBlank(array("message" => "Merci de renseigner votre nom.")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Adresse Mail', 'class' => 'email'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a valid email")),
                    new Email(array("message" => "Merci de renseigner votre adresse mail.")),
                )
            ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Ton message ici', 'class' => 'message', 'row'),
                'constraints' => array(
                    new NotBlank(array("message" => "Merci de saisir un message")),
                )
            ))
        ;

    }


    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }
}