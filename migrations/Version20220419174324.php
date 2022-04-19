<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419174324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, restauration_id INT NOT NULL, specialite_id INT NOT NULL, nutrition_id INT DEFAULT NULL, adresse_id INT DEFAULT NULL, contact_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, photo VARCHAR(255) DEFAULT NULL, description VARCHAR(1000) NOT NULL, prix NUMERIC(5, 2) DEFAULT NULL, INDEX IDX_EB95123F7C6CB929 (restauration_id), INDEX IDX_EB95123F2195E0F0 (specialite_id), INDEX IDX_EB95123FB5D724CD (nutrition_id), UNIQUE INDEX UNIQ_EB95123F4DE7DC5C (adresse_id), UNIQUE INDEX UNIQ_EB95123FE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F7C6CB929 FOREIGN KEY (restauration_id) REFERENCES restauration (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FB5D724CD FOREIGN KEY (nutrition_id) REFERENCES nutrition (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE restaurant');
    }
}
