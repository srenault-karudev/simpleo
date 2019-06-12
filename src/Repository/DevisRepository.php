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
        if (empty($_GET['value'])) {
            $qb = $this->createQueryBuilder('p')
                ->where('p.user = :user')
                ->setParameter('user', $user->getId());
            return $qb->getQuery()->getResult();
        }
        else {
            $qb = $this->createQueryBuilder('p')
                ->where('p.reference like :value
                OR p.dateCreation like :value
                OR p.dateExpiration like :value
                OR p.client like :value
                OR p.telephone like :value
                OR p.etat like :value
                Or p. montant like :value
                ')
                ->andWhere('p.user = :user')
                ->setParameter('user', $user->getId())
                ->setParameter('value', '%' . $_GET['value'] . '%');
            return $qb->getQuery()->getResult();

        }
    }

}