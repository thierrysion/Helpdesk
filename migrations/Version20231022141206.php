<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022141206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, type_location_id INT NOT NULL, libelle VARCHAR(50) NOT NULL, code VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_5E9E89CB77153098 (code), INDEX IDX_5E9E89CB727ACA70 (parent_id), INDEX IDX_5E9E89CB4D54F61F (type_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_3DDCB9FFA4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE status_user (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(15) NOT NULL, UNIQUE INDEX UNIQ_B5957BDDA4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE ticket_location (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, location_id INT NOT NULL, UNIQUE INDEX UNIQ_DBF7754A700047D2 (ticket_id), INDEX IDX_DBF7754A64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE type_location (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_9361AE37A4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE user_infos (id INT AUTO_INCREMENT NOT NULL, programme_id INT DEFAULT NULL, status_id INT DEFAULT NULL, commune_id INT NOT NULL, user_id INT NOT NULL, sex VARCHAR(1) NOT NULL, fonction VARCHAR(100) DEFAULT NULL, telephone VARCHAR(50) DEFAULT NULL, INDEX IDX_C08793562BB7AEE (programme_id), INDEX IDX_C0879356BF700BD (status_id), INDEX IDX_C087935131A4F72 (commune_id), UNIQUE INDEX UNIQ_C087935A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB727ACA70 FOREIGN KEY (parent_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB4D54F61F FOREIGN KEY (type_location_id) REFERENCES type_location (id)');
        $this->addSql('ALTER TABLE ticket_location ADD CONSTRAINT FK_DBF7754A700047D2 FOREIGN KEY (ticket_id) REFERENCES uv_ticket (id)');
        $this->addSql('ALTER TABLE ticket_location ADD CONSTRAINT FK_DBF7754A64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C08793562BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C0879356BF700BD FOREIGN KEY (status_id) REFERENCES status_user (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C087935131A4F72 FOREIGN KEY (commune_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C087935A76ED395 FOREIGN KEY (user_id) REFERENCES uv_user (id)');
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
    }
}
