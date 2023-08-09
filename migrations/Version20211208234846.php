<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211208234846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_c (id INT AUTO_INCREMENT NOT NULL, labell VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, cin INT NOT NULL, background VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, border VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, allday TINYINT(1) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_D499BFF612469DE2 (category_id), FULLTEXT INDEX IDX_D499BFF66C6E55B5A625945B (nom, prenom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF612469DE2 FOREIGN KEY (category_id) REFERENCES category_c (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF612469DE2');
        $this->addSql('DROP TABLE category_c');
        $this->addSql('DROP TABLE planning');
    }
}
