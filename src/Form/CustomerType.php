<?php
/**
 * Created by PhpStorm.
 * User: lahmar
 * Date: 01/02/19
 * Time: 16:04
 */

namespace App\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class CustomerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       // parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder
            ->add('personType', ChoiceType::class, array(
                'choices' => [
                    'Particulier' => 'particulier',
                    'Entreprise' => 'entreprise',
                    ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['onclick' => 'Afficher("leschamps")'],
            ))
            ->add('lastname', TextType::class, array(
                'required' => false))
            ->add('firstname', TextType::class, array(
                'required' => false))
            ->add('companyname', TextType::class, array(
                'required' => false))
            ->add('adress', TextType::class, array(
                'required' => false))
            ->add('postcode', NumberType::class, array(
                'required' => false))
            ->add('email', EmailType::class, array(
                'required' => false))
            ->add('mobilephone', TelType::class, array(
                'required' => false))
            ->add('country', TextType::class, array(
                'required' => false))
            ->add('siren', TextType::class, array(
                'constraints' => [new Length(['max' => 9])],
                'required' => false))
            ->add('siret', TextType::class, array(
                'constraints' => [new Length(['max' => 14])],
                'required' => false))
            ->add('numtva', TextType::class, array(
                'required' => false));

    }
}