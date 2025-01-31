<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127124339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE redoublements1 DROP FOREIGN KEY FK_2554EDA95ECD988B');
        $this->addSql('ALTER TABLE redoublements2 DROP FOREIGN KEY FK_BC5DBC135ECD988B');
        $this->addSql('ALTER TABLE redoublements3 DROP FOREIGN KEY FK_CB5A8C855ECD988B');
        $this->addSql('ALTER TABLE scolarites3 DROP FOREIGN KEY FK_DC834A68B3E9C81');
        $this->addSql('DROP TABLE scolarites3');
        $this->addSql('ALTER TABLE eleves ADD image_name VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_2554EDA95ECD988B ON redoublements1');
        $this->addSql('ALTER TABLE redoublements1 DROP scolarite3_id');
        $this->addSql('DROP INDEX IDX_BC5DBC135ECD988B ON redoublements2');
        $this->addSql('ALTER TABLE redoublements2 DROP scolarite3_id');
        $this->addSql('DROP INDEX IDX_CB5A8C855ECD988B ON redoublements3');
        $this->addSql('ALTER TABLE redoublements3 DROP scolarite3_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scolarites3 (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, designation VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_DC834A68B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE scolarites3 ADD CONSTRAINT FK_DC834A68B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveaux (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleves DROP image_name, DROP image_size');
        $this->addSql('ALTER TABLE redoublements1 ADD scolarite3_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE redoublements1 ADD CONSTRAINT FK_2554EDA95ECD988B FOREIGN KEY (scolarite3_id) REFERENCES scolarites3 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2554EDA95ECD988B ON redoublements1 (scolarite3_id)');
        $this->addSql('ALTER TABLE redoublements2 ADD scolarite3_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE redoublements2 ADD CONSTRAINT FK_BC5DBC135ECD988B FOREIGN KEY (scolarite3_id) REFERENCES scolarites3 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BC5DBC135ECD988B ON redoublements2 (scolarite3_id)');
        $this->addSql('ALTER TABLE redoublements3 ADD scolarite3_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE redoublements3 ADD CONSTRAINT FK_CB5A8C855ECD988B FOREIGN KEY (scolarite3_id) REFERENCES scolarites3 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CB5A8C855ECD988B ON redoublements3 (scolarite3_id)');
    }
}
