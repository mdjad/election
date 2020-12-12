<?php

namespace App\Controller\Admin;

use App\Entity\Election;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ElectionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Election::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Election')
            ->setEntityLabelInPlural('Election')
            ->setSearchFields(['id', 'nom']);
    }

    public function configureFields(string $pageName): iterable
    {
        $nom = TextField::new('nom');
        $debutInscription = DateTimeField::new('debut_inscription');
        $finInscription = DateTimeField::new('fin_inscription');
        $debutVote = DateTimeField::new('debut_vote');
        $finVote = DateTimeField::new('fin_vote');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $nom, $debutInscription, $finInscription, $debutVote, $finVote];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$nom, $debutInscription, $finInscription, $debutVote, $finVote];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$nom, $debutInscription, $finInscription, $debutVote, $finVote];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$nom, $debutInscription, $finInscription, $debutVote, $finVote];
        }
    }
}
