<?php

namespace App\Controller\Admin\crud;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\EqualTo;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm(),
            EmailField::new('Email'),
            ChoiceField::new('roles', 'Roles')
                ->allowMultipleChoices()
                ->setChoices([
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ])
                ->renderAsBadges(),
            TextField::new('Firstname'),
            TextField::new('Lastname'),
            TextField::new('Username'),
            DateTimeField::new('CreatedAt')->hideOnForm(),
            DateTimeField::new('UpdatedAt')->hideOnForm()->setFormTypeOption('widget', 'single_text'),
            AssociationField::new('Comment')
                ->setFormTypeOptions([
                    'by_reference' => true, // Permet de gérer correctement les collections Doctrine
                ]),
            // AssociationField::new('Comment')->hideOnIndex(),
            // AssociationField::new('galleries')->hideOnIndex()->setFormTypeOption('by_reference', false),
        ];

        if ($pageName === Crud::PAGE_NEW) {
            $fields[] = TextField::new('password', 'Password')
                ->setFormType(PasswordType::class);
        }

        if ($pageName === Crud::PAGE_EDIT) {
            $fields[] = TextField::new('password', 'Change Password')
                ->setFormType(PasswordType::class)
                ->setRequired(false)
                ->setFormTypeOption('empty_data', '');
        }

        return $fields;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword())
            );
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $originalPassword = $entityManager->getUnitOfWork()->getOriginalEntityData($entityInstance)['password'];

            // Récupérer le nouveau mot de passe du formulaire
            $newPassword = $entityInstance->getPassword();

            // Vérifiez si un nouveau mot de passe a été fourni et qu'il est différent du mot de passe original
            if (!empty($newPassword) && $newPassword !== $originalPassword) {
                // Hasher le nouveau mot de passe et le définir
                $entityInstance->setPassword(
                    $this->passwordHasher->hashPassword($entityInstance, $newPassword)
                );
            } else {
                // Si le nouveau mot de passe est vide, rétablir l'ancien mot de passe
                $entityInstance->setPassword($originalPassword);
            }

            // Mettre à jour la date de mise à jour
            $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}
