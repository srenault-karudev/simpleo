<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-03-12
 * Time: 19:30
 */

namespace App\Repository;



use App\Entity\User;

class InvoiceRepository extends \Doctrine\ORM\EntityRepository
{
    public function getInvoices(User $user)
    {
        $qb = $this->createQueryBuilder('i')
            ->where('i.user = :user')
            ->setParameter('user', $user->getId())
            ->orderBy('i.date', 'asc');
        return $qb->getQuery()->getResult();
    }


}