<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.05.2017
 * Time: 12:22
 */

namespace Blogger\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManagerController extends Controller
{
    public function indexAction(){
        return $this->render('BloggerBlogBundle:Manager:index.html.twig');
    }
}