<?php

namespace AppBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;

class BlogExtension extends \Twig_Extension
{
    /** @var EntityManager $em */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * add custom functions
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'getBlogCategories' => new \Twig_Function_Method($this, 'getBlogCategories')
        );
    }

    /**
     * @return \AppBundle\Entity\Category[]|array
     */
    public function getBlogCategories()
    {
        $categoryRepo = $this->em->getRepository('AppBundle:Category');

        return $categoryRepo->findBy(array('parent' => 1, 'visibility' => true));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'blog';
    }
}
