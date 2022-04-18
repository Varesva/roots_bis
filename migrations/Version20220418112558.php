<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418112558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison ADD pays VARCHAR(50) DEFAULT NULL, CHANGE ville ville VARCHAR(50) DEFAULT NULL, CHANGE code_postal cp VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE telephone telephone VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison DROP pays, CHANGE ville ville VARCHAR(100) DEFAULT NULL, CHANGE cp code_postal VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(80) NOT NULL, CHANGE telephone telephone INT DEFAULT NULL');
    }
}
