# election
Election online Comores 2019

# Instllation
- git clone -b develop https://github.com/mdjad/election.git election
- composer install 

# Configuration
- modifier le fichier .env pour le faire correspondre à la base de donnée et seveur mail
- mettre à jour les fichiers de configurations du dossier /config/package en fonction des besoins


# Migration et contenu de base

- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate
- php bin/console doctrine:fixtures:load

# Gestion de l'application 

- depuis l'url de base de votre appliction ajouter /manager
- identifient: election, mot de passe: election2019
