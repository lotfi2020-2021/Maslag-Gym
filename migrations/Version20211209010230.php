<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209010230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category2 (id INT AUTO_INCREMENT NOT NULL, labell1 VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercice (categorie_id INT DEFAULT NULL, Id_Ex INT AUTO_INCREMENT NOT NULL, Nom_Ex VARCHAR(255) NOT NULL, Num_Ser INT NOT NULL, Num_Rep INT NOT NULL, filename VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E418C74DBCF5E72D (categorie_id), PRIMARY KEY(Id_Ex)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES category2 (id)');
        $this->addSql('ALTER TABLE product CHANGE filename filename VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74DBCF5E72D');
        $this->addSql('DROP TABLE category2');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('ALTER TABLE product CHANGE filename filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
