<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('title'),
            ChoiceField::new('placement')
                ->setLabel('Placement')
                ->setChoices([
                    '1' => 1,
                    '2' => 2,
                    '3' => 3
                ]),
            AssociationField::new('gallery', 'Gallery Id')
                ->setFormTypeOptions([
                    'by_reference' => true, // Permet de gérer correctement les collections Doctrine
                ]),
        ];

        // Ajout conditionnel du champ 'photo'
        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT) {
            $fields[] = ImageField::new('photo')
                ->setBasePath('/photoFolder')
                ->setUploadDir('public/photoFolder')
                ->setUploadedFileNamePattern('[slug]-[year]-[month]-[day].[extension]');
        }
        return $fields;
    }
}
