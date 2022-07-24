<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220708201626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCDA03D0');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCDA03D0 FOREIGN KEY (categ_produit_id) REFERENCES boutique (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCDA03D0');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCDA03D0 FOREIGN KEY (categ_produit_id) REFERENCES boutique (id) ON DELETE CASCADE');
    }
}
