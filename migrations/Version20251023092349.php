<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251023092349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intern_member_training_session DROP FOREIGN KEY FK_7873472156817849');
        $this->addSql('ALTER TABLE intern_member_training_session DROP FOREIGN KEY FK_78734721DB8156B9');
        $this->addSql('DROP TABLE intern_member_training_session');
        $this->addSql('ALTER TABLE intern_member ADD training_session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intern_member ADD CONSTRAINT FK_31CB5C38DB8156B9 FOREIGN KEY (training_session_id) REFERENCES training_session (id)');
        $this->addSql('CREATE INDEX IDX_31CB5C38DB8156B9 ON intern_member (training_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intern_member_training_session (intern_member_id INT NOT NULL, training_session_id INT NOT NULL, INDEX IDX_7873472156817849 (intern_member_id), INDEX IDX_78734721DB8156B9 (training_session_id), PRIMARY KEY(intern_member_id, training_session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE intern_member_training_session ADD CONSTRAINT FK_7873472156817849 FOREIGN KEY (intern_member_id) REFERENCES intern_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intern_member_training_session ADD CONSTRAINT FK_78734721DB8156B9 FOREIGN KEY (training_session_id) REFERENCES training_session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intern_member DROP FOREIGN KEY FK_31CB5C38DB8156B9');
        $this->addSql('DROP INDEX IDX_31CB5C38DB8156B9 ON intern_member');
        $this->addSql('ALTER TABLE intern_member DROP training_session_id');
    }
}
