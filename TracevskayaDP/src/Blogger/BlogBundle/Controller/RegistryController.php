<?php

namespace Blogger\BlogBundle\Controller;


use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class RegistryController extends Controller
{
    public function indexAction()
    {
        return $this->render('BloggerBlogBundle:Registry:registry.html.twig');
    }
    public function regAction(Request $request){

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $role = $em->getRepository("BloggerBlogBundle:Role")->getRole("ROLE_MANAGER")[0];
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
            "form" => $form->createView()
        ));
    }
}