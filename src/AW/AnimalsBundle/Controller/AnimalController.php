<?php

namespace AW\AnimalsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\Annotations\RouteResource;

use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

use FOS\RestBundle\Controller\Annotations\Delete;

class AnimalController extends FOSRestController
{

    public function indexAction()
    {
        return $this->render('AWAnimalsBundle:Animal:index.html.twig');
    }

    /**
     * HEAD Route annotation.
     * @Route("/animal/list", name="animals")
     * @Get("/animal/list")
     */
    public function listAnimalsAction()
    {

    	$repository = $this
	  		->getDoctrine()
	  		->getManager()
	  		->getRepository('AWAnimalsBundle:Animal');

	  	$animals = $repository->findAll();

        $view = $this->view($animals);
        return $this->handleView($view);
    }
}
