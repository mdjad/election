<?php

namespace App\Controller\Admin;

use App\Entity\Candidat;
use App\Entity\Electeur;
use App\Entity\Election;
use App\Entity\Role;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Election Système');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateFormat('dd/MM/yyyy')
            ->setDateTimeFormat('dd/MM/yyyy HH:mm');
    }

    public function configureMenuItems(): iterable
    {
        $submenu1 = [
            MenuItem::linkToCrud('Election', 'fas fa-archive', Election::class),
            MenuItem::linkToCrud('Candidat', 'far fa-id-badge', Candidat::class),
            MenuItem::linkToCrud('Electeur', 'fas fa-users', Electeur::class),
        ];

        yield MenuItem::subMenu('Menu principal', 'fas fa-tasks')->setSubItems($submenu1);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user-circle', User::class);
        yield MenuItem::linkToCrud('Role', 'far fa-gem', Role::class);
    }
}
