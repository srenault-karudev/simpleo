<?php
/**
 * Created by PhpStorm.
 * User: lahmar
 * Date: 01/02/19
 * Time: 16:04
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       // parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('adress', TextType::class)
            ->add('email', EmailType::class)
            ->add('mobilephone', NumberType::class);
    }
}