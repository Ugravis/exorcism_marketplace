<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260106075853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add createdAt';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP created_at');
        $this->addSql('ALTER TABLE customer DROP created_at');
        $this->addSql('ALTER TABLE service DROP created_at');
    }
}
