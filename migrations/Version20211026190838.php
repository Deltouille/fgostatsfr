<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026190838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servant_info DROP INDEX UNIQ_7F722EF037425303, ADD INDEX IDX_7F722EF037425303 (servant_id_id)');
        $this->addSql('ALTER TABLE servant_info CHANGE servant_id_id servant_id_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servant_info DROP INDEX IDX_7F722EF037425303, ADD UNIQUE INDEX UNIQ_7F722EF037425303 (servant_id_id)');
        $this->addSql('ALTER TABLE servant_info CHANGE servant_id_id servant_id_id INT DEFAULT NULL');
    }
}
