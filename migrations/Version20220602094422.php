<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602094422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitats_equipements (habitats_id INT NOT NULL, equipements_id INT NOT NULL, INDEX IDX_EF2D363D35D3C6F5 (habitats_id), INDEX IDX_EF2D363D852CCFF5 (equipements_id), PRIMARY KEY(habitats_id, equipements_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habitats_equipements ADD CONSTRAINT FK_EF2D363D35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habitats_equipements ADD CONSTRAINT FK_EF2D363D852CCFF5 FOREIGN KEY (equipements_id) REFERENCES equipements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipements DROP FOREIGN KEY FK_3F02D86B35D3C6F5');
        $this->addSql('DROP INDEX IDX_3F02D86B35D3C6F5 ON equipements');
        $this->addSql('ALTER TABLE equipements DROP habitats_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE habitats_equipements');
        $this->addSql('ALTER TABLE equipements ADD habitats_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipements ADD CONSTRAINT FK_3F02D86B35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_3F02D86B35D3C6F5 ON equipements (habitats_id)');
    }
}
