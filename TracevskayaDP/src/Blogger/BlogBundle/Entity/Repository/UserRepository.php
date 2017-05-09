<?php

namespace Blogger\BlogBundle\Entity\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository{
    public function getAll(){
        $qb = $this->createQueryBuilder('u')
            ->select('u');

        return $qb->getQuery()->getResult();
    }

    public function getUserOnLogin($login){
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.username = :u_login')
            ->setParameter('u_login', $login);

        return $qb->getQuery()->getResult();
    }

    public function getUserOnEmail($email){
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.email = :u_email')
            ->setParameter('u_email', $email);

        return $qb->getQuery()->getResult();
    }

    public function deleteUser($id){

        $qb = $this->createQueryBuilder('BloggerBlogBundle:User', 'u')
            ->delete('BloggerBlogBundle:User', 'u')
            ->where('u.id = :u_id')
            ->setParameter('u_id', $id);

        return $qb->getQuery()->getResult();
    }
}