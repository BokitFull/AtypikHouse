<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704091452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE informations_pratiques (id INT AUTO_INCREMENT NOT NULL, habitats_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_43A25C0E35D3C6F5 (habitats_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE informations_pratiques ADD CONSTRAINT FK_43A25C0E35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE commentaires DROP INDEX UNIQ_D9BEC0C4B83297E7, ADD INDEX IDX_D9BEC0C4B83297E7 (reservation_id)');
        $this->addSql('ALTER TABLE commentaires DROP INDEX UNIQ_D9BEC0C4FDED4547, ADD INDEX IDX_D9BEC0C4FDED4547 (commentaire_parent_id)');
        $this->addSql('ALTER TABLE commentaires DROP INDEX UNIQ_D9BEC0C4FB88E14F, ADD INDEX IDX_D9BEC0C4FB88E14F (utilisateur_id)');
        $this->addSql('ALTER TABLE habitats ADD informations_supplementaires LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD prix DOUBLE PRECISION NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD nombre_personnes_max INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE informations_pratiques');
        $this->addSql('ALTER TABLE commentaires DROP INDEX IDX_D9BEC0C4FB88E14F, ADD UNIQUE INDEX UNIQ_D9BEC0C4FB88E14F (utilisateur_id)');
        $this->addSql('ALTER TABLE commentaires DROP INDEX IDX_D9BEC0C4B83297E7, ADD UNIQUE INDEX UNIQ_D9BEC0C4B83297E7 (reservation_id)');
        $this->addSql('ALTER TABLE commentaires DROP INDEX IDX_D9BEC0C4FDED4547, ADD UNIQUE INDEX UNIQ_D9BEC0C4FDED4547 (commentaire_parent_id)');
        $this->addSql('ALTER TABLE habitats DROP informations_supplementaires, DROP prix, DROP type, DROP nombre_personnes_max');
    }
}
