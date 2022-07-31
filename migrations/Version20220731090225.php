<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220731090225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitats_caracteristiques_habitat (habitats_id INT NOT NULL, caracteristiques_habitat_id INT NOT NULL, INDEX IDX_B993B5D35D3C6F5 (habitats_id), INDEX IDX_B993B5DFF566EE5 (caracteristiques_habitat_id), PRIMARY KEY(habitats_id, caracteristiques_habitat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types_habitat_caracteristiques_type_habitat (types_habitat_id INT NOT NULL, caracteristiques_type_habitat_id INT NOT NULL, INDEX IDX_78F6E8D49A979CB6 (types_habitat_id), INDEX IDX_78F6E8D4F839CF57 (caracteristiques_type_habitat_id), PRIMARY KEY(types_habitat_id, caracteristiques_type_habitat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habitats_caracteristiques_habitat ADD CONSTRAINT FK_B993B5D35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habitats_caracteristiques_habitat ADD CONSTRAINT FK_B993B5DFF566EE5 FOREIGN KEY (caracteristiques_habitat_id) REFERENCES caracteristiques_habitat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE types_habitat_caracteristiques_type_habitat ADD CONSTRAINT FK_78F6E8D49A979CB6 FOREIGN KEY (types_habitat_id) REFERENCES types_habitat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE types_habitat_caracteristiques_type_habitat ADD CONSTRAINT FK_78F6E8D4F839CF57 FOREIGN KEY (caracteristiques_type_habitat_id) REFERENCES caracteristiques_type_habitat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE caracteristiques_habitat DROP FOREIGN KEY FK_4927F75F61013380');
        $this->addSql('ALTER TABLE caracteristiques_habitat DROP FOREIGN KEY FK_4927F75FAFFE2D26');
        $this->addSql('DROP INDEX IDX_4927F75F61013380 ON caracteristiques_habitat');
        $this->addSql('DROP INDEX IDX_4927F75FAFFE2D26 ON caracteristiques_habitat');
        $this->addSql('ALTER TABLE caracteristiques_habitat DROP habitat_id, DROP caracteritique_type_id');
        $this->addSql('ALTER TABLE caracteristiques_type_habitat DROP FOREIGN KEY FK_1C141912C54C8C93');
        $this->addSql('DROP INDEX IDX_1C141912C54C8C93 ON caracteristiques_type_habitat');
        $this->addSql('ALTER TABLE caracteristiques_type_habitat DROP type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE habitats_caracteristiques_habitat');
        $this->addSql('DROP TABLE types_habitat_caracteristiques_type_habitat');
        $this->addSql('ALTER TABLE caracteristiques_habitat ADD habitat_id INT NOT NULL, ADD caracteritique_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE caracteristiques_habitat ADD CONSTRAINT FK_4927F75F61013380 FOREIGN KEY (caracteritique_type_id) REFERENCES caracteristiques_type_habitat (id)');
        $this->addSql('ALTER TABLE caracteristiques_habitat ADD CONSTRAINT FK_4927F75FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_4927F75F61013380 ON caracteristiques_habitat (caracteritique_type_id)');
        $this->addSql('CREATE INDEX IDX_4927F75FAFFE2D26 ON caracteristiques_habitat (habitat_id)');
        $this->addSql('ALTER TABLE caracteristiques_type_habitat ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE caracteristiques_type_habitat ADD CONSTRAINT FK_1C141912C54C8C93 FOREIGN KEY (type_id) REFERENCES types_habitat (id)');
        $this->addSql('CREATE INDEX IDX_1C141912C54C8C93 ON caracteristiques_type_habitat (type_id)');
    }
}
