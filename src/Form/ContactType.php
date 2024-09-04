<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'placeholder' => 'Veuillez saisir votre nom'
            ]
        ])

        ->add('firstname', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'placeholder' => 'Veuillez saisir votre prénom'
            ]
        ])

        ->add('email', EmailType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'placeholder' => 'Veuillez saisir votre email de contact'
            ]
        ])

        ->add('phone', TelType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'placeholder' => 'Veuillez saisir votre numéro de téléphone (facultatif)'
            ]
        ])

        ->add('message', TextareaType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'style' => 'height:10rem;',
                'placeholder' => 'Veuillez saisir votre demande'
            ]
        ])

        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => [
                'class' => 'd-grid gap-2 col-6 mx-auto btn rounded-4 mt-4',
                'style' => 'background-color: #7200b8; color: white',
            ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
