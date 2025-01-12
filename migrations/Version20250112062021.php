<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250112062021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3896DBBDE');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3B03A8386');
        $this->addSql('DROP INDEX IDX_F4DD61D3B03A8386 ON affectation');
        $this->addSql('DROP INDEX IDX_F4DD61D3896DBBDE ON affectation');
        $this->addSql('ALTER TABLE affectation DROP created_by_id, DROP updated_by_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F4DD61D3B03A8386 ON affectation (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F4DD61D3896DBBDE ON affectation (updated_by_id)');
    }
}
