<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProuitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('description')
            ->add('prix')
            ->add('qstock')
            ->add('poids')
            ->add('dimentions')
            ->add('image',FileType::class, array('data_class' => null,'required' => false))
            ->add('categorie')
            ->add('text')
           /* ->add('categorie')*/
            ->add('enAvant')
            ->add('enSolde')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
