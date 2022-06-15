<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602121438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateurs ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP role, CHANGE civilite civilite VARCHAR(2) DEFAULT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(100) DEFAULT NULL, CHANGE code_postal code_postal VARCHAR(10) DEFAULT NULL, CHANGE ville ville VARCHAR(80) DEFAULT NULL, CHANGE pays pays VARCHAR(80) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315EE7927C74 ON utilisateurs (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_497B315EE7927C74 ON utilisateurs');
        $this->addSql('ALTER TABLE utilisateurs ADD role VARCHAR(30) NOT NULL, DROP roles, CHANGE email email VARCHAR(100) NOT NULL, CHANGE password password VARCHAR(100) NOT NULL, CHANGE civilite civilite VARCHAR(2) NOT NULL, CHANGE adresse adresse VARCHAR(100) NOT NULL, CHANGE code_postal code_postal VARCHAR(5) NOT NULL, CHANGE ville ville VARCHAR(80) NOT NULL, CHANGE pays pays VARCHAR(80) NOT NULL');
    }
}
