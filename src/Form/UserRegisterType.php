<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Length(['min' => 3, 'minMessage' => 'Le nom doit contenir 3 caractères minimum']),
                    new NotBlank(['message' => 'Ne peut être vide']),
                    new NotNull(['message' => 'Ne peut être null']),
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new Length(['min' => 3, 'minMessage' => 'Le prénom doit contenir 3 caractères minimum']),
                    new NotBlank(['message' => 'Ne peut être vide']),
                    new NotNull(['message' => 'Ne peut être null']),
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'constraints' => [
                    new Length(['min' => 8, 'minMessage' => 'Le mot de passe doit contenir 8 caractères minimum']),
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('cgu', CheckboxType::class, [
                'label' => 'CGU',
                'mapped' =>false,
                'constraints' => [
                    new IsTrue(['message' => "Vous devez accepter les conditions"])
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer',
                'attr' => ['class' => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
