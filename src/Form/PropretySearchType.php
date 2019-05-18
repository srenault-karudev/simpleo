<?php

namespace App\Form;

use App\Entity\PropertySearch;
use Doctrine\DBAL\Types\StringType;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class   PropretySearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value',TextType::class,[
                'required' => false,
                'label' => false,
                'attr'=> [
                    'placeholder'=> 'recherche'
                ]
            ]);



     }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method'=> 'get' ,
            'csrf_protection'=>false,

        ]);

    }

    public function getBlockPrefix()
    {
        return '';
    }


}