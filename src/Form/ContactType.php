<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

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
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nom est obligatoire',
                ]),
            ],
        ])

        ->add('firstname', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'placeholder' => 'Veuillez saisir votre prénom'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le prénom est obligatoire',
                ]),
            ],
        ])

        ->add('email', EmailType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'placeholder' => 'Veuillez saisir votre email de contact'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'L\'email est obligatoire',
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'message' => 'Veuillez entrer une adresse email valide',
                ]),
            ],
        ])

        ->add('phone', TelType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'placeholder' => 'Veuillez saisir votre numéro de téléphone (facultatif)'
            ]
        ])

        ->add('subject', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'placeholder' => 'Veuillez saisir le sujet',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le sujet est obligatoire',
                ]),
            ],
        ])

        ->add('message', TextareaType::class, [
            'label' => false,
            'attr' => [
                'class' => 'rounded-4 mt-4',
                'style' => 'height:10rem;',
                'placeholder' => 'Veuillez saisir votre demande'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le message est obligatoire',
                ]),
            ],
        ])

        ->add('honeypot', HiddenType::class, [
            'mapped' => false,
            'required' => false,
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
