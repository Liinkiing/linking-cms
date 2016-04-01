<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Page;
use AppBundle\Entity\Post;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;

/**
 * @Route("/admin", name="admin_index")
 */
class AdminController extends Controller
{

    /**
     * @Route("/", name="admin_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request){
        return $this->render('admin/index.html.twig', ['test']);


    }


    /**
     * @Route("/post/", name="blog_list_posts")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listPostAction(Request $request){
        $em = $this->getDoctrine()->getRepository(Post::class);
        $posts = $em->findAll('DESC');
        return $this->render('admin/blog_list_posts.html.twig', ['posts' => $posts]);


    }



}
