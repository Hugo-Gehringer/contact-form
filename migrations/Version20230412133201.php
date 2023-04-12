<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412133201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_detail (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(40) NOT NULL, lastname VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_form (id INT AUTO_INCREMENT NOT NULL, contact_detail_id INT NOT NULL, email VARCHAR(180) NOT NULL, question LONGTEXT NOT NULL, is_checked TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_7A777FB0B62120C0 (contact_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, contact_detail_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649B62120C0 (contact_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_form ADD CONSTRAINT FK_7A777FB0B62120C0 FOREIGN KEY (contact_detail_id) REFERENCES contact_detail (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B62120C0 FOREIGN KEY (contact_detail_id) REFERENCES contact_detail (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_form DROP FOREIGN KEY FK_7A777FB0B62120C0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B62120C0');
        $this->addSql('DROP TABLE contact_detail');
        $this->addSql('DROP TABLE contact_form');
        $this->addSql('DROP TABLE user');
    }
}
