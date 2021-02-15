<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215140115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /*$this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEC86F3B2F');
        $this->addSql('DROP INDEX IDX_E00CEDDEC86F3B2F ON booking');*/
        $this->addSql('ALTER TABLE booking ADD begins_at DATE NOT NULL, ADD ends_at DATE NOT NULL, DROP week_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD week_id INT NOT NULL, DROP begins_at, DROP ends_at');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEC86F3B2F ON booking (week_id)');
    }
}
