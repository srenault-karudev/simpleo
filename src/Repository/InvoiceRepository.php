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
        if (empty($_GET['value'])) {

            $qb = $this->createQueryBuilder('i')
                ->where('i.user = :user')
                ->andWhere('i.invoice_type = :type')
                ->setParameter('user', $user->getId())
                ->setParameter('type', $type)
                ->orderBy('i.date', 'DESC');
            return $qb->getQuery()->getResult();
        }
        else {
            $qb = $this->createQueryBuilder('i')
                ->leftJoin('App:Person','p','with','p.id=i.client')
                ->where('i.date like :value 
                OR i.id like :value
                OR p.lastname like :value
                OR p.firstname like :value
                OR p.companyname like :value
                OR i.identifiant like :value
                OR i.price_Ht like :value 
                OR i.price_tt like :value 
                OR i.paiment_date like :value 
                OR i.entryDate like :value
                 ')
                ->andWhere('i.user = :user')
                ->andWhere('i.invoice_type = :type')
                ->setParameter('user', $user->getId())
                ->setParameter('type', $type)
                ->orderBy('i.date', 'DESC')
                ->setParameter('value', '%' . $_GET['value'] . '%');
            return $qb->getQuery()->getResult();
        }
    }

//    public function getInvoicesSales(User $user)
//    {
//        $qb = $this->createQueryBuilder('i')
//            ->where('i.user = :user')
//            ->setParameter('user', $user->getId())
//            ->andWhere('i.invoice_type = false')
//            ->orderBy('i.date', 'asc');
//        return $qb->getQuery()->getResult();
//    }
}