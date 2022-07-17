<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704131458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_habitat (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_habitats (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipements DROP etat');
        $this->addSql('ALTER TABLE habitats ADD type_habitat_id INT DEFAULT NULL, ADD statut TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3B2FDFB03 FOREIGN KEY (type_habitat_id) REFERENCES type_habitats (id)');
        $this->addSql('CREATE INDEX IDX_B5E492F3B2FDFB03 ON habitats (type_habitat_id)');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CFB88E14F');
        $this->addSql('DROP INDEX UNIQ_11BA68CFB88E14F ON notes');
        $this->addSql('ALTER TABLE notes DROP utilisateur_id');
        $this->addSql('ALTER TABLE reservations ADD statut TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3B2FDFB03');
        $this->addSql('DROP TABLE type_habitat');
        $this->addSql('DROP TABLE type_habitats');
        $this->addSql('ALTER TABLE equipements ADD etat VARCHAR(50) NOT NULL');
        $this->addSql('DROP INDEX IDX_B5E492F3B2FDFB03 ON habitats');
        $this->addSql('ALTER TABLE habitats DROP type_habitat_id, DROP statut');
        $this->addSql('ALTER TABLE notes ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11BA68CFB88E14F ON notes (utilisateur_id)');
        $this->addSql('ALTER TABLE reservations DROP statut');
    }
}