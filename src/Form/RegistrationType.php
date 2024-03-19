<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Gallery;
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
            'label' => "Renseignez votre prénom"
        ])
        ->add('Lastname', TextType::class, [
            'label' => "Renseignez votre nom"
        ])
        ->add('Username', TextType::class, [
            'label' => "Choisissez un nom d'utilisateur"
        ])
        ->add('Email', EmailType::class, [
            'label' => "Renseignez votre email"
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => ['label' => 'Choisissez un mot de passe'],
            'second_options' => ['label' => 'Confirmez le mot de passe'],
        ])
        ->add('submit', SubmitType::class, [
            'label' => "S'inscrire"
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