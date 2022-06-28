<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626171007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse_livraison ADD nom VARCHAR(50) NOT NULL, ADD prenom VARCHAR(50) NOT NULL, ADD telephone VARCHAR(20) DEFAULT NULL, ADD num INT NOT NULL, ADD rue VARCHAR(255) NOT NULL, ADD cp VARCHAR(20) NOT NULL, ADD ville VARCHAR(100) NOT NULL, ADD pays VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE user ADD complement_adresse VARCHAR(180) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse_livraison DROP nom, DROP prenom, DROP telephone, DROP num, DROP rue, DROP cp, DROP ville, DROP pays');
        $this->addSql('ALTER TABLE user DROP complement_adresse');
    }
}
