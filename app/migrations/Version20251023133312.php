<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251023133312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE route_user DROP FOREIGN KEY FK_20D6D7CC34ECB4E6');
        $this->addSql('ALTER TABLE route_user DROP FOREIGN KEY FK_20D6D7CCA76ED395');
        $this->addSql('DROP TABLE route_user');
        $this->addSql('ALTER TABLE route CHANGE departure_time departure_time TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE route_user (route_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_20D6D7CCA76ED395 (user_id), INDEX IDX_20D6D7CC34ECB4E6 (route_id), PRIMARY KEY(route_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE route_user ADD CONSTRAINT FK_20D6D7CC34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE route_user ADD CONSTRAINT FK_20D6D7CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE route CHANGE departure_time departure_time DATETIME NOT NULL');
    }
}
