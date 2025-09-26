<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250926122739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change sport_venue.lat and sport_venue.lng to decimal(10,6)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sport_venue CHANGE lat lat NUMERIC(10, 6) NOT NULL, CHANGE lng lng NUMERIC(10, 6) NOT NULL');
        $this->addSql('CREATE INDEX IDX_SPORTVENUE_LAT_LNG ON sport_venue (lat, lng)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_SPORTVENUE_LAT_LNG ON sport_venue');
        $this->addSql('ALTER TABLE sport_venue CHANGE lat lat VARCHAR(255) NOT NULL, CHANGE lng lng VARCHAR(255) NOT NULL');
    }
}
