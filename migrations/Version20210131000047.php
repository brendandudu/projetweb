<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210131000047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE week ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE booking ADD FOREIGN KEY (week_id) REFERENCES week (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEC86F3B2F ON booking (week_id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEC86F3B2F');
        $this->addSql('DROP INDEX IDX_E00CEDDEC86F3B2F ON booking');
        $this->addSql('ALTER TABLE week MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE week DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE week DROP id');
        $this->addSql('ALTER TABLE week ADD PRIMARY KEY (begins_at)');
    }
}
