<?php
// src/Blogger/BlogBundle/Controller/BlogController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
* Blog controller.
*/
class BlogController extends Controller
{
    /**
    * @Route("/{id}", name="show",
     *     requirements={
     *          "methods": "GET",
     *          "id": "\d+"
     *     }
     *     )
    */
    public function showAction($id)
    {
    $em = $this->getDoctrine()->getManager();

    $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

    if (!$blog) {
        throw $this->createNotFoundException('Unable to find Blog post.');
    }

    $comments = $em->getRepository('BloggerBlogBundle:Comment')
        ->getCommentsForBlog($blog->getId());

    return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
        'blog'      => $blog,
        'comments'  => $comments
    ));
    }
}

