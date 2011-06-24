<?php

namespace Company\BlogBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 
class BlogController extends Controller
{
    public function indexAction()
    {
        //return $this->render('BlogBundle:Blog:index.html.twig');
	$em = $this->get('doctrine.orm.entity_manager');
    	$posts = $em->getRepository('Company\BlogBundle\Entity\Post')->getLatestPosts();
 
    	return $this->render(
		'BlogBundle:Blog:index.html.twig',
		array(
		    'posts' => $posts
		)
    	);
    }
}
