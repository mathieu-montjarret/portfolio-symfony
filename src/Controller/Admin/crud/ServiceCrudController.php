<?php

namespace App\Controller\Admin\crud;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('information'),
            MoneyField::new('price')->setCurrency('EUR')
                ->setStoredAsCents(false),
            AssociationField::new('galleries')
                ->setFormTypeOptions([
                    'by_reference' => false, // Permet de gérer correctement les collections Doctrine
                    'multiple' => true, // Permet la sélection de plusieurs galeries
                ]),
        ];
    }
}
