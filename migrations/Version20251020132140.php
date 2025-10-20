<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251020132140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_notification DROP FOREIGN KEY FK_3F980AC89D86650F');
        $this->addSql('ALTER TABLE user_notification DROP FOREIGN KEY FK_3F980AC8B9F07BAE');
        $this->addSql('DROP INDEX IDX_3F980AC8B9F07BAE ON user_notification');
        $this->addSql('DROP INDEX IDX_3F980AC89D86650F ON user_notification');
        $this->addSql('ALTER TABLE user_notification ADD user_id INT DEFAULT NULL, ADD notification_id INT DEFAULT NULL, DROP user_id_id, DROP notification_id_id');
        $this->addSql('ALTER TABLE user_notification ADD CONSTRAINT FK_3F980AC8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_notification ADD CONSTRAINT FK_3F980AC8EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id)');
        $this->addSql('CREATE INDEX IDX_3F980AC8A76ED395 ON user_notification (user_id)');
        $this->addSql('CREATE INDEX IDX_3F980AC8EF1A9D84 ON user_notification (notification_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_notification DROP FOREIGN KEY FK_3F980AC8A76ED395');
        $this->addSql('ALTER TABLE user_notification DROP FOREIGN KEY FK_3F980AC8EF1A9D84');
        $this->addSql('DROP INDEX IDX_3F980AC8A76ED395 ON user_notification');
        $this->addSql('DROP INDEX IDX_3F980AC8EF1A9D84 ON user_notification');
        $this->addSql('ALTER TABLE user_notification ADD user_id_id INT DEFAULT NULL, ADD notification_id_id INT DEFAULT NULL, DROP user_id, DROP notification_id');
        $this->addSql('ALTER TABLE user_notification ADD CONSTRAINT FK_3F980AC89D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_notification ADD CONSTRAINT FK_3F980AC8B9F07BAE FOREIGN KEY (notification_id_id) REFERENCES notification (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3F980AC8B9F07BAE ON user_notification (notification_id_id)');
        $this->addSql('CREATE INDEX IDX_3F980AC89D86650F ON user_notification (user_id_id)');
    }
}
