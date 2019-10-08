<?php


namespace AppBundle\Form;


use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('img1', FileType::class)
                ->add('img2', FileType::class, ['required' => false])
                ->add('img3', FileType::class, ['required' => false])
                ->add('stock')
                ->add('price')
                ->add('name')
                ->add('description')
                ->add('category', EntityType::class,
                    [
                        'class' => Category::class,
                        'choice_label' => 'type'
                    ]
                )
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