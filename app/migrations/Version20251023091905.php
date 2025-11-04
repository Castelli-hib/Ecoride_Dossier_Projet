<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251023091905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preferences_user DROP FOREIGN KEY FK_9277F8A47CCD6FB7');
        $this->addSql('ALTER TABLE preferences_user DROP FOREIGN KEY FK_9277F8A4A76ED395');
        $this->addSql('DROP TABLE preferences_user');
        $this->addSql('ALTER TABLE preferences ADD user_id INT NOT NULL, CHANGE disbled_equipment disabled_equipment TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE preferences ADD CONSTRAINT FK_E931A6F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E931A6F5A76ED395 ON preferences (user_id)');
        $this->addSql('ALTER TABLE vehicle ADD user_vehicle_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486F334D13D FOREIGN KEY (user_vehicle_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1B80E486F334D13D ON vehicle (user_vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE preferences_user (preferences_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9277F8A4A76ED395 (user_id), INDEX IDX_9277F8A47CCD6FB7 (preferences_id), PRIMARY KEY(preferences_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE preferences_user ADD CONSTRAINT FK_9277F8A47CCD6FB7 FOREIGN KEY (preferences_id) REFERENCES preferences (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE preferences_user ADD CONSTRAINT FK_9277F8A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE preferences DROP FOREIGN KEY FK_E931A6F5A76ED395');
        $this->addSql('DROP INDEX UNIQ_E931A6F5A76ED395 ON preferences');
        $this->addSql('ALTER TABLE preferences DROP user_id, CHANGE disabled_equipment disbled_equipment TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486F334D13D');
        $this->addSql('DROP INDEX IDX_1B80E486F334D13D ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP user_vehicle_id');
    }
}
