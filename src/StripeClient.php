<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-05-01
 * Time: 17:51
 */

namespace App;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class StripeClient
{
    private $em;

    public function __construct($secretKey, EntityManagerInterface $em)
    {
        $this->em = $em;
        \Stripe\Stripe::setApiKey($secretKey);

    }

    public function createCustomer(User $user, $paymentToken)
    {
        $customer = \Stripe\Customer::create([

            "email" => $user->getEmail(),
            "source" => $paymentToken
        ]);

        $user->setStripeCustomerId($customer->id);
        $em = $this->em;
        $em->persist($user);
        $em->flush();

        return $customer;
    }

    public function updateCustomerCard(User $user, $paymentToken)
    {

        $customer = \Stripe\Customer::retrieve($user->getStripeCustomerId());
        $customer->source = $paymentToken;
        $customer->save();
    }

    public function CreateInvoiceItem($amount, User $user, $description)
    {

        \Stripe\InvoiceItem::create([
            'amount' => $amount,
            'currency' => 'eur',
            'description' => $description,
            "customer" => $user->getStripeCustomerId(),

        ]);
    }

    public function CreateInvoice(User $user, $payImmediately = true)
    {

        $invoice = \Stripe\Invoice::create(array(
            "customer" => $user->getStripeCustomerId()
        ));

        if ($payImmediately == true) {
            $invoice->pay();
        }
        return $invoice;
    }
}