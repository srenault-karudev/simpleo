<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-04-14
 * Time: 17:25
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class HomePageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder
            ->add('trialEmail', EmailType::class,array(
                'required' => false,
            ));
    }
}