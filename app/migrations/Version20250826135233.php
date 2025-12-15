<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250826135233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, comment LONGTEXT NOT NULL, notation INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(255) NOT NULL, motorization VARCHAR(255) NOT NULL, number_place INT NOT NULL, category VARCHAR(255) NOT NULL, air_conditioning TINYINT(1) NOT NULL, luggage_rack TINYINT(1) NOT NULL, gps TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preferences (id INT AUTO_INCREMENT NOT NULL, animal TINYINT(1) NOT NULL, smoker TINYINT(1) NOT NULL, music TINYINT(1) NOT NULL, disbled_equipment TINYINT(1) NOT NULL, trailer TINYINT(1) NOT NULL, usb_charger TINYINT(1) NOT NULL, tablet TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preferences_user (preferences_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9277F8A47CCD6FB7 (preferences_id), INDEX IDX_9277F8A4A76ED395 (user_id), PRIMARY KEY(preferences_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, departure_town VARCHAR(255) NOT NULL, arrival_town VARCHAR(255) NOT NULL, departure_day DATE NOT NULL, departure_time DATETIME NOT NULL, travel_time INT NOT NULL, correspondance TINYINT(1) NOT NULL, correspondance_detail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route_user (route_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_20D6D7CC34ECB4E6 (route_id), INDEX IDX_20D6D7CCA76ED395 (user_id), PRIMARY KEY(route_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, avis_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone_number INT NOT NULL, adress VARCHAR(255) NOT NULL, role VARCHAR(50) NOT NULL, credit INT NOT NULL, is_verified TINYINT(1) NOT NULL, INDEX IDX_8D93D649197E709F (avis_id), INDEX IDX_8D93D649545317D1 (vehicle_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, brand_vehicle_id INT DEFAULT NULL, year VARCHAR(60) NOT NULL, status VARCHAR(255) NOT NULL, kilometer INT NOT NULL, is_actif TINYINT(1) NOT NULL, INDEX IDX_1B80E4866E8C310F (brand_vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preferences_user ADD CONSTRAINT FK_9277F8A47CCD6FB7 FOREIGN KEY (preferences_id) REFERENCES preferences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE preferences_user ADD CONSTRAINT FK_9277F8A4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE route_user ADD CONSTRAINT FK_20D6D7CC34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE route_user ADD CONSTRAINT FK_20D6D7CCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649197E709F FOREIGN KEY (avis_id) REFERENCES avis (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4866E8C310F FOREIGN KEY (brand_vehicle_id) REFERENCES brand (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preferences_user DROP FOREIGN KEY FK_9277F8A47CCD6FB7');
        $this->addSql('ALTER TABLE preferences_user DROP FOREIGN KEY FK_9277F8A4A76ED395');
        $this->addSql('ALTER TABLE route_user DROP FOREIGN KEY FK_20D6D7CC34ECB4E6');
        $this->addSql('ALTER TABLE route_user DROP FOREIGN KEY FK_20D6D7CCA76ED395');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649197E709F');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649545317D1');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4866E8C310F');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE preferences');
        $this->addSql('DROP TABLE preferences_user');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE route_user');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
