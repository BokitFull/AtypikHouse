<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706124228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitats_informations_pratiques (habitats_id INT NOT NULL, informations_pratiques_id INT NOT NULL, INDEX IDX_A1D74DC535D3C6F5 (habitats_id), INDEX IDX_A1D74DC5420938E5 (informations_pratiques_id), PRIMARY KEY(habitats_id, informations_pratiques_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habitats_informations_pratiques ADD CONSTRAINT FK_A1D74DC535D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habitats_informations_pratiques ADD CONSTRAINT FK_A1D74DC5420938E5 FOREIGN KEY (informations_pratiques_id) REFERENCES informations_pratiques (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habitats CHANGE images images JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE informations_pratiques DROP FOREIGN KEY FK_43A25C0E35D3C6F5');
        $this->addSql('DROP INDEX IDX_43A25C0E35D3C6F5 ON informations_pratiques');
        $this->addSql('ALTER TABLE informations_pratiques DROP habitats_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE habitats_informations_pratiques');
        $this->addSql('ALTER TABLE habitats CHANGE images images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE informations_pratiques ADD habitats_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE informations_pratiques ADD CONSTRAINT FK_43A25C0E35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_43A25C0E35D3C6F5 ON informations_pratiques (habitats_id)');
    }
}
