<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220123125120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique_image ADD craft_essence_id INT DEFAULT NULL, ADD servant_id INT DEFAULT NULL, DROP image');
        $this->addSql('ALTER TABLE historique_image ADD CONSTRAINT FK_8BBDDE2C5D035C19 FOREIGN KEY (craft_essence_id) REFERENCES craft_essence (id)');
        $this->addSql('ALTER TABLE historique_image ADD CONSTRAINT FK_8BBDDE2C113ADFC0 FOREIGN KEY (servant_id) REFERENCES servant (id)');
        $this->addSql('CREATE INDEX IDX_8BBDDE2C5D035C19 ON historique_image (craft_essence_id)');
        $this->addSql('CREATE INDEX IDX_8BBDDE2C113ADFC0 ON historique_image (servant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique_image DROP FOREIGN KEY FK_8BBDDE2C5D035C19');
        $this->addSql('ALTER TABLE historique_image DROP FOREIGN KEY FK_8BBDDE2C113ADFC0');
        $this->addSql('DROP INDEX IDX_8BBDDE2C5D035C19 ON historique_image');
        $this->addSql('DROP INDEX IDX_8BBDDE2C113ADFC0 ON historique_image');
        $this->addSql('ALTER TABLE historique_image ADD image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP craft_essence_id, DROP servant_id');
    }
}
