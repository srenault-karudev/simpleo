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


    public function getInvoices(User $user,$type)
    {
        $qb = $this->createQueryBuilder('i')
            ->where('i.user = :user')
            ->andWhere('i.invoice_type = :type')
            ->setParameter('user', $user->getId())
            ->setParameter('type',$type)
            ->orderBy('i.date', 'asc');
        return $qb->getQuery()->getResult();
    }
}