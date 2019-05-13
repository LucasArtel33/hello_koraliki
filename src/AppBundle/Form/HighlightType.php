<?php


namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HighlightType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('product1')
                ->add('product2')
                ->add('product3')
                ->add('submit', SubmitType::class);

    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'search_form';
    }
}