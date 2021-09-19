<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du livre',
                'invalid_message' => 'Cet ouvrage est déjà enregistré',
                'required' => true,
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 50
                ]),
                'attr' => [
                    'placeholder' => 'Saisissez le titre du livre'
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur du livre',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Saisissez le nom et prénom de l\'auteur'
                ]
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de puration du livre',
                'required' => true,
                'years' => range(date('Y'), date('Y')-200),
                'format' => 'dd-MM-yyyy'
            ])
            ->add('summary', TextType::class, [
                'label' => 'Sommaire du livre',
                'required' => true,
                'attr' => [
                    'placeholder' => 'le sommaire...'
                ]
            ])
            ->add('isbn13', NumberType::class, [
                'label' => 'Numéro ISBN',
                'invalid_message' => 'Ce format n\'est pas valide',
                'required' => true,
                'scale' => 3,
                'attr' => [
                    'placeholder' => 'Inscrire l\'identifiant ISBN'
                ]
            ])
            ->add('url',TextType::class, [
                'label' => 'URL',
                'required' => true,
                'attr' => [
                    'placeholder' => 'l\'url...'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
