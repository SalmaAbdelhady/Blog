<?php


namespace AppBundle\Controller\Backend;


use AppBundle\Entity\Category;
use AppBundle\Forms\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class CategoryController
 * @package AppBundle\Controller\Backend
 * @Route("category")
 */
class CategoryController extends Controller
{

    /**
     * @param Request $request
     * @return array
     * @Route("")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        return array();
    }

    /**
     * @param Request $request
     * @Route("/ajax",options={"expose"=true})
     */
    public function ajaxAction(Request $request)
    {
        $orm  = $this->get('doctrine.orm.default_entity_manager');
        $data = $orm->getRepository('AppBundle:Category')->findAll();

        $categories = [];
        /** @var Category $cat */
        foreach ($data as $cat) {
            $categories[] = array('text'   => $cat->getName(),
                                  'parent' => $cat->getParent() ? $cat->getParent()->getId() : "#",
                                  'id'     => $cat->getId());
        }

        return new JsonResponse($categories);
    }

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/add",options={"expose"=true})
     */
    public function addAction(Request $request)
    {
        $form      = $this->createForm(new CategoryType(), null, array('compact' => false));
        $em        = $this->get('doctrine.orm.default_entity_manager');
        $APIHelper = $this->get('api_helper');

        if ($request->getMethod() == 'POST') {
            $APIHelper->addDataToFormName($request, 'blog_category');
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Category $category */
                $category = $form->getData();
                $em->persist($category);
                $em->flush($category);

                return new JsonResponse(array('id' => $category->getId()));
            }
        }

        return new JsonResponse();
    }


    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/rename/{id}",options={"expose"=true})
     */
    public function renameAction(Request $request, $id)
    {
        $APIHelper = $this->get('api_helper');
        $em        = $this->get('doctrine.orm.default_entity_manager');
        /** @var Category $category */
        $category = $em->getRepository('AppBundle:Category')->find($id);
        $form     = $this->createForm(new CategoryType(), $category, array('compact' => true));

        if ($request->getMethod() == 'POST') {
            $APIHelper->addDataToFormName($request, 'blog_category');
            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var Category $category */
                $category = $form->getData();
                $em->persist($category);
                $em->flush($category);

                return new JsonResponse();
            }
        }

        return new JsonResponse();
    }


    /**
     * @param Request $request
     * @Route("/edit/{id}",options={"expose"=true})
     * @Template()
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        /** @var Category $category */
        $category = $em->getRepository('AppBundle:Category')->find($id);
        $form     = $this->createForm(new CategoryType(), $category, array('compact' => true));

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $category = $form->getData();
                $em->persist($category);
                $em->flush($category);

                $this->addFlash('success', 'Updated successfully');

                return $this->redirectToRoute('app_backend_category_edit', array('id' => $category->getId()));
            }
        }

        return array('form' => $form->createView(), 'category' => $category);

    }


    /**
     *
     * @Route("/delete/{id}",options={"expose"=true})
     */
    public function deleteAction($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $category = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository("AppBundle:Category")
            ->find($id);

        if ($category) {
            $em->remove($category);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('app_backend_category_index'));
    }

}