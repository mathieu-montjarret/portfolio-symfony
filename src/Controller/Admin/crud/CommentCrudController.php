<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Cachez l'ID lors de la création ou de l'édition
            TextField::new('Name'), // Assurez-vous que le nom correspond à l'attribut de votre entité
            TextareaField::new('Description')
                ->formatValue(function ($value) {
                    // Retourner la valeur sans la modifier, donc tout le texte sera affiché.
                    return $value;
                }),
            DateTimeField::new('CreatedAt')->setFormat('Y-MM-DD HH:mm:ss')->hideOnForm(),
            // Ajoutez des champs supplémentaires ici selon vos besoins
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $comment = new $entityFqcn;
        $comment->setCreatedAt(new \DateTimeImmutable());

        return $comment;
    }
}
