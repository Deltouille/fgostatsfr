<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220123174357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique_image ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE historique_image ADD CONSTRAINT FK_8BBDDE2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8BBDDE2CA76ED395 ON historique_image (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique_image DROP FOREIGN KEY FK_8BBDDE2CA76ED395');
        $this->addSql('DROP INDEX IDX_8BBDDE2CA76ED395 ON historique_image');
        $this->addSql('ALTER TABLE historique_image DROP user_id');
    }
}
