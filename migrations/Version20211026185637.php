<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026185637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE servant_info_servant');
        $this->addSql('ALTER TABLE servant_info ADD servant_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE servant_info ADD CONSTRAINT FK_7F722EF037425303 FOREIGN KEY (servant_id_id) REFERENCES servant (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7F722EF037425303 ON servant_info (servant_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE servant_info_servant (servant_info_id INT NOT NULL, servant_id INT NOT NULL, INDEX IDX_1959F9F76689AFA3 (servant_info_id), INDEX IDX_1959F9F7113ADFC0 (servant_id), PRIMARY KEY(servant_info_id, servant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE servant_info_servant ADD CONSTRAINT FK_1959F9F7113ADFC0 FOREIGN KEY (servant_id) REFERENCES servant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE servant_info_servant ADD CONSTRAINT FK_1959F9F76689AFA3 FOREIGN KEY (servant_info_id) REFERENCES servant_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE servant_info DROP FOREIGN KEY FK_7F722EF037425303');
        $this->addSql('DROP INDEX UNIQ_7F722EF037425303 ON servant_info');
        $this->addSql('ALTER TABLE servant_info DROP servant_id_id');
    }
}
