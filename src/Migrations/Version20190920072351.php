<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920072351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_order ADD validated_at DATETIME DEFAULT NULL, ADD cancelled_at DATETIME DEFAULT NULL, DROP validated_on, DROP cancelled_on');
        $this->addSql('ALTER TABLE visitor CHANGE created_on created_at DATETIME NOT NULL, CHANGE confirmed_on confirmed_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_order ADD validated_on DATETIME DEFAULT NULL, ADD cancelled_on DATETIME DEFAULT NULL, DROP validated_at, DROP cancelled_at');
        $this->addSql('ALTER TABLE visitor CHANGE created_at created_on DATETIME NOT NULL, CHANGE confirmed_at confirmed_on DATETIME DEFAULT NULL');
    }
}
