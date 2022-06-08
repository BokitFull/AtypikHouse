<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602120549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notes ADD note_proprete DOUBLE PRECISION NOT NULL, ADD note_accueil DOUBLE PRECISION NOT NULL, ADD note_emplacement DOUBLE PRECISION NOT NULL, ADD note_qualite_prix DOUBLE PRECISION NOT NULL, ADD note_equipements DOUBLE PRECISION NOT NULL, DROP note');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notes ADD note VARCHAR(20) NOT NULL, DROP note_proprete, DROP note_accueil, DROP note_emplacement, DROP note_qualite_prix, DROP note_equipements');
    }
}
