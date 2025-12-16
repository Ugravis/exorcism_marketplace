<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251216213758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add fields in Booking: location_type, urgency_rank, target_type, objective_type';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD location_type VARCHAR(255) DEFAULT NULL, ADD urgency_rank VARCHAR(255) DEFAULT NULL, ADD target_type VARCHAR(255) DEFAULT NULL, ADD objective_type VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP location_type, DROP urgency_rank, DROP target_type, DROP objective_type');
    }
}
