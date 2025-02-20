<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220151533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_application DROP INDEX UNIQ_C737C6883481D195, ADD INDEX IDX_C737C6883481D195 (job_offer_id)');
        $this->addSql('ALTER TABLE job_application DROP FOREIGN KEY FK_C737C688A76ED395');
        $this->addSql('DROP INDEX UNIQ_C737C688A76ED395 ON job_application');
        $this->addSql('ALTER TABLE job_application CHANGE user_id applicant_id INT NOT NULL');
        $this->addSql('ALTER TABLE job_application ADD CONSTRAINT FK_C737C68897139001 FOREIGN KEY (applicant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C737C68897139001 ON job_application (applicant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_application DROP INDEX IDX_C737C6883481D195, ADD UNIQUE INDEX UNIQ_C737C6883481D195 (job_offer_id)');
        $this->addSql('ALTER TABLE job_application DROP FOREIGN KEY FK_C737C68897139001');
        $this->addSql('DROP INDEX IDX_C737C68897139001 ON job_application');
        $this->addSql('ALTER TABLE job_application CHANGE applicant_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE job_application ADD CONSTRAINT FK_C737C688A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C737C688A76ED395 ON job_application (user_id)');
    }
}
