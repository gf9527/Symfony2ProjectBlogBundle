<?php

namespace Company\BlogBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 
class PagesController extends Controller
{
    public function showAction($page)
    {
        return $this->render(
            sprintf( 'BlogBundle:Pages:%s.html.twig', $page )
        );
    }
}

?>
