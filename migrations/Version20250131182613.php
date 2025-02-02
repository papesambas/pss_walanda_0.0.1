<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250131182613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statut_eleves_niveaux (statut_eleves_id INT NOT NULL, niveaux_id INT NOT NULL, INDEX IDX_2F2650F163BA9680 (statut_eleves_id), INDEX IDX_2F2650F1AAC4B70E (niveaux_id), PRIMARY KEY(statut_eleves_id, niveaux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE statut_eleves_niveaux ADD CONSTRAINT FK_2F2650F163BA9680 FOREIGN KEY (statut_eleves_id) REFERENCES statut_eleves (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE statut_eleves_niveaux ADD CONSTRAINT FK_2F2650F1AAC4B70E FOREIGN KEY (niveaux_id) REFERENCES niveaux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleves ADD statut_eleve_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1756A7B13 FOREIGN KEY (statut_eleve_id) REFERENCES statut_eleves (id)');
        $this->addSql('CREATE INDEX IDX_383B09B1756A7B13 ON eleves (statut_eleve_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut_eleves_niveaux DROP FOREIGN KEY FK_2F2650F163BA9680');
        $this->addSql('ALTER TABLE statut_eleves_niveaux DROP FOREIGN KEY FK_2F2650F1AAC4B70E');
        $this->addSql('DROP TABLE statut_eleves_niveaux');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1756A7B13');
        $this->addSql('DROP INDEX IDX_383B09B1756A7B13 ON eleves');
        $this->addSql('ALTER TABLE eleves DROP statut_eleve_id');
    }
}
