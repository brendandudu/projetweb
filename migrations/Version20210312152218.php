<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312152218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_lodging (user_id INT NOT NULL, lodging_id INT NOT NULL, INDEX IDX_D5380620A76ED395 (user_id), INDEX IDX_D538062087335AF1 (lodging_id), PRIMARY KEY(user_id, lodging_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_lodging ADD CONSTRAINT FK_D5380620A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_lodging ADD CONSTRAINT FK_D538062087335AF1 FOREIGN KEY (lodging_id) REFERENCES lodging (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lodging DROP FOREIGN KEY FK_8D35182AA76ED395');
        $this->addSql('DROP INDEX IDX_8D35182AA76ED395 ON lodging');
        $this->addSql('ALTER TABLE lodging CHANGE user_id owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE lodging ADD CONSTRAINT FK_8D35182A7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D35182A7E3C61F9 ON lodging (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_lodging');
        $this->addSql('ALTER TABLE lodging DROP FOREIGN KEY FK_8D35182A7E3C61F9');
        $this->addSql('DROP INDEX IDX_8D35182A7E3C61F9 ON lodging');
        $this->addSql('ALTER TABLE lodging CHANGE owner_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE lodging ADD CONSTRAINT FK_8D35182AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D35182AA76ED395 ON lodging (user_id)');
    }
}
