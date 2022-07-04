<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609125202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP INDEX UNIQ_D9BEC0C4FDED4547, ADD INDEX IDX_D9BEC0C4FDED4547 (commentaire_parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP INDEX IDX_D9BEC0C4FDED4547, ADD UNIQUE INDEX UNIQ_D9BEC0C4FDED4547 (commentaire_parent_id)');
    }
}
