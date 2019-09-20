<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920064311 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE booking_order (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, order_number INT NOT NULL, order_date DATETIME NOT NULL, expected_date DATETIME NOT NULL, part_time_code SMALLINT NOT NULL, total_amount DOUBLE PRECISION NOT NULL, booking_ref VARCHAR(255) NOT NULL, validated_on DATETIME DEFAULT NULL, invoice_number INT DEFAULT NULL, payment_method VARCHAR(255) DEFAULT NULL, payment_number INT NOT NULL, payment_ext_ref VARCHAR(255) NOT NULL, cancelled_on DATETIME DEFAULT NULL, INDEX IDX_64556E2D9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_order ADD CONSTRAINT FK_64556E2D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_order DROP FOREIGN KEY FK_64556E2D9395C3F3');
        $this->addSql('DROP TABLE booking_order');
        $this->addSql('DROP TABLE customer');
    }
}
