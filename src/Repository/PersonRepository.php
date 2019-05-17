<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-03-12
 * Time: 19:30
 */

namespace App\Repository;


use App\Entity\Person;
use App\Entity\User;

class PersonRepository extends \Doctrine\ORM\EntityRepository
{

    public function GetCustomers()
    {

        if( empty($_GET['value']) )
        {
            $qb = $this->createQueryBuilder('p')
                ->orderBy('p.lastname', 'desc');
            return $qb->getQuery()->getResult();
        }
        else
        {
            $qb = $this->createQueryBuilder('p')
                ->where('p.adress like :value OR p.lastname like :value or p.firstname like :value or p.mobilephone like :value or p.email like :value ')
                ->setParameter('value', '%'.$_GET['value'].'%');
            return $qb->getQuery()->getResult();
        }
    }

}