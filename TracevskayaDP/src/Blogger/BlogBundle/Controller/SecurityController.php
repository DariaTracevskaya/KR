<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 26.04.2017
 * Time: 17:56
 */

namespace Blogger\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller{
    public function loginAction(Request $request){
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $$request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(Security::AUTHENTICATION_ERROR);
        }

        return $this->render('BloggerBlogBundle:Security:login.html.twig', array(
            'last_username' => $request->getSession()->get(Security::LAST_USERNAME),
            'error' => $error
        ));
    }
}