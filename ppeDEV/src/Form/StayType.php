<?php

namespace App\Form;

use App\Entity\Stay;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entryDate', DateTimeType::class, [
                "label" => "date de sortie",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('leaveDate', TextType::class, [
                "label" => "date départ",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('creationDate', TextType::class, [
                "label" => "date création",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('idBed', TextType::class, [
                "label" => "Numéro du lit",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('idPatient', TextType::class, [
                "label" => "Numéro du patient",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stay::class,
        ]);
    }
}
