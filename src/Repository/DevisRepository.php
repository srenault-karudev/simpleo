<?php
/**
 * Created by PhpStorm.
 * User: adrienparaiso
 * Date: 06/05/2019
 * Time: 17:20
 */

namespace App\Repository;

use App\Entity\User;

class DevisRepository extends \Doctrine\ORM\EntityRepository
{
    public function getDevis(User $user)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.user = :user')
            ->setParameter('user', $user->getId());
        return $qb->getQuery()->getResult();
    }
}