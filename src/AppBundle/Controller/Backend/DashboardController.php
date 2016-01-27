<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 1/2/16
 * Time: 9:22 PM
 */

namespace AppBundle\Controller\Backend;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * @Route("")
     */
    public function indexAction()
    {
        $qb    = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository("AppBundle:Post")
            ->createQueryBuilder('p');
        $posts = $qb->select('COUNT(p)')
            ->where($qb->expr()->eq('p.isPublished', true))->getQuery()->getSingleScalarResult();


        return $this->render("@App/Backend/backend.html.twig", ['posts' => $posts]);
    }
}