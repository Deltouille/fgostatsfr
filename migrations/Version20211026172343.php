<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026172343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE servant_info (id INT AUTO_INCREMENT NOT NULL, niveau_servant INT DEFAULT NULL, niveau_skill1 INT DEFAULT NULL, niveau_skill2 INT DEFAULT NULL, niveau_skill3 INT DEFAULT NULL, niveau_bond INT DEFAULT NULL, niveau_np INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servant_info_user (servant_info_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_27BDF7056689AFA3 (servant_info_id), INDEX IDX_27BDF705A76ED395 (user_id), PRIMARY KEY(servant_info_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE servant_info_user ADD CONSTRAINT FK_27BDF7056689AFA3 FOREIGN KEY (servant_info_id) REFERENCES servant_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE servant_info_user ADD CONSTRAINT FK_27BDF705A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_servant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servant_info_user DROP FOREIGN KEY FK_27BDF7056689AFA3');
        $this->addSql('CREATE TABLE user_servant (user_id INT NOT NULL, servant_id INT NOT NULL, INDEX IDX_689D8BDFA76ED395 (user_id), INDEX IDX_689D8BDF113ADFC0 (servant_id), PRIMARY KEY(user_id, servant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_servant ADD CONSTRAINT FK_689D8BDF113ADFC0 FOREIGN KEY (servant_id) REFERENCES servant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_servant ADD CONSTRAINT FK_689D8BDFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE servant_info');
        $this->addSql('DROP TABLE servant_info_user');
    }
}
