<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-05-05
 * Time: 18:42
 */

namespace App\Subscription;


class SubscriptionPlan
{
    private $planId;

    private $name;

    private $price;

    public function __construct($planId, $name, $price)
    {
        $this->planId = $planId;
        $this->name = $name;
        $this->price = $price;
    }
    public function getPlanId()
    {
        return $this->planId;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
    }
}