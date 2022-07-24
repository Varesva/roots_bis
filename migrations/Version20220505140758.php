<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505140758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BE2F0A35');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP INDEX IDX_8D93D649BE2F0A35 ON user');
        $this->addSql('ALTER TABLE user ADD rue VARCHAR(255) DEFAULT NULL, ADD cp VARCHAR(20) DEFAULT NULL, ADD ville VARCHAR(100) DEFAULT NULL, ADD pays VARCHAR(100) DEFAULT NULL, CHANGE adresse_livraison_id num INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, num INT DEFAULT NULL, rue VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, cp VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ville VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, commentaire VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, pays VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user DROP rue, DROP cp, DROP ville, DROP pays, CHANGE num adresse_livraison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BE2F0A35 FOREIGN KEY (adresse_livraison_id) REFERENCES livraison (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649BE2F0A35 ON user (adresse_livraison_id)');
    }
}
