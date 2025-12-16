<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251216222709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'remove nullable: true on some fields in Booking';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking CHANGE location_type location_type VARCHAR(255) NOT NULL, CHANGE urgency_rank urgency_rank VARCHAR(255) NOT NULL, CHANGE target_type target_type VARCHAR(255) NOT NULL, CHANGE objective_type objective_type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking CHANGE location_type location_type VARCHAR(255) DEFAULT NULL, CHANGE urgency_rank urgency_rank VARCHAR(255) DEFAULT NULL, CHANGE target_type target_type VARCHAR(255) DEFAULT NULL, CHANGE objective_type objective_type VARCHAR(255) DEFAULT NULL');
    }
}
