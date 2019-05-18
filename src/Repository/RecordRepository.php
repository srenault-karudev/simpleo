<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-03-12
 * Time: 19:30
 */

namespace App\Repository;


use App\Entity\User;

class RecordRepository extends \Doctrine\ORM\EntityRepository
{
    public function getRecords()
    {


        if (empty($_GET['value'])) {
            return  $qb = $this->createQueryBuilder('r')
                ->where('r.Num like :firstValue')
                ->orWhere('r.Num like :secondValue')
                ->setParameter('firstValue','6%')
                ->setParameter('secondValue','7%');

        }else{
            return  $qb = $this->createQueryBuilder('r')
                ->where('r.Num like :firstValue')
                ->orWhere('r.Num like :secondValue')
                ->andWhere('r.Num like :value
                  OR r.Format like :value
                  OR r.Nom like :value')
                ->setParameter('firstValue','6%')
                ->setParameter('secondValue','7%')
                ->setParameter('value', '%' . $_GET['value'] . '%');
        }

    }
}