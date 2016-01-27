<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 1/26/16
 * Time: 12:27 AM
 */

namespace AppBundle\Controller\Backend;


use AppBundle\Entity\Post;
use AppBundle\Forms\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PostController
 * @package AppBundle\Controller\Backend
 * @Route("post")
 */
class PostController extends Controller
{
    /**
     * @Route("")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $limit = $request->query->get('limit', 20);
        $page  = $request->query->get('page', 1);

        $query = $this->get('doctrine.orm.default_entity_manager')->getRepository('AppBundle:Post')->createQueryBuilder('p');
        $query = $query->select('p')
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

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(new PostType(), null);
        $em   = $this->get('doctrine.orm.default_entity_manager');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Post $post */
                $post = $form->getData();
                $url  = $this->generateUrl('app_post_view', array('slug' => $post->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL);
                $post->setPermalink($url);
                $post->setAuthor($this->getUser());
                $em->persist($post);
                $em->flush($post);

                $this->addFlash('success', 'Post Added successfully');

                return $this->redirectToRoute('app_backend_post_edit', array('id' => $post->getId()));
            }
        }

        return array('form' => $form->createView());
    }


    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        /** @var Post $post */
        $post = $em->getRepository('AppBundle:Post')->find($id);
        $form = $this->createForm(new PostType(), $post);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $post = $form->getData();
                $em->persist($post);
                $em->flush($post);
                $this->addFlash('success', 'Updated successfully');

                return $this->redirectToRoute('app_backend_post_edit', array('id' => $post->getId()));
            }
        }

        return array('form' => $form->createView(), 'post' => $post);
    }


    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        /** @var Post $post */
        $post = $em->getRepository('AppBundle:Post')->find($id);
        $em->remove($post);
        $em->flush($post);
        $this->addFlash('success', 'Post Removed successfully');

        return $this->redirectToRoute('app_backend_post_index');
    }
}