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

    public function getThisMonthSpending(User $user){
        $query="SELECT SUM(a.total_amount_ttc) as monthspending
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num LIKE '6%'
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND MONTH(i.paiment_date)=MONTH(DATE(NOW()))";

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


    public function getMarchandisesBuy(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as marchandisesBuy
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num =607
                OR r.num =6087
                OR r.num =6097)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getVariationsOfStock(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as variationsStockMarchandise
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num =6037
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }


    public function getSupplyBuy(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as supplybuy
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num = 601
                OR r.num = 602
                OR r.num = 6081
                OR r.num = 6091
                OR r.num =6092)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getStockVariation(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as variationsStockApprovisionnement
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num = 6031
                OR r.num = 6032)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getOtherExterneExpences(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as externeExpenses
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num = 604
                OR r.num =606
                OR r.num =605
                OR r.num =6084
                OR r.num =6085
                OR r.num =6086
                OR r.num =6094
                OR r.num =6095
                OR r.num =61
                OR r.num =62)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getTaxesVersementsAssimiles(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as taxesVersementsAssimiles
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num =63
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getSalariesExpenses(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as salariesExpenses
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num =641
                OR r.num =644
                OR r.num =648)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getSocialExpenses(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as socialExpenses
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num =645
                OR r.num =646
                OR r.num =647
                OR  r.num =648)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getDonationOfAmortissement(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as donationOfAmortissement
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num =6811
                OR r.num =6812)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getDonationOfDotation(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as donationOfDotation
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num =6816
                OR r.num =6817
                OR r.num =6815)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }


    public function getOthersCharges(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as othersCharges
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num =65
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }
    public function getFinanceExpences(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as financeExpences
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num =686
                OR r.num =661
                OR r.num =664
                OR r.num =665
                OR r.num = 668
                OR r.num=666
                OR r.num=667)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getImpotsOnBenef(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as impotsOnBenef
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num=695
                OR r.num=697
                OR r.num=689
                OR r.num=698
                OR r.num=699
                OR r.num=789)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getExceptionnelExpences(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as exceptionnelExpences
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num=671
                OR r.num=675
                OR r.num=678
                OR r.num=687)
                AND i.invoice_type = true
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getMarchandiseSale(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as saleMarch
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num=707
                OR r.num=7097)
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }


    public function getProdSale(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as exceptionnelExpences
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num=701000
                OR r.num=702
                OR r.num=703
                OR r.num=704
                OR r.num=705
                OR r.num=706
                OR r.num=707
                OR r.num=708
                OR r.num=709)
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getProdStock(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as prodstock
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num=713
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }



    public function getProdIm(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as prodim
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND (r.num=72
                OR r.num=73)
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }


    public function getSubExpl(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as subexpl
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num=74
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function getOtherProduct(User $user, $year){
        $query="SELECT SUM(a.total_amount_ht) as otherprod
                FROM Action AS a 
                JOIN Invoice AS i 
                JOIN record as r
                WHERE a.invoice_id = i.id
                AND a.record_id=r.id
                AND r.num=75
                AND i.invoice_type = false
                AND i.state_of_paiement = true
                AND i.user_id=".$user->getId()."
                AND YEAR(i.paiment_date)=".$year."
                ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }









}