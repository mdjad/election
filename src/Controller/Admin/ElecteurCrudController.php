<?php

namespace App\Controller\Admin;

use App\Entity\Electeur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ElecteurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Electeur::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Electeur')
            ->setEntityLabelInPlural('Electeur')
            ->setSearchFields(['id', 'nom', 'prenom', 'telephone', 'email', 'num_carte', 'num_electorale', 'cni_photo']);
    }

    public function configureFields(string $pageName): iterable
    {
        $nom = TextField::new('nom');
        $prenom = TextField::new('prenom');
        $dateNaissance = DateField::new('date_naissance');
        $telephone = TextField::new('telephone');
        $email = TextField::new('email');
        $numCarte = TextField::new('num_carte', 'Num CNI');
        $cniFile = Field::new('cniFile');
        $votant = TextField::new('votant');
        $age = TextField::new('age');
        $cniPhoto = ImageField::new('cni_photo', 'CNI');
        $numElectorale = TextField::new('num_electorale', 'Numero Electeur');
        $id = IntegerField::new('id', 'ID');
        $valide = BooleanField::new('valide');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $valide, $votant, $age, $telephone, $email, $cniPhoto];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$votant, $age, $telephone, $email, $numCarte, $cniPhoto, $numElectorale];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nom, $prenom, $dateNaissance, $telephone, $email, $numCarte, $cniFile];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom, $prenom, $dateNaissance, $telephone, $email, $numCarte, $cniFile];
        }
    }
}
