<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Form\UserType;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class PageController extends Controller
{
    public function indexAction(Request $request)
    {

   // public function regAction(){
        $message = "";
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $role = $em->getRepository("BloggerBlogBundle:Role")->getRole2("ROLE_MANAGER")[0];
                $user->addUserRole($role);
                $user->setSalt(md5(time()));

                $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);

                $em->persist($user);
                $em->flush();
                $message = "Пользователь зарегистрирован";
            }else{
                $message = "Некорректный ввод";
            }

        }

        return $this->render("@BloggerBlog/Page/index.html.twig", array(
            "form" => $form->createView(), "message" => $message
        ));
    }
}