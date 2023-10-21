<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019162312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, type_location_id INT NOT NULL, libelle VARCHAR(50) NOT NULL, code VARCHAR(10) NOT NULL, INDEX IDX_5E9E89CB727ACA70 (parent_id), INDEX IDX_5E9E89CB4D54F61F (type_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE status_user (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE ticket_location (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, location_id INT NOT NULL, UNIQUE INDEX UNIQ_DBF7754A700047D2 (ticket_id), INDEX IDX_DBF7754A64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE type_location (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE user_infos (id INT AUTO_INCREMENT NOT NULL, programme_id INT DEFAULT NULL, status_id INT DEFAULT NULL, commune_id INT NOT NULL, user_id INT NOT NULL, sex VARCHAR(1) NOT NULL, fonction VARCHAR(100) DEFAULT NULL, telephone VARCHAR(50) DEFAULT NULL, INDEX IDX_C08793562BB7AEE (programme_id), INDEX IDX_C0879356BF700BD (status_id), INDEX IDX_C087935131A4F72 (commune_id), UNIQUE INDEX UNIQ_C087935A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB727ACA70 FOREIGN KEY (parent_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB4D54F61F FOREIGN KEY (type_location_id) REFERENCES type_location (id)');
        $this->addSql('ALTER TABLE ticket_location ADD CONSTRAINT FK_DBF7754A700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id)');
        $this->addSql('ALTER TABLE ticket_location ADD CONSTRAINT FK_DBF7754A64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C08793562BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C0879356BF700BD FOREIGN KEY (status_id) REFERENCES status_user (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C087935131A4F72 FOREIGN KEY (commune_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C087935A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id)');
        $this->addSql('ALTER TABLE agent_activity CHANGE agent_name agent_name VARCHAR(255) DEFAULT NULL, CHANGE customer_name customer_name VARCHAR(255) DEFAULT NULL, CHANGE thread_type thread_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE announcement CHANGE tag_color tag_color VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE recaptcha CHANGE site_key site_key VARCHAR(255) DEFAULT NULL, CHANGE secret_key secret_key VARCHAR(255) DEFAULT NULL, CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_article CHANGE slug slug VARCHAR(255) DEFAULT NULL, CHANGE keywords keywords VARCHAR(255) DEFAULT NULL, CHANGE viewed viewed INT DEFAULT NULL, CHANGE stared stared INT DEFAULT NULL, CHANGE meta_title meta_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_article_feedback CHANGE article_id article_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_article_view_log CHANGE user_id user_id INT DEFAULT NULL, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_email_templates CHANGE user_id user_id INT DEFAULT NULL, CHANGE template_type template_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_prepared_responses CHANGE user_id user_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT \'public\'');
        $this->addSql('ALTER TABLE uv_saved_filters CHANGE user_id user_id INT DEFAULT NULL, CHANGE route route VARCHAR(190) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_saved_replies CHANGE user_id user_id INT DEFAULT NULL, CHANGE subject subject VARCHAR(255) DEFAULT NULL, CHANGE template_id template_id INT DEFAULT NULL, CHANGE template_for template_for VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_solution_category CHANGE description description VARCHAR(100) DEFAULT NULL, CHANGE sorting sorting VARCHAR(255) DEFAULT \'ascending\'');
        $this->addSql('ALTER TABLE uv_solutions CHANGE solution_image solution_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_support_label CHANGE user_id user_id INT DEFAULT NULL, CHANGE color_code color_code VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_support_privilege CHANGE privileges privileges LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_support_role CHANGE description description VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_thread CHANGE ticket_id ticket_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE cc cc LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE bcc bcc LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE reply_to reply_to LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE delivery_status delivery_status VARCHAR(255) DEFAULT NULL, CHANGE agent_viewed_at agent_viewed_at DATETIME DEFAULT NULL, CHANGE customer_viewed_at customer_viewed_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket CHANGE status_id status_id INT DEFAULT NULL, CHANGE priority_id priority_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE agent_id agent_id INT DEFAULT NULL, CHANGE group_id group_id INT DEFAULT NULL, CHANGE mailbox_email mailbox_email VARCHAR(191) DEFAULT NULL, CHANGE subGroup_id subGroup_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_attachments CHANGE thread_id thread_id INT DEFAULT NULL, CHANGE content_type content_type VARCHAR(255) DEFAULT NULL, CHANGE size size INT DEFAULT NULL, CHANGE content_id content_id VARCHAR(255) DEFAULT NULL, CHANGE file_system file_system VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_priority CHANGE color_code color_code VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_rating CHANGE ticket_id ticket_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_status CHANGE color_code color_code VARCHAR(191) DEFAULT NULL, CHANGE sort_order sort_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_user CHANGE email email VARCHAR(191) DEFAULT NULL, CHANGE proxy_id proxy_id VARCHAR(191) DEFAULT NULL, CHANGE password password VARCHAR(191) DEFAULT NULL, CHANGE last_name last_name VARCHAR(191) DEFAULT NULL, CHANGE verification_code verification_code VARCHAR(191) DEFAULT NULL, CHANGE timezone timezone VARCHAR(191) DEFAULT NULL, CHANGE timeformat timeformat VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_user_instance CHANGE user_id user_id INT DEFAULT NULL, CHANGE skype_id skype_id VARCHAR(191) DEFAULT NULL, CHANGE contact_number contact_number VARCHAR(191) DEFAULT NULL, CHANGE designation designation VARCHAR(191) DEFAULT NULL, CHANGE ticket_access_level ticket_access_level VARCHAR(32) DEFAULT NULL, CHANGE supportRole_id supportRole_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_website CHANGE logo logo VARCHAR(191) DEFAULT NULL, CHANGE favicon favicon VARCHAR(191) DEFAULT NULL, CHANGE timezone timezone VARCHAR(191) DEFAULT NULL, CHANGE timeformat timeformat VARCHAR(191) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_website_knowledgebase CHANGE website website INT DEFAULT NULL, CHANGE header_background_color header_background_color VARCHAR(255) DEFAULT NULL, CHANGE link_color link_color VARCHAR(255) DEFAULT NULL, CHANGE article_text_color article_text_color VARCHAR(255) DEFAULT NULL, CHANGE site_description site_description VARCHAR(1000) DEFAULT NULL, CHANGE homepage_content homepage_content VARCHAR(255) DEFAULT NULL, CHANGE header_links header_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE footer_links footer_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE banner_background_color banner_background_color VARCHAR(255) DEFAULT NULL, CHANGE link_hover_color link_hover_color VARCHAR(255) DEFAULT NULL, CHANGE login_required_to_create login_required_to_create TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_workflow CHANGE sort_order sort_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_workflow_events CHANGE workflow_id workflow_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB727ACA70');
        $this->addSql('ALTER TABLE ticket_location DROP FOREIGN KEY FK_DBF7754A64D218E');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C087935131A4F72');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C08793562BB7AEE');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C0879356BF700BD');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB4D54F61F');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE status_user');
        $this->addSql('DROP TABLE ticket_location');
        $this->addSql('DROP TABLE type_location');
        $this->addSql('DROP TABLE user_infos');
        $this->addSql('ALTER TABLE agent_activity CHANGE agent_name agent_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE customer_name customer_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE thread_type thread_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE announcement CHANGE tag_color tag_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE recaptcha CHANGE site_key site_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE secret_key secret_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE is_active is_active TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE uv_article CHANGE slug slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE keywords keywords VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE viewed viewed INT DEFAULT NULL, CHANGE stared stared INT DEFAULT NULL, CHANGE meta_title meta_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_article_feedback CHANGE article_id article_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_article_view_log CHANGE user_id user_id INT DEFAULT NULL, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_email_templates CHANGE user_id user_id INT DEFAULT NULL, CHANGE template_type template_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_prepared_responses CHANGE user_id user_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'public\'\'\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_saved_filters CHANGE user_id user_id INT DEFAULT NULL, CHANGE route route VARCHAR(190) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_saved_replies CHANGE user_id user_id INT DEFAULT NULL, CHANGE subject subject VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE template_id template_id INT DEFAULT NULL, CHANGE template_for template_for VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_solution_category CHANGE description description VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE sorting sorting VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'ascending\'\'\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_solutions CHANGE solution_image solution_image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_support_label CHANGE user_id user_id INT DEFAULT NULL, CHANGE color_code color_code VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_support_privilege CHANGE privileges privileges LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE uv_support_role CHANGE description description VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_thread CHANGE ticket_id ticket_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE cc cc LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE bcc bcc LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE reply_to reply_to LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE delivery_status delivery_status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE agent_viewed_at agent_viewed_at DATETIME DEFAULT \'NULL\', CHANGE customer_viewed_at customer_viewed_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE uv_ticket CHANGE status_id status_id INT DEFAULT NULL, CHANGE priority_id priority_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE agent_id agent_id INT DEFAULT NULL, CHANGE group_id group_id INT DEFAULT NULL, CHANGE mailbox_email mailbox_email VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE subGroup_id subGroup_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_attachments CHANGE thread_id thread_id INT DEFAULT NULL, CHANGE content_type content_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE size size INT DEFAULT NULL, CHANGE content_id content_id VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE file_system file_system VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_ticket_priority CHANGE color_code color_code VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_ticket_rating CHANGE ticket_id ticket_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_ticket_status CHANGE color_code color_code VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE sort_order sort_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_user CHANGE email email VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE proxy_id proxy_id VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE verification_code verification_code VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE timezone timezone VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE timeformat timeformat VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_user_instance CHANGE user_id user_id INT DEFAULT NULL, CHANGE skype_id skype_id VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE contact_number contact_number VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE designation designation VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE ticket_access_level ticket_access_level VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE supportRole_id supportRole_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_website CHANGE logo logo VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE favicon favicon VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE timezone timezone VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE timeformat timeformat VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE uv_website_knowledgebase CHANGE website website INT DEFAULT NULL, CHANGE header_background_color header_background_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE link_color link_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE article_text_color article_text_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE site_description site_description VARCHAR(1000) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE homepage_content homepage_content VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE header_links header_links LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE footer_links footer_links LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE banner_background_color banner_background_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE link_hover_color link_hover_color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE login_required_to_create login_required_to_create TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE uv_workflow CHANGE sort_order sort_order INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uv_workflow_events CHANGE workflow_id workflow_id INT DEFAULT NULL');
    }
}
