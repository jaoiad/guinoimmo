<?php

namespace App\Form;

use App\Entity\Location;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('creat_at', null, array('attr' => array('style' => 'display:none;')),[
            'label' => false
            
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'titre'
            ])
            ->add('imageFile', FileType::class, [
              
            ])  
            ->add('denomination')
           
            ->add('surface')
            ->add('type_maison')
            ->add('chambres')
            ->add('etage')
            ->add('cout')
            ->add('adresse')
            ->add('accessibilite');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
