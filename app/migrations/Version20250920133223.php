<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250920133223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649197E709F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649545317D1');
        $this->addSql('DROP INDEX IDX_8D93D649545317D1 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649197E709F ON user');
        $this->addSql('ALTER TABLE user ADD street VARCHAR(255) DEFAULT NULL, ADD address_complement VARCHAR(255) DEFAULT NULL, ADD postal_code VARCHAR(10) DEFAULT NULL, ADD city VARCHAR(100) DEFAULT NULL, DROP avis_id, DROP vehicle_id, DROP adress, DROP role, DROP credit, CHANGE email email VARCHAR(100) NOT NULL, CHANGE username username VARCHAR(50) NOT NULL, CHANGE firstname firstname VARCHAR(50) NOT NULL, CHANGE lastname lastname VARCHAR(50) NOT NULL, CHANGE phone_number phone_number VARCHAR(20) DEFAULT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD avis_id INT DEFAULT NULL, ADD vehicle_id INT DEFAULT NULL, ADD adress VARCHAR(255) NOT NULL, ADD role VARCHAR(50) NOT NULL, ADD credit INT DEFAULT 0 NOT NULL, DROP street, DROP address_complement, DROP postal_code, DROP city, CHANGE username username VARCHAR(255) NOT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE phone_number phone_number INT DEFAULT NULL, CHANGE is_verified is_verified TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649197E709F FOREIGN KEY (avis_id) REFERENCES avis (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649545317D1 ON user (vehicle_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649197E709F ON user (avis_id)');
    }
}
