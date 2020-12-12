<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Role::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Role')
            ->setEntityLabelInPlural('Role')
            ->setSearchFields(['id', 'nom', 'description']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable('new');
    }

    public function configureFields(string $pageName): iterable
    {
        $nom = TextField::new('nom');
        $description = TextareaField::new('description');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $nom, $description];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$nom, $description];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nom, $description];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom, $description];
        }
    }
}
