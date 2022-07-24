<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220502130035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FE7A1254A');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F4DE7DC5C');
        $this->addSql('DROP INDEX UNIQ_EB95123FE7A1254A ON restaurant');
        $this->addSql('DROP INDEX UNIQ_EB95123F4DE7DC5C ON restaurant');
        $this->addSql('ALTER TABLE restaurant ADD num_rue INT DEFAULT NULL, ADD rue VARCHAR(255) DEFAULT NULL, ADD code_postal VARCHAR(15) NOT NULL, ADD ville VARCHAR(50) NOT NULL, ADD pays VARCHAR(50) DEFAULT NULL, ADD email VARCHAR(100) DEFAULT NULL, ADD telephone INT DEFAULT NULL, ADD website VARCHAR(100) DEFAULT NULL, DROP adresse_id, DROP contact_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant ADD adresse_id INT DEFAULT NULL, ADD contact_id INT DEFAULT NULL, DROP num_rue, DROP rue, DROP code_postal, DROP ville, DROP pays, DROP email, DROP telephone, DROP website');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123FE7A1254A ON restaurant (contact_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123F4DE7DC5C ON restaurant (adresse_id)');
    }
}
