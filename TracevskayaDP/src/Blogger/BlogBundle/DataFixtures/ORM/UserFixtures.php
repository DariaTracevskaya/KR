<?php

/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 26.04.2017
 * Time: 17:29
 */
namespace Blogger\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blogger\BlogBundle\Entity\Role;
use Blogger\BlogBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class UserFixtures implements FixtureInterface{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $role = new Role();
        $role->setName('ROLE_ADMIN');
        $role->setTitle('Администратор');

        $manager->persist($role);

        $role2 = new Role();
        $role2->setName('ROLE_MANAGER');
        $role2->setTitle('Менеджер');

        $manager->persist($role2);

        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setUsername('admin');
        $user->setSalt(md5(time()));

        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword('admin', $user->getSalt());
        $user->setPassword($password);

        $user->getUserRoles()->add($role);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('manager@example.com');
        $user2->setUsername('manager');
        $user2->setSalt(md5(time()));

        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword('manager', $user2->getSalt());
        $user2->setPassword($password);

        $user2->getUserRoles()->add($role2);

        $manager->persist($user2);

        $manager->flush();
    }
}