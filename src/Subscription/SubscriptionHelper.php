<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-05-05
 * Time: 18:39
 */

namespace App\Subscription;


class SubscriptionHelper
{
    /** @var SubscriptionPlan[] */
    private $plans = [];
    public function __construct()
    {

        $this->plans[] = new SubscriptionPlan(
            'stripe_monthly',
            'simple',
            30
        );

        $this->plans[] = new SubscriptionPlan(
            'complete_monthly',
            'complete',
            50
        );

    }
    /**
     * @param $planId
     * @return SubscriptionPlan|null
     */
    public function findPlan($planId)
    {
        foreach ($this->plans as $plan) {
            if ($plan->getPlanId() == $planId) {
                return $plan;
            }
        }
    }
}