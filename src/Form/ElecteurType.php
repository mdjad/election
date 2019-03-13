<?php

namespace App\Form;

use App\Entity\Electeur;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
                'label' => "Date de naissance",
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker'],
                'html5' => false,
            ))
            ->add('telephone',TelType::class)
            ->add('email',EmailType::class)
            ->add('num_carte',NumberType::class, array('label' => "Numero de la carte d'identité"))
            ->add('cniFile', VichImageType::class, array(
                'attr' => array('class'=>'form-control-file'),
                'label' => "Carte d'identité",
                'required' => false,
            ))
            ->add('captcha', RecaptchaType::class, array(
                'constraints' => new Recaptcha2(),
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
