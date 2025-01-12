<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250112072353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cercles ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE cercles ADD CONSTRAINT FK_45C1718D98260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('CREATE INDEX IDX_45C1718D98260155 ON cercles (region_id)');
        $this->addSql('ALTER TABLE communes ADD cercle_id INT NOT NULL');
        $this->addSql('ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A527413AB9 FOREIGN KEY (cercle_id) REFERENCES cercles (id)');
        $this->addSql('CREATE INDEX IDX_5C5EE2A527413AB9 ON communes (cercle_id)');
        $this->addSql('ALTER TABLE quartiers ADD commune_id INT NOT NULL');
        $this->addSql('ALTER TABLE quartiers ADD CONSTRAINT FK_5E2F7BE8131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id)');
        $this->addSql('CREATE INDEX IDX_5E2F7BE8131A4F72 ON quartiers (commune_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718D98260155');
        $this->addSql('DROP INDEX IDX_45C1718D98260155 ON cercles');
        $this->addSql('ALTER TABLE cercles DROP region_id');
        $this->addSql('ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A527413AB9');
        $this->addSql('DROP INDEX IDX_5C5EE2A527413AB9 ON communes');
        $this->addSql('ALTER TABLE communes DROP cercle_id');
        $this->addSql('ALTER TABLE quartiers DROP FOREIGN KEY FK_5E2F7BE8131A4F72');
        $this->addSql('DROP INDEX IDX_5E2F7BE8131A4F72 ON quartiers');
        $this->addSql('ALTER TABLE quartiers DROP commune_id');
    }
}
