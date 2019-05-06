<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 2019-02-05
 * Time: 16:33
 */

namespace App\Form;


use App\Entity\Record;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\DateTime;

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
            ->add('tva', ChoiceType::class, array(
                'choices' => $choices,
                'expanded'=>true,
                'multiple'=>false
            ))
            ->add('tva_amount', NumberType::class)
            ->add('quantity', IntegerType::class)
            ->add('unit_amount', NumberType::class);
    }
}