<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210130232940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE22B9DA26');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE79F37AE5');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEC86F3B2F');
        $this->addSql('DROP INDEX IDX_E00CEDDE22B9DA26 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE79F37AE5 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDEC86F3B2F ON booking');
        $this->addSql('ALTER TABLE booking ADD user_id INT NOT NULL, ADD lodging_id INT NOT NULL, DROP id_user_id, DROP id_lodging_id, DROP week_id, DROP begins_at');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE87335AF1 FOREIGN KEY (lodging_id) REFERENCES lodging (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEA76ED395 ON booking (user_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE87335AF1 ON booking (lodging_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE87335AF1');
        $this->addSql('DROP INDEX IDX_E00CEDDEA76ED395 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE87335AF1 ON booking');
        $this->addSql('ALTER TABLE booking ADD id_user_id INT NOT NULL, ADD id_lodging_id INT NOT NULL, ADD week_id INT NOT NULL, ADD begins_at DATETIME NOT NULL, DROP user_id, DROP lodging_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE22B9DA26 FOREIGN KEY (id_lodging_id) REFERENCES lodging (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE22B9DA26 ON booking (id_lodging_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE79F37AE5 ON booking (id_user_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEC86F3B2F ON booking (week_id)');
    }
}
