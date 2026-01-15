<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260106085049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'delete table : Review';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6D63673B0');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6B171EB6C');
        $this->addSql('DROP TABLE review');
        $this->addSql('ALTER TABLE company CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD company_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD238B53C32 FOREIGN KEY (company_id_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD238B53C32 ON service (company_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, rating NUMERIC(2, 1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, customer_id_id INT DEFAULT NULL, service_id_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_794381C6D63673B0 (service_id_id), UNIQUE INDEX UNIQ_794381C6B171EB6C (customer_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6D63673B0 FOREIGN KEY (service_id_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6B171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE company CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD238B53C32');
        $this->addSql('DROP INDEX IDX_E19D9AD238B53C32 ON service');
        $this->addSql('ALTER TABLE service DROP company_id_id');
    }
}
