<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        return $this->render('::base.html.twig', ['categories' => $categories, 'user'=>$user]
        );
    }

}
