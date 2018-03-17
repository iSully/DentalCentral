<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $this->get('user_service')->getUser();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'user' => $this->get('user_service')->getUser(),
            'roles' => $this->get('user_service')->getRolesAsArray()
        ]);
    }
}
