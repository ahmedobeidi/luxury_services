<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250213084951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_offer ADD recruiter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id)');
        $this->addSql('CREATE INDEX IDX_288A3A4E156BE243 ON job_offer (recruiter_id)');
        $this->addSql('ALTER TABLE recruiter ADD user_id INT NOT NULL, ADD contact_name VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP company, CHANGE name company_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE recruiter ADD CONSTRAINT FK_DE8633D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE8633D8A76ED395 ON recruiter (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recruiter DROP FOREIGN KEY FK_DE8633D8A76ED395');
        $this->addSql('DROP INDEX UNIQ_DE8633D8A76ED395 ON recruiter');
        $this->addSql('ALTER TABLE recruiter ADD company VARCHAR(255) DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, DROP user_id, DROP company_name, DROP contact_name, DROP created_at');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E156BE243');
        $this->addSql('DROP INDEX IDX_288A3A4E156BE243 ON job_offer');
        $this->addSql('ALTER TABLE job_offer DROP recruiter_id');
    }
}
