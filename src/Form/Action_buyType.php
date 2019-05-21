<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-02-05
 * Time: 16:33
 */

namespace App\Form;


use App\Entity\Record;
use App\Repository\InvoiceRepository;
use App\Repository\RecordRepository;
use Doctrine\ORM\Mapping\Entity;
use MongoDB\Driver\Manager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

class Action_buyType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $choices = [
            '0' => 0,
            '2.10' => 2.10,
            '5.5' => 5.5,
            '10' => 10,
            '20' => 20
        ];



        $builder
            ->add('record_id', EntityType::class, [
                'class' => Record::class,
                'choice_value' => 'Num',
                'expanded' => false,
                'multiple' => false,
                'query_builder' => function(RecordRepository $er){
                return $er->getRecords();
                 }

            ])
            ->add('tva', ChoiceType::class, array(
                'choices' => $choices,
                'expanded' => true,
                'multiple' => false
            ))
            ->add('tva_amount', NumberType::class, array(
                'attr'=>array(
                    'min'=>'0',
                    'required'=>false
                )
            ))
            ->add('quantity', IntegerType::class, array(
                'attr' => array(
                    'min' => '0',

                )

            ))
            ->add('unit_amount', NumberType::class, array(
                'attr' => array(
                    'required'=>false,
                    'min' => '0'
                )
            ));
    }
}