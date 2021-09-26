<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'constraints' => [
                    new Length(['min' => 3, 'minMessage' => 'Le nom doit contenir 3 caractères minimum']),
                    new NotBlank(['message' => 'Ne peut être vide']),
                    new NotNull(['message' => 'Ne peut être null']),
                    ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('imgMiniature', FileType::class, [
                'label' => 'Image miniature',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('isOnline', CheckboxType::class, [
                'required' => false,
                'label' => 'Je ne veux pas mettre en vente ce produit pour le moment',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Length(['min' => 3, 'minMessage' => 'La description doit contenir 3 caractères minimum']),
                    new NotBlank(['message' => 'Ne peut être vide']),
                    new NotNull(['message' => 'Ne peut être null'])
                ]

            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix (en cents)',
                'attr' => [
                    'class' => 'form-control'
                ],
                'help' => 'The ZIP/Postal code for your credit card\'s billing address.',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter le produit',
                'attr' => ['class' => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

    /*
        * ->add('img1',FileType::class, [
           'required' => false,
           'label' => 'Ajouter une image',
           'attr' => [
               'class' => 'form-control'
           ]
       ])
       ->add('img2', FileType::class, [
           'required' => false,
           'label' => 'Ajouter une image',
           'attr' => [
               'class' => 'form-control'
           ]
       ])
       ->add('img3', FileType::class, [
           'required' => false,
           'label' => 'Ajouter une image',
           'attr' => [
               'class' => 'form-control'
           ]
       ])
        */
}
