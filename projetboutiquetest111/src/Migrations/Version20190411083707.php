<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411083707 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit CHANGE description description LONGTEXT DEFAULT NULL, CHANGE prix prix INT DEFAULT NULL, CHANGE en_avant en_avant TINYINT(1) DEFAULT NULL, CHANGE code_barre code_barre VARCHAR(255) DEFAULT NULL, CHANGE code_fournisseur code_fournisseur VARCHAR(255) DEFAULT NULL, CHANGE taille taille VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('ALTER TABLE produit CHANGE description description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE prix prix INT NOT NULL, CHANGE en_avant en_avant TINYINT(1) NOT NULL, CHANGE code_barre code_barre VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE code_fournisseur code_fournisseur VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE taille taille VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
