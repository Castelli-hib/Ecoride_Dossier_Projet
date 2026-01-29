<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251216084541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la colonne created_at dans avis avec datetime_immutable et valeur par défaut pour les lignes existantes';
    }

    public function up(Schema $schema): void
    {
        // Ajout de created_at en s'assurant que les lignes existantes ont une valeur
        $this->addSql(
            "ALTER TABLE avis ADD created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)'"
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE avis DROP created_at');
    }
}
