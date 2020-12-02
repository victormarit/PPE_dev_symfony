<?php

namespace App\Form;

use App\Entity\Staff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                "label" => "Login",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('password', PasswordType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                'label'=>'Mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Votre mot de passe devrait faire {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstName', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                'label'=>'Prénom'
            ])
            ->add('lastName', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                'label'=>'Nom'
            ])
        
            ->add('roles', ChoiceType::class, [
                "label" => 'Rôle',
                'choices'  => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add("Sauvegarder", SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}
