<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251021212534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_form ADD training_session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE info_form ADD CONSTRAINT FK_BE32FC1DB8156B9 FOREIGN KEY (training_session_id) REFERENCES training_session (id)');
        $this->addSql('CREATE INDEX IDX_BE32FC1DB8156B9 ON info_form (training_session_id)');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_form DROP FOREIGN KEY FK_BE32FC1DB8156B9');
        $this->addSql('DROP INDEX IDX_BE32FC1DB8156B9 ON info_form');
        $this->addSql('ALTER TABLE info_form DROP training_session_id');
        $this->addSql('ALTER TABLE user DROP avatar');
    }
}
