<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-03-12
 * Time: 19:30
 */

namespace App\Repository;



use App\Entity\User;

class PersonRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCustomers(User $user)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.user = :user')
           ->setParameter('user', $user->getId())
            ->andwhere('p.personType = :type')
            ->setParameter('type', 'customer')
            ->orderBy('p.lastname', 'asc');
        return $qb->getQuery()->getResult();
    }


}