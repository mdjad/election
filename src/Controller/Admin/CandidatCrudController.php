<?php

namespace App\Controller\Admin;

use App\Entity\Candidat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CandidatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidat::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Candidat')
            ->setEntityLabelInPlural('Candidat')
            ->setSearchFields(['id', 'nom', 'prenom', 'site_web', 'image']);
    }

    public function configureFields(string $pageName): iterable
    {
        $nom = TextField::new('nom');
        $prenom = TextField::new('prenom');
        $dateNaissance = DateField::new('date_naissance');
        $siteWeb = TextField::new('site_web');
        $imageFile = Field::new('imageFile');
        $election = AssociationField::new('election');
        $postulant = TextareaField::new('postulant');
        $age = TextareaField::new('age');
        $image = ImageField::new('image');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $postulant, $age, $siteWeb, $image];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$postulant, $age, $siteWeb, $image];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nom, $prenom, $dateNaissance, $siteWeb, $imageFile, $election];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom, $prenom, $dateNaissance, $siteWeb, $imageFile, $election];
        }
    }
}
