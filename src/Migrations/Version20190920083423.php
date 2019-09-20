<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920083423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE closing_period (id INT AUTO_INCREMENT NOT NULL, from_dat0 DATE NOT NULL, to_datex DATE DEFAULT NULL, holiday TINYINT(1) NOT NULL, day_of_week SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, iso2code VARCHAR(2) NOT NULL, country_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE param (id INT AUTO_INCREMENT NOT NULL, ref_code VARCHAR(20) NOT NULL, label VARCHAR(255) NOT NULL, exe_num VARCHAR(4) NOT NULL, month_num VARCHAR(2) NOT NULL, day_num VARCHAR(2) NOT NULL, number INT NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pricing (id INT AUTO_INCREMENT NOT NULL, term_date DATE DEFAULT NULL, discounted TINYINT(1) NOT NULL, group_code VARCHAR(2) DEFAULT NULL, part_time_code SMALLINT NOT NULL, age_min SMALLINT NOT NULL, age_max SMALLINT NOT NULL, price DOUBLE PRECISION NOT NULL, ttc_amount DOUBLE PRECISION NOT NULL, currency VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, starting_date DATE NOT NULL, day_of_week SMALLINT NOT NULL, part_time_code SMALLINT NOT NULL, opening_time TIME NOT NULL, last_entry_time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE closing_period');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE param');
        $this->addSql('DROP TABLE pricing');
        $this->addSql('DROP TABLE schedule');
    }
}
