<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030101435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE craft_essence_info (id INT AUTO_INCREMENT NOT NULL, craft_essence_id INT NOT NULL, user_id INT NOT NULL, niveau_ce INT NOT NULL, is_max_limit_break TINYINT(1) NOT NULL, INDEX IDX_5B39CE055D035C19 (craft_essence_id), INDEX IDX_5B39CE05A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE craft_essence_info ADD CONSTRAINT FK_5B39CE055D035C19 FOREIGN KEY (craft_essence_id) REFERENCES craft_essence (id)');
        $this->addSql('ALTER TABLE craft_essence_info ADD CONSTRAINT FK_5B39CE05A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE craft_essence_info');
    }
}
