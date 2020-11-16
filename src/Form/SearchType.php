<?php
namespace App\Form;

use App\Data\SearchData;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add ('q', TextType::class,[
              'label'=> false,
              'required'=>false,
              'attr'=> [
                  'placeholder'=> 'Rechercher'
              ]
        ])

        ->add('minSurface', IntegerType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'placeholder' => 'min'
            ]


        ])
            ->add('maxSurface', IntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'max'
                ]
            ])

        ->add('categories', EntityType::class,[
            'label' => false,
            'required'=>false,
            'class'=>Categorie::class,
            'expanded'=>true,
            'multiple'=>true,
        ])
        
            -> add('min',NumberType::class, [
                'label' => false,
                'required'=> false,
                'attr' => [

                    'placeholder'=>'prix mini'
                ]
            ])

            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [

                    'placeholder' => 'prix max'
                ]

            ])
        ;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'data_class' => SearchData::class,
                'method'=>'Get',
                'csrf_protection'=> false

        ]);
    }


        public function getBlockPrefix()
        {
            return '';
        }
}