<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229180631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_event ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE material_event ADD CONSTRAINT FK_6D49A6E971F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_6D49A6E971F7E88B ON material_event (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_event DROP FOREIGN KEY FK_6D49A6E971F7E88B');
        $this->addSql('DROP INDEX IDX_6D49A6E971F7E88B ON material_event');
        $this->addSql('ALTER TABLE material_event DROP event_id');
    }
}
