<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260106082249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create table Review';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, rating NUMERIC(2, 1) NOT NULL, created_at DATETIME DEFAULT NULL, customer_id_id INT DEFAULT NULL, service_id_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_794381C6B171EB6C (customer_id_id), UNIQUE INDEX UNIQ_794381C6D63673B0 (service_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6B171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6D63673B0 FOREIGN KEY (service_id_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE booking CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE customer CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service CHANGE created_at created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6B171EB6C');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6D63673B0');
        $this->addSql('DROP TABLE review');
        $this->addSql('ALTER TABLE booking CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE customer CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE service CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
