<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411095727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit ADD commande_id INT DEFAULT NULL, CHANGE text text LONGTEXT DEFAULT NULL, CHANGE prix_achat prix_achat NUMERIC(7, 2) DEFAULT NULL, CHANGE tva tva NUMERIC(4, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC2782EA2E54 ON produit (commande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2782EA2E54');
        $this->addSql('DROP INDEX IDX_29A5EC2782EA2E54 ON produit');
        $this->addSql('ALTER TABLE produit DROP commande_id, CHANGE prix_achat prix_achat NUMERIC(7, 2) NOT NULL, CHANGE tva tva NUMERIC(4, 2) NOT NULL, CHANGE text text LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
