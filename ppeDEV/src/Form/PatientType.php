<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('firstName', TextType::class, [
                "label" => "Prénom ",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('socialSecurityNumber', TextType::class, [
                "label" => "Numéro de sécurité social",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('birthDate', DateType::class, [
                "label" => "Date de naissance",
                "attr" => [
                    "class" => "form-control"
                ],
                "widget" => "single_text"
            ])
            ->add('bloodType', ChoiceType::class, [
                "label" => "Groupe Sanguin",
                "required" => false,
                "attr" => [
                    "class" => "form-control"
                ],
                'placeholder' => 'Sélectionner un groupe sanguin',
                'choices' => [
                    'O' => 'O',
                    'A' => 'A',
                    'B' => 'B',
                    'AB' => 'AB'
                ]
            ])
            ->add("Sauvegarder", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
