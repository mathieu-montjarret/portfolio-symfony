<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Firstname', TextType::class, [
                'label' => 'First Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('Lastname', TextType::class, [
                'label' => 'Last Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('Email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control']
            ])
            ->add('Phone', TelType::class, [
                'label' => 'Phone',
                'required' => false, // This field is optional
                'attr' => ['class' => 'form-control']
            ])
            ->add('Subject', TextType::class, [
                'label' => 'Subject',
                'attr' => ['class' => 'form-control']
            ])
            ->add('Message', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['class' => 'form-control', 'rows' => 5]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send',
                'attr' => ['class' => 'btn-color']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
