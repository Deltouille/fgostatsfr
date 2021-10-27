<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026192910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servant_info ADD user_id INT NOT NULL, CHANGE servant_id_id servant_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE servant_info ADD CONSTRAINT FK_7F722EF0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7F722EF0A76ED395 ON servant_info (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servant_info DROP FOREIGN KEY FK_7F722EF0A76ED395');
        $this->addSql('DROP INDEX IDX_7F722EF0A76ED395 ON servant_info');
        $this->addSql('ALTER TABLE servant_info DROP user_id, CHANGE servant_id_id servant_id_id INT NOT NULL');
    }
}
