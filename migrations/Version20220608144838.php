<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608144838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP INDEX UNIQ_D9BEC0C4B83297E7, ADD INDEX IDX_D9BEC0C4B83297E7 (reservation_id)');
        $this->addSql('ALTER TABLE commentaires DROP INDEX UNIQ_D9BEC0C4FB88E14F, ADD INDEX IDX_D9BEC0C4FB88E14F (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP INDEX IDX_D9BEC0C4FB88E14F, ADD UNIQUE INDEX UNIQ_D9BEC0C4FB88E14F (utilisateur_id)');
        $this->addSql('ALTER TABLE commentaires DROP INDEX IDX_D9BEC0C4B83297E7, ADD UNIQUE INDEX UNIQ_D9BEC0C4B83297E7 (reservation_id)');
    }
}
