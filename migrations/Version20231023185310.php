<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023185310 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C08793562BB7AEE');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_5373C966A4D60759 (libelle), UNIQUE INDEX UNIQ_5373C96677153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE handicap (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_35FD7ABBA4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('DROP TABLE programme');
        $this->addSql('ALTER TABLE ticket_location ADD nationalite_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL, ADD handicap_id INT DEFAULT NULL, ADD sex VARCHAR(1) NOT NULL, ADD age INT NOT NULL, ADD telephone VARCHAR(50) DEFAULT NULL, ADD village VARCHAR(100) DEFAULT NULL, ADD quartier VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket_location ADD CONSTRAINT FK_DBF7754A1B063272 FOREIGN KEY (nationalite_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE ticket_location ADD CONSTRAINT FK_DBF7754A6BF700BD FOREIGN KEY (status_id) REFERENCES status_user (id)');
        $this->addSql('ALTER TABLE ticket_location ADD CONSTRAINT FK_DBF7754AB996CB29 FOREIGN KEY (handicap_id) REFERENCES handicap (id)');
        $this->addSql('CREATE INDEX IDX_DBF7754A1B063272 ON ticket_location (nationalite_id)');
        $this->addSql('CREATE INDEX IDX_DBF7754A6BF700BD ON ticket_location (status_id)');
        $this->addSql('CREATE INDEX IDX_DBF7754AB996CB29 ON ticket_location (handicap_id)');
        $this->addSql('DROP INDEX IDX_C08793562BB7AEE ON user_infos');
        $this->addSql('ALTER TABLE user_infos ADD handicap_id INT DEFAULT NULL, ADD age INT NOT NULL, ADD quartier VARCHAR(100) DEFAULT NULL, CHANGE programme_id nationalite_id INT DEFAULT NULL, CHANGE fonction village VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C0879351B063272 FOREIGN KEY (nationalite_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C087935B996CB29 FOREIGN KEY (handicap_id) REFERENCES handicap (id)');
        $this->addSql('CREATE INDEX IDX_C0879351B063272 ON user_infos (nationalite_id)');
        $this->addSql('CREATE INDEX IDX_C087935B996CB29 ON user_infos (handicap_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket_location DROP FOREIGN KEY FK_DBF7754A1B063272');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C0879351B063272');
        $this->addSql('ALTER TABLE ticket_location DROP FOREIGN KEY FK_DBF7754AB996CB29');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C087935B996CB29');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_3DDCB9FFA4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE handicap');
        $this->addSql('ALTER TABLE ticket_location DROP FOREIGN KEY FK_DBF7754A6BF700BD');
        $this->addSql('DROP INDEX IDX_DBF7754A1B063272 ON ticket_location');
        $this->addSql('DROP INDEX IDX_DBF7754A6BF700BD ON ticket_location');
        $this->addSql('DROP INDEX IDX_DBF7754AB996CB29 ON ticket_location');
        $this->addSql('ALTER TABLE ticket_location DROP nationalite_id, DROP status_id, DROP handicap_id, DROP sex, DROP age, DROP telephone, DROP village, DROP quartier');
        $this->addSql('DROP INDEX IDX_C0879351B063272 ON user_infos');
        $this->addSql('DROP INDEX IDX_C087935B996CB29 ON user_infos');
        $this->addSql('ALTER TABLE user_infos ADD programme_id INT DEFAULT NULL, ADD fonction VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP nationalite_id, DROP handicap_id, DROP age, DROP village, DROP quartier');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C08793562BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('CREATE INDEX IDX_C08793562BB7AEE ON user_infos (programme_id)');
    }
}
