<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Firstname', TextType::class, [
                'label' => "Enter your first name",
                'label_attr' => ['class' => 'mt-5'],
            ])
            ->add('Lastname', TextType::class, [
                'label' => "Enter your last name"
            ])
            ->add('Username', TextType::class, [
                'label' => "Choose a username"
            ])
            ->add('Email', EmailType::class, [
                'label' => "Enter your email"
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Choose a password'],
                'second_options' => ['label' => 'Confirm your password'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Sign Up",
                'attr' => ['class' => 'btn-color mt-4'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
