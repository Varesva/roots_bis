<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421111852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE giftcardcopy');
        $this->addSql('DROP TABLE livrecopy');
        $this->addSql('ALTER TABLE produit ADD categ_restauration_id INT DEFAULT NULL, ADD categ_nutrition_id INT DEFAULT NULL, ADD giftcard_valeur INT DEFAULT NULL, ADD livre_auteur VARCHAR(150) DEFAULT NULL, ADD livre_edition VARCHAR(150) DEFAULT NULL, ADD livre_resume VARCHAR(800) DEFAULT NULL, CHANGE prix prix NUMERIC(6, 2) NOT NULL, CHANGE titre titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC273FBCDFAC FOREIGN KEY (categ_restauration_id) REFERENCES restauration (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27ED1367CB FOREIGN KEY (categ_nutrition_id) REFERENCES nutrition (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC273FBCDFAC ON produit (categ_restauration_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27ED1367CB ON produit (categ_nutrition_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE giftcardcopy (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, valeur NUMERIC(5, 2) NOT NULL, INDEX IDX_4833F46BF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE livrecopy (id INT AUTO_INCREMENT NOT NULL, restauration_id INT NOT NULL, nutrition_id INT NOT NULL, produit_id INT DEFAULT NULL, auteur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, edition VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, resume VARCHAR(800) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_678408F6B5D724CD (nutrition_id), INDEX IDX_678408F67C6CB929 (restauration_id), INDEX IDX_678408F6F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE giftcardcopy ADD CONSTRAINT FK_4833F46BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE livrecopy ADD CONSTRAINT FK_678408F67C6CB929 FOREIGN KEY (restauration_id) REFERENCES restauration (id)');
        $this->addSql('ALTER TABLE livrecopy ADD CONSTRAINT FK_678408F6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE livrecopy ADD CONSTRAINT FK_678408F6B5D724CD FOREIGN KEY (nutrition_id) REFERENCES nutrition (id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC273FBCDFAC');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27ED1367CB');
        $this->addSql('DROP INDEX IDX_29A5EC273FBCDFAC ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC27ED1367CB ON produit');
        $this->addSql('ALTER TABLE produit DROP categ_restauration_id, DROP categ_nutrition_id, DROP giftcard_valeur, DROP livre_auteur, DROP livre_edition, DROP livre_resume, CHANGE titre titre VARCHAR(150) NOT NULL, CHANGE prix prix NUMERIC(10, 2) NOT NULL');
    }
}
