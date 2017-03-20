<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Matches /blog exactly
     *
     * @param $request
     *
     * @Route("/blog", name="blog_list")
     */
    public function listAction(Request $request)
    {
        return $this->returnResponse($request);
    }

    /**
     * Matches /blog/*
     *
     * @param Request $request
     * @param string $slug
     *
     * @Route("/blog/{slug}", name="blog_show")
     */
    public function showAction(Request $request)
    {
        return $this->returnResponse($request);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    protected function returnResponse(Request $request)
    {
        return new Response(sprintf('<html><body>Matched route: <b>%s</b></body></html>', $request->get('_route')));
    }
}
