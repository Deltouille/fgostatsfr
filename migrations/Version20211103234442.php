<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103234442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material_info (id INT AUTO_INCREMENT NOT NULL, servant_id INT NOT NULL, material_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_9FE15C62113ADFC0 (servant_id), INDEX IDX_9FE15C62E308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material_info ADD CONSTRAINT FK_9FE15C62113ADFC0 FOREIGN KEY (servant_id) REFERENCES servant (id)');
        $this->addSql('ALTER TABLE material_info ADD CONSTRAINT FK_9FE15C62E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE material_info');
    }
}
