<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SystemRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Route controller.
 *
 * @Route("manage/route")
 */
class RouteController extends Controller
{
    /**
     * Lists all route entities.
     *
     * @Route("/", name="system_route_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $routes = $em->getRepository('AppBundle:SystemRoute')->findAll();

        return $this->render('route/index.html.twig', array(
            'routes' => $routes,
        ));
    }

    /**
     * Creates a new route entity.
     *
     * @Route("/new", name="system_route_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $route = new SystemRoute;
        $form = $this->createForm('AppBundle\Form\RouteType', $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($route);
            $em->flush($route);

            return $this->redirectToRoute('system_route_show', array('id' => $route->getId()));
        }

        return $this->render('route/new.html.twig', array(
            'route' => $route,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a route entity.
     *
     * @Route("/{id}", name="system_route_show")
     * @Method("GET")
     */
    public function showAction(SystemRoute $route)
    {
        $deleteForm = $this->createDeleteForm($route);

        return $this->render('route/show.html.twig', array(
            'route' => $route,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing route entity.
     *
     * @Route("/{id}/edit", name="system_route_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SystemRoute $route)
    {
        $deleteForm = $this->createDeleteForm($route);
        $editForm = $this->createForm('AppBundle\Form\RouteType', $route);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('system_route_edit', array('id' => $route->getId()));
        }

        return $this->render('route/edit.html.twig', array(
            'route' => $route,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a route entity.
     *
     * @Route("/{id}", name="system_route_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SystemRoute $route)
    {
        $form = $this->createDeleteForm($route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($route);
            $em->flush($route);
        }

        return $this->redirectToRoute('system_route_index');
    }

    /**
     * Creates a form to delete a route entity.
     *
     * @param Route $route The route entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SystemRoute $route)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('system_route_delete', array('id' => $route->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
