<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225175506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, lodging_id INT NOT NULL, booking_state_id INT NOT NULL, booked_at DATETIME NOT NULL, total_pricing DOUBLE PRECISION NOT NULL, total_occupiers INT NOT NULL, note VARCHAR(255) DEFAULT NULL, begins_at DATE NOT NULL, ends_at DATE NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE87335AF1 (lodging_id), INDEX IDX_E00CEDDE3EECA24C (booking_state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_state (id INT NOT NULL, type_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lodging (id INT AUTO_INCREMENT NOT NULL, lodging_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, capacity INT NOT NULL, space INT NOT NULL, internet_available TINYINT(1) NOT NULL, current_condition VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, night_price DOUBLE PRECISION NOT NULL, picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8D35182A904223E4 (lodging_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lodging_type (id INT NOT NULL, type_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), headimg VARCHAR(255) DEFAULT NULL,sex VARCHAR(255) DEFAULT NULL,birthday DATETIME DEFAULT NULL,phone VARCHAR(255) DEFAULT NULL,country VARCHAR(255) DEFAULT NULL,city VARCHAR(255) DEFAULT NULL,avenue VARCHAR(255) DEFAULT NULL,appartment VARCHAR(255) DEFAULT NULL,code VARCHAR(255) DEFAULT NULL,address VARCHAR(255) DEFAULT NULL,PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE87335AF1 FOREIGN KEY (lodging_id) REFERENCES lodging (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE3EECA24C FOREIGN KEY (booking_state_id) REFERENCES booking_state (id)');
        $this->addSql('ALTER TABLE lodging ADD CONSTRAINT FK_8D35182A904223E4 FOREIGN KEY (lodging_type_id) REFERENCES lodging_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE3EECA24C');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE87335AF1');
        $this->addSql('ALTER TABLE lodging DROP FOREIGN KEY FK_8D35182A904223E4');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_state');
        $this->addSql('DROP TABLE lodging');
        $this->addSql('DROP TABLE lodging_type');
        $this->addSql('DROP TABLE user');
    }
}
