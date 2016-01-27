<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 1/26/16
 * Time: 2:27 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 * @Route("category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/{id}")
     * @Template()
     */
    public function indexAction(Request $request, $id)
    {
        $category = $this->get('doctrine.orm.default_entity_manager')->getRepository('AppBundle:Category')->find($id);

        if (!$category instanceof Category) {
            throw $this->createNotFoundException();
        }

        $limit = $request->query->get('limit', 6);
        $page  = $request->query->get('page', 1);

        $query = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Post')->getPostsByCategoryQuery($category, $limit, $page);

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