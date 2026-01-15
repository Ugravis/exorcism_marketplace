<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260106093547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'delete table : company';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY IF EXISTS FK_E19D9AD238B53C32');
        $this->addSql('DROP INDEX IF EXISTS IDX_E19D9AD238B53C32 ON service');
        $this->addSql('ALTER TABLE service DROP COLUMN IF EXISTS company_id_id');
        $this->addSql('DROP TABLE IF EXISTS company');
        $this->addSql('ALTER TABLE service CHANGE created_at created_at DATETIME DEFAULT NULL');
    }


    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, address LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE service ADD company_id_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD238B53C32 FOREIGN KEY (company_id_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD238B53C32 ON service (company_id_id)');
    }
}
