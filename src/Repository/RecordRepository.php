<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-03-12
 * Time: 19:30
 */

namespace App\Repository;



class RecordRepository extends \Doctrine\ORM\EntityRepository
{
    public function getRecords($val)
    {
        if ($val == 0) {
            return $qb = $this->createQueryBuilder('r')
                ->where('r.Num like :firstValue')
                ->orWhere('r.Num like :secondValue')
                ->setParameter('firstValue', '6%')
                ->setParameter('secondValue', '7%');
        }elseif ($val==1){
            return $qb = $this->createQueryBuilder('r')
                ->where('r.Num like :firstValue')
                ->setParameter('firstValue', '7%');
        }
        else{

            return $qb = $this->createQueryBuilder('r')
                ->where('r.Num = 512')
                ->orWhere('r.Num = 53')
                ->orWhere('r.Num = 455');

//                ->setParameter('banque', '512');

        }


    }

    public function getRecord($num){

        $qb = $this->createQueryBuilder('r')
            ->where('r.Num = :num')
            ->setParameter('num', $num);

        return $qb->getQuery()->getResult();
    }
}