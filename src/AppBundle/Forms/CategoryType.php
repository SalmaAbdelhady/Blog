<?php


namespace AppBundle\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('required' => true, 'attr' => array(
            'class' => 'form-control'
        )))
            ->add('visibility', 'checkbox', array('required' => true, 'attr' => array(
                'class' => 'checkbox'
            )));


        if (!$options['compact']) {
            $builder
                ->add('parent');
        }

    }


    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'      => 'AppBundle\Entity\Category',
                'compact'         => true,
                'csrf_protection' => false
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blog_category';
    }

}