<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717182147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caracteristiques_habitat (id INT AUTO_INCREMENT NOT NULL, habitat_id INT NOT NULL, caracteritique_type_id INT NOT NULL, valeur VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4927F75FAFFE2D26 (habitat_id), INDEX IDX_4927F75F61013380 (caracteritique_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caracteristiques_type_habitat (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, nom VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1C141912C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, reponse LONGTEXT DEFAULT NULL, note_proprete INT NOT NULL, note_accueil INT NOT NULL, note_qualite_prix INT NOT NULL, note_emplacement INT NOT NULL, note_equipements INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', contenu LONGTEXT NOT NULL, INDEX IDX_D9BEC0C4B83297E7 (reservation_id), INDEX IDX_D9BEC0C4FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitats (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, type_id INT DEFAULT NULL, titre VARCHAR(150) NOT NULL, adresse VARCHAR(100) NOT NULL, code_postal VARCHAR(10) NOT NULL, pays VARCHAR(80) NOT NULL, description LONGTEXT NOT NULL, nb_personnes INT NOT NULL, prix DOUBLE PRECISION NOT NULL, debut_disponibilite DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', fin_disponibilite DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', est_valide TINYINT(1) NOT NULL, est_actif TINYINT(1) NOT NULL, ville VARCHAR(80) NOT NULL, INDEX IDX_B5E492F3FB88E14F (utilisateur_id), INDEX IDX_B5E492F3C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitats_prestations (habitats_id INT NOT NULL, prestations_id INT NOT NULL, INDEX IDX_6317368735D3C6F5 (habitats_id), INDEX IDX_631736878BE96D0D (prestations_id), PRIMARY KEY(habitats_id, prestations_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_habitat (id INT AUTO_INCREMENT NOT NULL, habitat_id INT NOT NULL, chemin VARCHAR(255) NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A44AAC8AAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, card_number VARCHAR(16) NOT NULL, month_validity VARCHAR(2) NOT NULL, year_validity VARCHAR(2) NOT NULL, cvc VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_65D29B32FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestations (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, nom VARCHAR(100) NOT NULL, icone VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B338D8D1C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, habitat_id INT DEFAULT NULL, date_debut DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', date_fin DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', statut VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', nb_personnes INT NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_4DA239FB88E14F (utilisateur_id), INDEX IDX_4DA239AFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types_habitat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types_prestation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(80) NOT NULL, civilite VARCHAR(2) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, adresse VARCHAR(100) DEFAULT NULL, code_postal VARCHAR(5) DEFAULT NULL, ville VARCHAR(70) DEFAULT NULL, pays VARCHAR(80) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', photo_profil VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_497B315EE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caracteristiques_habitat ADD CONSTRAINT FK_4927F75FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE caracteristiques_habitat ADD CONSTRAINT FK_4927F75F61013380 FOREIGN KEY (caracteritique_type_id) REFERENCES caracteristiques_type_habitat (id)');
        $this->addSql('ALTER TABLE caracteristiques_type_habitat ADD CONSTRAINT FK_1C141912C54C8C93 FOREIGN KEY (type_id) REFERENCES types_habitat (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F3C54C8C93 FOREIGN KEY (type_id) REFERENCES types_habitat (id)');
        $this->addSql('ALTER TABLE habitats_prestations ADD CONSTRAINT FK_6317368735D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habitats_prestations ADD CONSTRAINT FK_631736878BE96D0D FOREIGN KEY (prestations_id) REFERENCES prestations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_habitat ADD CONSTRAINT FK_A44AAC8AAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B32FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D1C54C8C93 FOREIGN KEY (type_id) REFERENCES types_prestation (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caracteristiques_habitat DROP FOREIGN KEY FK_4927F75F61013380');
        $this->addSql('ALTER TABLE caracteristiques_habitat DROP FOREIGN KEY FK_4927F75FAFFE2D26');
        $this->addSql('ALTER TABLE habitats_prestations DROP FOREIGN KEY FK_6317368735D3C6F5');
        $this->addSql('ALTER TABLE images_habitat DROP FOREIGN KEY FK_A44AAC8AAFFE2D26');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239AFFE2D26');
        $this->addSql('ALTER TABLE habitats_prestations DROP FOREIGN KEY FK_631736878BE96D0D');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4B83297E7');
        $this->addSql('ALTER TABLE caracteristiques_type_habitat DROP FOREIGN KEY FK_1C141912C54C8C93');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3C54C8C93');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D1C54C8C93');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4FB88E14F');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F3FB88E14F');
        $this->addSql('ALTER TABLE payments DROP FOREIGN KEY FK_65D29B32FB88E14F');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239FB88E14F');
        $this->addSql('DROP TABLE caracteristiques_habitat');
        $this->addSql('DROP TABLE caracteristiques_type_habitat');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE habitats');
        $this->addSql('DROP TABLE habitats_prestations');
        $this->addSql('DROP TABLE images_habitat');
        $this->addSql('DROP TABLE payments');
        $this->addSql('DROP TABLE prestations');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE types_habitat');
        $this->addSql('DROP TABLE types_prestation');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
