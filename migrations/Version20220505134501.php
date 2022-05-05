<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505134501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_FE866410A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67D7F2DEE08 ON commande (facture_id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC273FBCDFAC');
        $this->addSql('DROP INDEX IDX_29A5EC273FBCDFAC ON produit');
        $this->addSql('ALTER TABLE produit CHANGE categ_restauration_id categ_type_cuisine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27B3981CB4 FOREIGN KEY (categ_type_cuisine_id) REFERENCES categorie_restaurant (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27B3981CB4 ON produit (categ_type_cuisine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D7F2DEE08');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP INDEX UNIQ_6EEAA67D7F2DEE08 ON commande');
        $this->addSql('ALTER TABLE commande DROP facture_id');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27B3981CB4');
        $this->addSql('DROP INDEX IDX_29A5EC27B3981CB4 ON produit');
        $this->addSql('ALTER TABLE produit CHANGE categ_type_cuisine_id categ_restauration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC273FBCDFAC FOREIGN KEY (categ_restauration_id) REFERENCES restauration (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC273FBCDFAC ON produit (categ_restauration_id)');
    }
}
