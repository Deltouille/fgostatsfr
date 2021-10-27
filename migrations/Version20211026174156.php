<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026174156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE servant_info_servant (servant_info_id INT NOT NULL, servant_id INT NOT NULL, INDEX IDX_1959F9F76689AFA3 (servant_info_id), INDEX IDX_1959F9F7113ADFC0 (servant_id), PRIMARY KEY(servant_info_id, servant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE servant_info_servant ADD CONSTRAINT FK_1959F9F76689AFA3 FOREIGN KEY (servant_info_id) REFERENCES servant_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE servant_info_servant ADD CONSTRAINT FK_1959F9F7113ADFC0 FOREIGN KEY (servant_id) REFERENCES servant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE servant_info_servant');
    }
}
