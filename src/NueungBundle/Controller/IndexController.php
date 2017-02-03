<?php

namespace NueungBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use NueungBundle\Services\IndexManager;


class IndexController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function indexAction(Request $request)
    {

        $currentUser = $this->getUser(); // current User


        $serviceIndex = new IndexManager($currentUser->getUserName()); //service of Index

        return $this->render('NueungBundle:Index:index.html.twig', array(
                "username" => $currentUser->getUserName() . " connected")
        );
    }
}
