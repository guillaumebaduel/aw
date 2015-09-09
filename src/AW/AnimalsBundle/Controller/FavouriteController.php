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

class FavouriteController extends FOSRestController
{
    public function indexAction()
    {
        return $this->render('AWAnimalsBundle:Favourite:index.html.twig');
    }

    /**
     * HEAD Route annotation.
     * @Route("/favourite/list", name="favourites")
     * @Get("/favourite/list")
     */
    public function listFavouritesAction()
    {
    	$repository = $this
	  		->getDoctrine()
	  		->getManager()
	  		->getRepository('AWAnimalsBundle:Favourite');

	  	$favourites = $repository->findAll();

        $view = $this->view($favourites);
        return $this->handleView($view);
    }

    private function processForm(Request $request, Favourite $favourite)
    {
      

        $form = $this->createForm(new FavouriteType(), $Favourite);
        $form->bind($request);

        if ($form->isValid()) {


                $submission = $form->getData();

                $name = $request->request->get('name');

             


                $submission->setName($name);
          

                $em = $this->getDoctrine()->getManager();
                $em->persist($submission);
                $em->flush();

                $response = new Response();
                $response->setContent(json_encode(array(
                    'form' => 'success',
                )));
                $response->headers->set('Content-Type', 'application/json');
       



                return $response;
        }

        $response = new Response();
        $response->setContent(json_encode(array(
            'form' => 'error',
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    

    /**
     * Lists all User entities.
     *
     * @Route("/favourite/add", name="favourites")
     * @Post("/favourite/add")
     */
    public function addAction(Request $request)
    {

        return $this->processForm($request, new Favourite());
    }

    /**
     * DELETE Route annotation.
      * @Delete("/favourite/delete/{Id}", name="favourites")
     */
    public function deleteAction(Request $id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $favourite= $em->getRepository('AWAnimalsBundle:Favourite')->find($id);

        if (!$category) {
	        $response = new Response();
	        $response->setContent(json_encode(array(
	            'delete' => 'error',
	        )));
	        $response->headers->set('Content-Type', 'application/json');
	        return $response;
        }

        
        $em->remove($favourite);
        $em->flush();

        $response = new Response();
        $response->setContent(json_encode(array(
            'delete' => 'ok',
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
