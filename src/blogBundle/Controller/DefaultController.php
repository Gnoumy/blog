<?php

namespace blogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$this->get('doctrine.orm.entity_manager')->getRepository('blogBundle:Post');
        return $this->render('blogBundle:Default:index.html.twig');
    }
}
