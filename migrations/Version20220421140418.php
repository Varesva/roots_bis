<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421140418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE giftcard (id INT AUTO_INCREMENT NOT NULL, carte VARCHAR(100) NOT NULL, valeur NUMERIC(5, 2) NOT NULL, image VARCHAR(255) DEFAULT NULL, prix NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, restauration_id INT NOT NULL, nutrition_id INT NOT NULL, titre VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, edition VARCHAR(255) DEFAULT NULL, couverture VARCHAR(255) NOT NULL, resume VARCHAR(800) NOT NULL, prix NUMERIC(5, 2) NOT NULL, INDEX IDX_AC634F997C6CB929 (restauration_id), INDEX IDX_AC634F99B5D724CD (nutrition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F997C6CB929 FOREIGN KEY (restauration_id) REFERENCES restauration (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99B5D724CD FOREIGN KEY (nutrition_id) REFERENCES nutrition (id)');
        $this->addSql('ALTER TABLE produit CHANGE giftcard_valeur giftcard_valeur NUMERIC(6, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE giftcard');
        $this->addSql('DROP TABLE livre');
        $this->addSql('ALTER TABLE produit CHANGE giftcard_valeur giftcard_valeur INT DEFAULT NULL');
    }
}
