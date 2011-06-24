<?php

namespace Company\BlogBundle\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Security\Core\SecurityContext;

use Company\BlogBundle\Entity\Post as Post;
use Company\BlogBundle\Entity\Category;
use Company\BlogBundle\Entity\Tag;
use Company\BlogBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 
class PostController extends Controller
{
    public function indexAction()
    {
	$em = $this->get('doctrine.orm.entity_manager');
        $posts = $em->getRepository('Company\BlogBundle\Entity\Post')->findAll();
        return $this->render(
                'BlogBundle:Post:index.html.twig',
                array(
                    'posts' => $posts
                )
        );
    }

    public function addAction(){
	$post = new Post();
	$form = $this->createFormPost($post);
	return $this->render('BlogBundle:Post:edit.html.twig', array(
        	'form' => $form->createView(),
		'postId' => 0,
        ));
    }

    public function showAction($id = null)
    {
	if ( is_numeric($id)  ) {
		$em = $this->get('doctrine.orm.entity_manager');
        	$post = $em->getRepository("Company\BlogBundle\Entity\Post")->find($id);
		return $this->render('BlogBundle:Post:show.html.twig', array(
            		'post' => $post,
          	));
      	}
	else {
		return $this->indexAction();

	}
    } 

    public function editAction($id = null)
    {
	 if ( is_numeric($id)  ) {
                $em = $this->get('doctrine.orm.entity_manager');
                $post = $em->getRepository("Company\BlogBundle\Entity\Post")->find($id);
                $form = $this->createFormPost($post);
		return $this->render('BlogBundle:Post:edit.html.twig', array(
            		'form' => $form->createView(),
			'postId' => $id,
          	));
        }
        else {
                return $this->indexAction();
        }
    }


    public function createAction()
    {
	$em = $this->get('doctrine.orm.entity_manager');
	$post = new Post();
        // create the tags
        $tag1 = new Tag();
        $tag1->setName('lorem');
        $em->persist($tag1);
        $tag2 = new Tag();
        $tag2->setName('ipsum');
        $em->persist($tag2);
        $cat1 = new Category();
        $cat1->setName('Programming');
        $em->persist($cat1);
        $tags = array( $tag1, $tag2 );
        $post->setCategory($cat1);
        $post->getTags()->add($tags[rand(0, 1)]);
        $post->setUser( $this->get('security.context')->getToken()->getUser() );
	$form = $this->createFormPost($post);
	$request = $this->get('request');
        $form->bindRequest($request);
        $post = $form->getData();
	if ($form->isValid()) {
              	$em->persist($post);
                $em->flush();
		return $this->redirect($this->generateUrl('post_show', array('id' => $post->getId())));
        } 
	else {
		return $this->render('BlogBundle:Post:edit.html.twig', array(
                	'form' => $form->createView(),
             	));
	}
    }
	
    public function updateAction($id = null)
    {
	if ( is_numeric($id)  ) {	
	  	$em = $this->get('doctrine.orm.entity_manager');
          	$post = $em->getRepository("Company\BlogBundle\Entity\Post")->find($id);
	  	$form = $this->createFormPost($post);
 	  	$request = $this->get('request');
          	$form->bindRequest($request);
	  	$post = $form->getData();
	  	if ($form->isValid()) {
			$em->persist($post);
    			$em->flush();
			return $this->render('BlogBundle:Post:show.html.twig', array(
                        	'post' => $post,
                	));
	  	}else {
	          	return $this->render('BlogBundle:Post:edit.html.twig', array(
            			'form' => $form->createView(),
          		));
		}
	}
	else {
		return indexAction();
	}
   }

   public function deleteAction($id =null) {
	if ( is_numeric($id)  ) {
          	$em = $this->get('doctrine.orm.entity_manager');
		$post = $em->getRepository("Company\BlogBundle\Entity\Post")->find($id);
	   	$em->remove($post);
        	$em->flush();
		return $this->redirect($this->generateUrl('post_index'));
	}
	else {
		return indexAction();
	}
   }

   /* util-form */
   public function createFormPost($post =null) {
	return  $this->createFormBuilder($post)
                ->add('title', 'text')
                ->add('slug', 'text')
                ->add('content', 'textarea')
                ->getForm();	 
   }

}

