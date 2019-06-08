<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-02-05
 * Time: 16:33
 */

namespace App\Form;


use App\Entity\Invoice;
use App\Entity\Person;
use App\Entity\Record;
use App\Repository\InvoiceRepository;
use App\Repository\RecordRepository;
use Doctrine\ORM\Mapping\Entity;
use MongoDB\Driver\Manager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class Invoice_BuyType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $choix = [
            'oui' =>'oui',
            'non' => 'non',

        ];

        $builder



            ->add('record_id', EntityType::class, [
                'class' => Record::class,
                'choice_value' => 'Num',
                'expanded' => true,
                'multiple' => false,
                'query_builder' => function(RecordRepository $er){
                    return $er->getRecords(true);
                }

            ])

            ->add('person_id', EntityType::class, array(
                'class' => Person::class,
                'expanded' => true,
                'multiple' => false,
            ))

            ->add('imageFile', FileType::class,[
                'required' => false,
                'label' => 'Fichier'
            ])

            ->add('paid', ChoiceType::class, array(
                'choices' => $choix,
                'expanded' => true,
                'multiple' => false,
                'mapped' => false
            ))



            ->add('invoice_date', DateType::class, array(
                'required' => true,
                'widget' => 'single_text',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ));
    }
}