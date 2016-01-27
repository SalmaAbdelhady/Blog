<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 1/25/16
 * Time: 10:29 PM
 */

namespace AppBundle\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('title', 'text')
            ->add('content', 'textarea', array('attr' => array('rows' => 10)))
            ->add('category', 'entity', array('class'         => 'AppBundle\Entity\Category',
                                              'query_builder' => function (\Doctrine\ORM\EntityRepository $em) {
                                                 $qb = $em->createQueryBuilder('c');
                                                  return $qb->select('c')
                                                      ->where($qb->expr()->eq('c.visibility',1));
                                              }))
            ->add('is_commentable', 'checkbox')
            ->add('isPublished', 'checkbox');
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
            array(
                'data_class'      => 'AppBundle\Entity\Post',
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
        return 'blog_post';
    }

}