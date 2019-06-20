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
                AND r.num=607000
                AND r.num=6087000
                AND r.num=6097000
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
                AND r.num=603700
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
                AND r.num=601000
                AND r.num=602000
                AND r.num=608100
                AND r.num=609100
                AND r.num=609200
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
                AND r.num=603100
                AND r.num=603200
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
                AND r.num=604000
                AND r.num=606000
                AND r.num=605000
                AND r.num=608400
                AND r.num=608500
                AND r.num=608600
                AND r.num=609400
                AND r.num=609500
                AND r.num=610000
                AND r.num=620000
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
                AND r.num=630000
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
                AND r.num=641000
                AND r.num=644000
                AND r.num=648000
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
                AND r.num=645000
                AND r.num=646000
                AND r.num=647000
                AND r.num=648000
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
                AND r.num=681100
                AND r.num=681200
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
                AND r.num=681600
                AND r.num=681700
                AND r.num=681500
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
                AND r.num=650000
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
                AND r.num=686000
                AND r.num=661000
                AND r.num=664000
                AND r.num=665000
                AND r.num=668000
                AND r.num=666000
                AND r.num=667000
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
                AND r.num=695000
                AND r.num=697000
                AND r.num=689000
                AND r.num=698000
                AND r.num=699000
                AND r.num=789000
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
                AND r.num=671000
                AND r.num=675000
                AND r.num=678000
                AND r.num=687000
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
                AND r.num=707000
                AND r.num=709700
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
                AND r.num=701000
                AND r.num=702000
                AND r.num=703000
                AND r.num=704000
                AND r.num=705000
                AND r.num=706000
                AND r.num=707000
                AND r.num=708000
                AND r.num=709000
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
                AND r.num=713000
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
                AND r.num=720000
                AND r.num=730000
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
                AND r.num=740000
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
                AND r.num=750000
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