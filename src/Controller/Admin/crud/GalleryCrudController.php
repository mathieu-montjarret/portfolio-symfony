<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class GalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gallery::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Gallery Name'),
            SlugField::new('slug', 'Gallery Slug')
                ->setTargetFieldName('name'),
            DateTimeField::new('publishedAt', 'Published At')
                ->setFormat('Y-MM-DD HH:mm:ss')
                ->hideOnForm(),
            AssociationField::new('services', 'Services')
                ->setFormTypeOptions([
                    'by_reference' => false, // Permet de gérer correctement les collections Doctrine
                    'multiple' => true  // Permet la sélection de plusieurs services
                ])
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $gallery = new $entityFqcn; // Crée une nouvelle instance de Gallery
        $gallery->setPublishedAt(new \DateTimeImmutable()); // Initialise `publishedAt` avec la date et heure courantes

        return $gallery;
    }
}
