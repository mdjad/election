<?php

namespace App\Form;

use App\Entity\Electeur;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ElecteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom' ,TextType::class )
            ->add('prenom',TextType::class)
            ->add('date_naissance',DateType::class, array(
                'widget'=> 'single_text',
                'label' => "Date de naissance"
            ))
            ->add('telephone',NumberType::class)
            ->add('email',EmailType::class)
            ->add('num_carte',NumberType::class, array('label' => "Numero de la carte d'identité"))
            ->add('cniFile', VichImageType::class, array(
                'attr' => array('class'=>'form-control-file'),
                'label' => "Carte d'identité",
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Electeur::class,
        ]);
    }
}
