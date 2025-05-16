<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250505162731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE detection_event (id SERIAL NOT NULL, detected_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, raw_data JSON NOT NULL, image_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE parking_space (id SERIAL NOT NULL, parking_zone_id INT NOT NULL, identifier VARCHAR(255) NOT NULL, is_occupied BOOLEAN NOT NULL, last_status_change VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E00675CC11C6C771 ON parking_space (parking_zone_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE parking_status (id SERIAL NOT NULL, parking_space_id INT DEFAULT NULL, is_occupied BOOLEAN NOT NULL, time_stamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2F17468145DF8272 ON parking_status (parking_space_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE parking_zone (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parking_space ADD CONSTRAINT FK_E00675CC11C6C771 FOREIGN KEY (parking_zone_id) REFERENCES parking_zone (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parking_status ADD CONSTRAINT FK_2F17468145DF8272 FOREIGN KEY (parking_space_id) REFERENCES parking_space (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parking_space DROP CONSTRAINT FK_E00675CC11C6C771
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE parking_status DROP CONSTRAINT FK_2F17468145DF8272
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE detection_event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE parking_space
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE parking_status
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE parking_zone
        SQL);
    }
}
