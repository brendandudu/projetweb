<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127150734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD id_user_id INT NOT NULL, ADD id_lodging_id INT NOT NULL, ADD week_id INT NOT NULL, ADD booking_state_id INT NOT NULL, DROP ends_at');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE22B9DA26 FOREIGN KEY (id_lodging_id) REFERENCES lodging (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE3EECA24C FOREIGN KEY (booking_state_id) REFERENCES booking_state (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE79F37AE5 ON booking (id_user_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE22B9DA26 ON booking (id_lodging_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEC86F3B2F ON booking (week_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE3EECA24C ON booking (booking_state_id)');
        $this->addSql('ALTER TABLE lodging DROP built_in, DROP zone, DROP orientation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE79F37AE5');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE22B9DA26');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEC86F3B2F');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE3EECA24C');
        $this->addSql('DROP INDEX IDX_E00CEDDE79F37AE5 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE22B9DA26 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDEC86F3B2F ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE3EECA24C ON booking');
        $this->addSql('ALTER TABLE booking ADD ends_at DATETIME NOT NULL, DROP id_user_id, DROP id_lodging_id, DROP week_id, DROP booking_state_id');
        $this->addSql('ALTER TABLE lodging ADD built_in INT DEFAULT NULL, ADD zone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD orientation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
