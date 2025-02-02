<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250201134530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves ADD scolarite1_id INT DEFAULT NULL, ADD scolarite2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1F4C45000 FOREIGN KEY (scolarite1_id) REFERENCES scolarites1 (id)');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1E671FFEE FOREIGN KEY (scolarite2_id) REFERENCES scolarites2 (id)');
        $this->addSql('CREATE INDEX IDX_383B09B1F4C45000 ON eleves (scolarite1_id)');
        $this->addSql('CREATE INDEX IDX_383B09B1E671FFEE ON eleves (scolarite2_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1F4C45000');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1E671FFEE');
        $this->addSql('DROP INDEX IDX_383B09B1F4C45000 ON eleves');
        $this->addSql('DROP INDEX IDX_383B09B1E671FFEE ON eleves');
        $this->addSql('ALTER TABLE eleves DROP scolarite1_id, DROP scolarite2_id');
    }
}
