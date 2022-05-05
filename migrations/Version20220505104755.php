<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505104755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F7C6CB929');
        $this->addSql('DROP INDEX IDX_EB95123F7C6CB929 ON restaurant');
        $this->addSql('ALTER TABLE restaurant CHANGE restauration_id categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_restaurant (id)');
        $this->addSql('CREATE INDEX IDX_EB95123FBCF5E72D ON restaurant (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FBCF5E72D');
        $this->addSql('DROP INDEX IDX_EB95123FBCF5E72D ON restaurant');
        $this->addSql('ALTER TABLE restaurant CHANGE categorie_id restauration_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F7C6CB929 FOREIGN KEY (restauration_id) REFERENCES restauration (id)');
        $this->addSql('CREATE INDEX IDX_EB95123F7C6CB929 ON restaurant (restauration_id)');
    }
}
