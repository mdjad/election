<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        // Add roles
        $roles = [
            'ROLE_ADMIN' => 'Dispose de tous pouvoir sur le projet',
            'ROLE_MANAGER' => 'Gère les utilisateurs et leur droit et peut crér du contenu',
            'ROLE_CONTROLEUR' => 'Voit le déroulement des votes et peut télecharger le resultat final à la fin du scrutin'
        ];

        $iter = 1;
        foreach ($roles as $key => $value) {
            $role[$iter] = new Role();
            $role[$iter]->getNom($key)
                ->setDescription($value);
            $manager->persist($role[$iter]);
            $iter++;
        }

        // Add users
        $users = [
            ['username' => 'election', 'email' => 'election@election.org', 'password' => 'election2019', 'role' => $role[1]],
            ['username' => 'manager', 'email' => 'manager@election.org', 'password' => 'manager2019', 'role' => $role[2]],
            ['username' => 'controleur', 'email' => 'controleur@election.org', 'password' => 'controleur2019', 'role' => $role[3]],
        ];

        foreach ($users as $contributor) {
            $user  = new User();
            $user->setUsername($contributor['username'])
                ->setEmail($contributor['email'])
                ->setRole($contributor['role'])
                ->setPassword($this->passwordEncoder->encodePassword($user, $contributor['password']));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
