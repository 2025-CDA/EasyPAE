<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251017062720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, siret VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_member (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, company_id INT DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_4D7B9E0DA76ED395 (user_id), INDEX IDX_4D7B9E0D979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_form (id INT AUTO_INCREMENT NOT NULL, intern_member_id INT DEFAULT NULL, info_form_intern_id INT DEFAULT NULL, info_form_organization_id INT DEFAULT NULL, info_form_company_id INT DEFAULT NULL, company_id INT DEFAULT NULL, organization_id INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BE32FC156817849 (intern_member_id), UNIQUE INDEX UNIQ_BE32FC1DAAC2B3C (info_form_intern_id), UNIQUE INDEX UNIQ_BE32FC1DBB3C91D (info_form_organization_id), UNIQUE INDEX UNIQ_BE32FC17470E03B (info_form_company_id), INDEX IDX_BE32FC1979B1AD6 (company_id), INDEX IDX_BE32FC132C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_form_company (id INT AUTO_INCREMENT NOT NULL, fax VARCHAR(255) DEFAULT NULL, activity VARCHAR(255) DEFAULT NULL, activity_description LONGTEXT DEFAULT NULL, stamp VARCHAR(255) DEFAULT NULL, legal_representative_gender VARCHAR(255) DEFAULT NULL, legal_representative_last_name VARCHAR(255) DEFAULT NULL, legal_representative_first_name VARCHAR(255) DEFAULT NULL, legal_representative_signature VARCHAR(255) DEFAULT NULL, legal_representative_email VARCHAR(255) DEFAULT NULL, interview_start_date_time DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', interview_end_date_time DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', agree_terms TINYINT(1) DEFAULT NULL, work_location VARCHAR(255) DEFAULT NULL, tutor_gender VARCHAR(255) DEFAULT NULL, tutor_first_name VARCHAR(255) DEFAULT NULL, tutor_last_name VARCHAR(255) DEFAULT NULL, tutor_email VARCHAR(255) DEFAULT NULL, tutor_phone_number VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_form_company_calendar_row (id INT AUTO_INCREMENT NOT NULL, info_form_company_id INT DEFAULT NULL, day VARCHAR(255) DEFAULT NULL, start_morning TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', end_morning TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', start_afternoon TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', end_afternoon TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', work_location VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A9AA14DE7470E03B (info_form_company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_form_intern (id INT AUTO_INCREMENT NOT NULL, info_form_intern_company_id INT DEFAULT NULL, date_start DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', date_end DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', gender VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_78AFA1678F0DCFE2 (info_form_intern_company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_form_intern_company (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, contact_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_form_organization (id INT AUTO_INCREMENT NOT NULL, validation_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', signature VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intern_member (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_31CB5C38A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intern_member_training_session (intern_member_id INT NOT NULL, training_session_id INT NOT NULL, INDEX IDX_7873472156817849 (intern_member_id), INDEX IDX_78734721DB8156B9 (training_session_id), PRIMARY KEY(intern_member_id, training_session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, siret VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization_member (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, organization_id INT DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_756A2A8DA76ED395 (user_id), INDEX IDX_756A2A8D32C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization_member_training_session (organization_member_id INT NOT NULL, training_session_id INT NOT NULL, INDEX IDX_A4F87C184DA009F8 (organization_member_id), INDEX IDX_A4F87C18DB8156B9 (training_session_id), PRIMARY KEY(organization_member_id, training_session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_session (id INT AUTO_INCREMENT NOT NULL, training_id INT DEFAULT NULL, offer_number VARCHAR(255) DEFAULT NULL, internship_period_start DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', internship_period_end DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', training_period_start DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', training_period_end DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D7A45DABEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, login VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', role VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_member ADD CONSTRAINT FK_4D7B9E0DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE company_member ADD CONSTRAINT FK_4D7B9E0D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE info_form ADD CONSTRAINT FK_BE32FC156817849 FOREIGN KEY (intern_member_id) REFERENCES intern_member (id)');
        $this->addSql('ALTER TABLE info_form ADD CONSTRAINT FK_BE32FC1DAAC2B3C FOREIGN KEY (info_form_intern_id) REFERENCES info_form_intern (id)');
        $this->addSql('ALTER TABLE info_form ADD CONSTRAINT FK_BE32FC1DBB3C91D FOREIGN KEY (info_form_organization_id) REFERENCES info_form_organization (id)');
        $this->addSql('ALTER TABLE info_form ADD CONSTRAINT FK_BE32FC17470E03B FOREIGN KEY (info_form_company_id) REFERENCES info_form_company (id)');
        $this->addSql('ALTER TABLE info_form ADD CONSTRAINT FK_BE32FC1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE info_form ADD CONSTRAINT FK_BE32FC132C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE info_form_company_calendar_row ADD CONSTRAINT FK_A9AA14DE7470E03B FOREIGN KEY (info_form_company_id) REFERENCES info_form_company (id)');
        $this->addSql('ALTER TABLE info_form_intern ADD CONSTRAINT FK_78AFA1678F0DCFE2 FOREIGN KEY (info_form_intern_company_id) REFERENCES info_form_intern_company (id)');
        $this->addSql('ALTER TABLE intern_member ADD CONSTRAINT FK_31CB5C38A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE intern_member_training_session ADD CONSTRAINT FK_7873472156817849 FOREIGN KEY (intern_member_id) REFERENCES intern_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intern_member_training_session ADD CONSTRAINT FK_78734721DB8156B9 FOREIGN KEY (training_session_id) REFERENCES training_session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_member ADD CONSTRAINT FK_756A2A8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE organization_member ADD CONSTRAINT FK_756A2A8D32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE organization_member_training_session ADD CONSTRAINT FK_A4F87C184DA009F8 FOREIGN KEY (organization_member_id) REFERENCES organization_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_member_training_session ADD CONSTRAINT FK_A4F87C18DB8156B9 FOREIGN KEY (training_session_id) REFERENCES training_session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_session ADD CONSTRAINT FK_D7A45DABEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_member DROP FOREIGN KEY FK_4D7B9E0DA76ED395');
        $this->addSql('ALTER TABLE company_member DROP FOREIGN KEY FK_4D7B9E0D979B1AD6');
        $this->addSql('ALTER TABLE info_form DROP FOREIGN KEY FK_BE32FC156817849');
        $this->addSql('ALTER TABLE info_form DROP FOREIGN KEY FK_BE32FC1DAAC2B3C');
        $this->addSql('ALTER TABLE info_form DROP FOREIGN KEY FK_BE32FC1DBB3C91D');
        $this->addSql('ALTER TABLE info_form DROP FOREIGN KEY FK_BE32FC17470E03B');
        $this->addSql('ALTER TABLE info_form DROP FOREIGN KEY FK_BE32FC1979B1AD6');
        $this->addSql('ALTER TABLE info_form DROP FOREIGN KEY FK_BE32FC132C8A3DE');
        $this->addSql('ALTER TABLE info_form_company_calendar_row DROP FOREIGN KEY FK_A9AA14DE7470E03B');
        $this->addSql('ALTER TABLE info_form_intern DROP FOREIGN KEY FK_78AFA1678F0DCFE2');
        $this->addSql('ALTER TABLE intern_member DROP FOREIGN KEY FK_31CB5C38A76ED395');
        $this->addSql('ALTER TABLE intern_member_training_session DROP FOREIGN KEY FK_7873472156817849');
        $this->addSql('ALTER TABLE intern_member_training_session DROP FOREIGN KEY FK_78734721DB8156B9');
        $this->addSql('ALTER TABLE organization_member DROP FOREIGN KEY FK_756A2A8DA76ED395');
        $this->addSql('ALTER TABLE organization_member DROP FOREIGN KEY FK_756A2A8D32C8A3DE');
        $this->addSql('ALTER TABLE organization_member_training_session DROP FOREIGN KEY FK_A4F87C184DA009F8');
        $this->addSql('ALTER TABLE organization_member_training_session DROP FOREIGN KEY FK_A4F87C18DB8156B9');
        $this->addSql('ALTER TABLE training_session DROP FOREIGN KEY FK_D7A45DABEFD98D1');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_member');
        $this->addSql('DROP TABLE info_form');
        $this->addSql('DROP TABLE info_form_company');
        $this->addSql('DROP TABLE info_form_company_calendar_row');
        $this->addSql('DROP TABLE info_form_intern');
        $this->addSql('DROP TABLE info_form_intern_company');
        $this->addSql('DROP TABLE info_form_organization');
        $this->addSql('DROP TABLE intern_member');
        $this->addSql('DROP TABLE intern_member_training_session');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE organization_member');
        $this->addSql('DROP TABLE organization_member_training_session');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_session');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
