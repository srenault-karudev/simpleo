<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-03-12
 * Time: 19:30
 */
namespace App\Repository;



use App\Entity\User;

class ActionRepository extends \Doctrine\ORM\EntityRepository
{


    public function getMonthTurnover(User $user){
        $query="SELECT SUM(a.total_amount_ttc) as turnoverOfThisMonth
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num LIKE '7%'
                AND i.invoice_type = false
                 AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND MONTH(i.paiment_date)=MONTH(DATE(NOW()))
                AND YEAR(i.paiment_date)=YEAR(DATE(NOW()))";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }


    public function getYearTurnover(User $user){
        $query="SELECT SUM(a.total_amount_ttc) as turnoverOfThisYear
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num LIKE '7%'
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=YEAR(DATE(NOW()))";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getWaitInvoices(User $user){
        $query="SELECT COUNT(i.id) as waitinvoices, SUM(i.tt_price) as ttcprice
                FROM Invoice AS i 
                WHERE i.invoice_type = false
                AND i.user_id=".$user->getId()."
                AND i.state_of_paiement= false";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getInvoicesToPay(User $user){
        $query="SELECT COUNT(i.id) as invoicestopay, SUM(i.tt_price) as ttcprice
                FROM Invoice AS i 
                WHERE i.invoice_type = true
                AND i.user_id=".$user->getId()."
                AND i.state_of_paiement= false";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }


    public function  getLastMonthTurnover(User $user){
        $query="SELECT SUM(a.total_amount_ttc) as lastmonthturnover
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num LIKE '7%'
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND MONTH(i.paiment_date)=MONTH(DATE_ADD(NOW(), INTERVAL -1 MONTH))";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function  getLastMonthSpending(User $user){
        $query="SELECT SUM(a.total_amount_ttc) as lastmonthspending
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num LIKE '6%'
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND MONTH(i.paiment_date)=MONTH(DATE_ADD(NOW(), INTERVAL -1 MONTH))";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }



    public function  getAllMonthTurnoverOfThisYear(User $user, $i){
        $query="SELECT SUM(a.total_amount_ttc) as turnover
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num LIKE '7%'
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND MONTH(i.paiment_date)=$i
                AND YEAR(i.paiment_date)=YEAR(DATE(NOW()))";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }









}