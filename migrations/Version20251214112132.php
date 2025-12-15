<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251214112132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, user_rated_id INT NOT NULL, user_rater_id INT NOT NULL, route_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, notation INT NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8F91ABF0989D9B62 (slug), INDEX IDX_8F91ABF0AA3E2149 (user_rated_id), INDEX IDX_8F91ABF0DF4C290A (user_rater_id), INDEX IDX_8F91ABF034ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(255) NOT NULL, motorization VARCHAR(255) NOT NULL, number_place INT NOT NULL, category VARCHAR(255) NOT NULL, air_conditioning TINYINT(1) NOT NULL, luggage_rack TINYINT(1) NOT NULL, gps TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, sujet VARCHAR(150) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_read TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, type VARCHAR(30) NOT NULL, description VARCHAR(255) DEFAULT NULL, balance_after NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_1CC16EFEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preferences (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, animal TINYINT(1) NOT NULL, smoker TINYINT(1) NOT NULL, music TINYINT(1) NOT NULL, disabled_equipment TINYINT(1) NOT NULL, trailer TINYINT(1) NOT NULL, usb_charger TINYINT(1) NOT NULL, tablet TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_E931A6F5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, passager_id INT NOT NULL, route_id INT NOT NULL, date_reservation DATETIME NOT NULL, is_confirmed TINYINT(1) NOT NULL, INDEX IDX_42C8495571A51189 (passager_id), INDEX IDX_42C8495534ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, departure_town VARCHAR(255) NOT NULL, arrival_town VARCHAR(255) NOT NULL, departure_day DATE NOT NULL, departure_time TIME NOT NULL, travel_time INT NOT NULL, correspondance TINYINT(1) NOT NULL, correspondance_detail VARCHAR(255) DEFAULT NULL, INDEX IDX_2C42079A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, address_complement VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(10) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, reset_token VARCHAR(64) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, user_vehicle_id INT NOT NULL, brand_vehicle_id INT DEFAULT NULL, year VARCHAR(60) NOT NULL, status VARCHAR(255) NOT NULL, kilometer INT NOT NULL, is_actif TINYINT(1) NOT NULL, INDEX IDX_1B80E486F334D13D (user_vehicle_id), INDEX IDX_1B80E4866E8C310F (brand_vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0AA3E2149 FOREIGN KEY (user_rated_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0DF4C290A FOREIGN KEY (user_rater_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF034ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE preferences ADD CONSTRAINT FK_E931A6F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495571A51189 FOREIGN KEY (passager_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495534ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486F334D13D FOREIGN KEY (user_vehicle_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4866E8C310F FOREIGN KEY (brand_vehicle_id) REFERENCES brand (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0AA3E2149');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0DF4C290A');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF034ECB4E6');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFEA76ED395');
        $this->addSql('ALTER TABLE preferences DROP FOREIGN KEY FK_E931A6F5A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495571A51189');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495534ECB4E6');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079A76ED395');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486F334D13D');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4866E8C310F');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE preferences');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
