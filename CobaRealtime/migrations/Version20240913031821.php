<?php

declare (strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240913031821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create data_realtime table with columns IDAssy, Zvalue, Xvalue, username, datetime, and status';
    }

    public function up(Schema $schema): void
    {
        // Create the data_realtime table
        $this->addSql('
            CREATE TABLE data_realtime (
                IDAssy  SERIAL PRIMARY KEY,
                "Zvalue" DECIMAL(8, 2) NOT NULL,
                "Xvalue" DECIMAL(8, 2) NOT NULL,
                "username" VARCHAR(255) NOT NULL,
                "datetime" TIMESTAMP NOT NULL,
                "status" VARCHAR(255) NOT NULL, 
            );
        ');
    }

    public function down(Schema $schema): void
    {
        // Drop the dataRealtime table
        $this->addSql('DROP TABLE dataRealtime');
    }
}
