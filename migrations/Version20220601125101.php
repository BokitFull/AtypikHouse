<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601125101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activites (id INT AUTO_INCREMENT NOT NULL, habitats_id INT DEFAULT NULL, libelle VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, image LONGTEXT NOT NULL, adresse VARCHAR(100) NOT NULL, code_postal VARCHAR(5) NOT NULL, ville VARCHAR(80) NOT NULL, pays VARCHAR(80) NOT NULL, INDEX IDX_766B5EB535D3C6F5 (habitats_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE codes (id INT AUTO_INCREMENT NOT NULL, utilisateur_debiteur_id INT DEFAULT NULL, utilisateur_crediteur_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_E5ADC14DDC89F518 (utilisateur_debiteur_id), UNIQUE INDEX UNIQ_E5ADC14D3B5A6201 (utilisateur_crediteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, reservation_id INT DEFAULT NULL, commentaire_parent_id INT DEFAULT NULL, commentaire LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_D9BEC0C4FB88E14F (utilisateur_id), UNIQUE INDEX UNIQ_D9BEC0C4B83297E7 (reservation_id), UNIQUE INDEX UNIQ_D9BEC0C4FDED4547 (commentaire_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipements (id INT AUTO_INCREMENT NOT NULL, habitats_id INT DEFAULT NULL, libelle VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, etat VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3F02D86B35D3C6F5 (habitats_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitats (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT DEFAULT NULL, libelle VARCHAR(150) NOT NULL, adresse VARCHAR(100) NOT NULL, code_postal VARCHAR(5) NOT NULL, ville VARCHAR(80) NOT NULL, pays VARCHAR(80) NOT NULL, est_disponible TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', images JSON DEFAULT NULL, INDEX IDX_B5E492F376C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, note VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_11BA68CB83297E7 (reservation_id), UNIQUE INDEX UNIQ_11BA68CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotions (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_EA1B3034B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, habitat_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4DA239FB88E14F (utilisateur_id), INDEX IDX_4DA239AFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(80) NOT NULL, prenom VARCHAR(80) NOT NULL, civilite VARCHAR(2) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, adresse VARCHAR(100) DEFAULT NULL, code_postal VARCHAR(10) DEFAULT NULL, ville VARCHAR(80) DEFAULT NULL, pays VARCHAR(80) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_497B315EE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activites ADD CONSTRAINT FK_766B5EB535D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE codes ADD CONSTRAINT FK_E5ADC14DDC89F518 FOREIGN KEY (utilisateur_debiteur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE codes ADD CONSTRAINT FK_E5ADC14D3B5A6201 FOREIGN KEY (utilisateur_crediteur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4FDED4547 FOREIGN KEY (commentaire_parent_id) REFERENCES commentaires (id)');
        $this->addSql('ALTER TABLE equipements ADD CONSTRAINT FK_3F02D86B35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F376C50E4A FOREIGN KEY (proprietaire_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE promotions ADD CONSTRAINT FK_EA1B3034B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4FDED4547');
        $this->addSql('ALTER TABLE activites DROP FOREIGN KEY FK_766B5EB535D3C6F5');
        $this->addSql('ALTER TABLE equipements DROP FOREIGN KEY FK_3F02D86B35D3C6F5');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239AFFE2D26');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4B83297E7');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CB83297E7');
        $this->addSql('ALTER TABLE promotions DROP FOREIGN KEY FK_EA1B3034B83297E7');
        $this->addSql('ALTER TABLE codes DROP FOREIGN KEY FK_E5ADC14DDC89F518');
        $this->addSql('ALTER TABLE codes DROP FOREIGN KEY FK_E5ADC14D3B5A6201');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4FB88E14F');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F376C50E4A');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68CFB88E14F');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239FB88E14F');
        $this->addSql('DROP TABLE activites');
        $this->addSql('DROP TABLE codes');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE equipements');
        $this->addSql('DROP TABLE habitats');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE promotions');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
