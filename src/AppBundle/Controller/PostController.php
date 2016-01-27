<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 1/26/16
 * Time: 12:27 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class PostController
 * @package AppBundle\Controller
 * @Route("post")
 */
class PostController extends Controller
{
    /**
     * @Route("/{id}",defaults={"slug"=false},requirements={"id" = "\d+"})
     * @Route("/{slug}",defaults={"id"=false},name="app_post_view_slug")
     * @Template()
     */
    public function viewAction($id = false, $slug = false)
    {
        $postRepo = $this->get('doctrine.orm.default_entity_manager')->getRepository('AppBundle:Post');

        if ($slug === false) {
            $post = $postRepo->find($id);
            if (!$post instanceof Post) {
                throw $this->createNotFoundException();
            }
            return $this->redirectToRoute('app_post_view_slug', array('slug' => $post->getSlug()));
        }
        $post = $postRepo->findOneBySlug($slug);
        if (!$post instanceof Post) {
            throw $this->createNotFoundException();
        }


        return array('post' => $post);
    }
}