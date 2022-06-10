<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categories = [
            'Thriller'          => 'Thriller',
            'Comédie'           => 'Comédie',
            'SF'                => 'SF',
            'Drame'             => 'Drame',
            'Animation'         => 'Animation',
            'Horreur'           => 'Horreur',
            'Romance'           => 'Romance',
            'Aventure'          => 'Aventure',
            'Action'            => 'Action',
            'Fantastique'       => 'Fantastique',
            'Documentaire'      => 'Documentaire',
        ];

        $genders = [
            'Homme' => 'Homme',
            'Femme' => 'Femme',
            'Autre' => 'Autre',
            'Ne pas renseigner' => 'Ne pas renseigner'
        ];
        
        $builder
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom'
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Votre prénom doit comporter au minimum {{ limit }} caractères',
                        'max' => 60,
                        'maxMessage' => 'Votre prénom doit comporter au minimum {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom'
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Votre nom doit comporter au minimum {{ limit }} caractères',
                        'max' => 60,
                        'maxMessage' => 'Votre nom doit comporter au minimum {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre pseudo'
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Votre pseudo doit comporter au minimum {{ limit }} caractères',
                        'max' => 60,
                        'maxMessage' => 'Votre pseudo doit comporter au maximum {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un email valide'
                    ])
                ]
            ])
            ->add('plainPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'required' => true,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => $genders,
            ])
            ->add('birthday', DateType::class,  [
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'constraints' => [
                    new NotBlank(['message' => 'The birthdate is missing']),
                    new LessThanOrEqual([
                        'value' => (new \DateTime('now'))->modify('-13 years'),
                        'message' => 'Âge minimum: 13 ans',
                    ])
                ]
            ])
            ->add('profile_picture', FileType::class, [
                'required' => false,
            ])
            ->add('preferences', ChoiceType::class,[
                'choices' => $categories,
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
