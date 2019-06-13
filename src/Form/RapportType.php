<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Entity\Record;
use App\Repository\RecordRepository;
use Doctrine\DBAL\Types\StringType;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class   RapportType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = [
            'Année' => '0',
            'Mois' => '1'

        ];

        $builder
            ->add('choix', ChoiceType::class, array(
                'choices' => $choices,
                'expanded' => false,
                'multiple' => false,
            ))

            ->add('month', \Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                    'required'   => false,
            ])

            ->add('year', \Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'required'   => false,
            ]);


    }


}