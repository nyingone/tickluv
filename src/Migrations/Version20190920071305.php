<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920071305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, booking_order_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, country VARCHAR(2) NOT NULL, discounted TINYINT(1) NOT NULL, cost DOUBLE PRECISION DEFAULT NULL, created_on DATETIME NOT NULL, confirmed_on DATETIME DEFAULT NULL, ticket_ref VARCHAR(255) DEFAULT NULL, cancelled TINYINT(1) NOT NULL, INDEX IDX_CAE5E19FB6ABF3B5 (booking_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visitor ADD CONSTRAINT FK_CAE5E19FB6ABF3B5 FOREIGN KEY (booking_order_id) REFERENCES booking_order (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE visitor');
    }
}
