<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190301154710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, election_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, site_web VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6AB5B471A708DAFF (election_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, telephone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, num_carte VARCHAR(255) NOT NULL, cni_photo VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE election (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, debut_inscription DATETIME NOT NULL, fin_inscription DATETIME NOT NULL, debut_vote DATETIME NOT NULL, fin_vote DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, fichier VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, election_id INT NOT NULL, votant_id INT NOT NULL, INDEX IDX_5A108564A708DAFF (election_id), INDEX IDX_5A108564ECABD6E4 (votant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_candidat (vote_id INT NOT NULL, candidat_id INT NOT NULL, INDEX IDX_94EA1D5872DCDAFC (vote_id), INDEX IDX_94EA1D588D0EB82 (candidat_id), PRIMARY KEY(vote_id, candidat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471A708DAFF FOREIGN KEY (election_id) REFERENCES election (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A708DAFF FOREIGN KEY (election_id) REFERENCES election (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564ECABD6E4 FOREIGN KEY (votant_id) REFERENCES electeur (id)');
        $this->addSql('ALTER TABLE vote_candidat ADD CONSTRAINT FK_94EA1D5872DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_candidat ADD CONSTRAINT FK_94EA1D588D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vote_candidat DROP FOREIGN KEY FK_94EA1D588D0EB82');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564ECABD6E4');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471A708DAFF');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A708DAFF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE vote_candidat DROP FOREIGN KEY FK_94EA1D5872DCDAFC');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE electeur');
        $this->addSql('DROP TABLE election');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE vote_candidat');
    }
}
