<?php

namespace App\Controller\Admin\crud;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Firstname'),
            TextField::new('Lastname'),
            EmailField::new('Email'),
            TelephoneField::new('Phone'),
            TextField::new('Subject'),
            TextareaField::new('Message')
                ->formatValue(function ($value) {
                    // Retourner la valeur sans la modifier, donc tout le texte sera affiché.
                    return $value;
                }),
        ];
    }
}
