<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
        $fields = [
            IdField::new('id')->hideOnIndex()->hideOnForm(),
            TextField::new('title'),
            TextareaField::new('information')
                ->formatValue(function ($value) {
                    // Retourner la valeur sans la modifier, donc tout le texte sera affiché.
                    return $value;
                }),
            MoneyField::new('price')
                ->setCurrency('EUR')
                ->setStoredAsCents(false),
            IntegerField::new('duration', 'Duration (hours)'),
            AssociationField::new('galleries')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ]),
        ];

        // Ajout conditionnel du champ 'photo' pour le service
        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_NEW) {
            $fields[] = ImageField::new('photo')
                ->setBasePath('/servicesPhotoFolder') // Assurez-vous que ce chemin est correct et accessible publiquement
                ->setUploadDir('assets/servicesPhotoFolder') // Chemin relatif à votre répertoire 'public/'
                ->setUploadedFileNamePattern('[slug]-[year]-[month]-[day].[extension]');
        }

        return $fields;
    }
}
