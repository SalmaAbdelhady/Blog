<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("AppBundle:Homepage:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $limit = $request->query->get('limit', 3);
        $page  = $request->query->get('page', 1);

        $query = $this->get('doctrine.orm.default_entity_manager')->getRepository('AppBundle:Post')->createQueryBuilder('p');
        $query = $query->select('p')
            ->where($query->expr()->eq('p.isPublished', true))
            ->orderBy('p.updated', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($page);


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return array(
            'data' => $pagination,
        );
    }
}
