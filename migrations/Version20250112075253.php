<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250112075253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B72523478947610D ON annee_scolaires (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_45C1718D8947610D ON cercles (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF7489B28947610D ON departements (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51AD1AF28947610D ON ninas (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A069E65D8947610D ON noms (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2FDA85FA8947610D ON professions (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A26779F38947610D ON regions (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6FCD09FA13F7E7C ON telephones (malitel)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6FCD09F1DC5B178 ON telephones (orange)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_B72523478947610D ON annee_scolaires');
        $this->addSql('DROP INDEX UNIQ_A26779F38947610D ON regions');
        $this->addSql('DROP INDEX UNIQ_45C1718D8947610D ON cercles');
        $this->addSql('DROP INDEX UNIQ_2FDA85FA8947610D ON professions');
        $this->addSql('DROP INDEX UNIQ_51AD1AF28947610D ON ninas');
        $this->addSql('DROP INDEX UNIQ_CF7489B28947610D ON departements');
        $this->addSql('DROP INDEX UNIQ_A069E65D8947610D ON noms');
        $this->addSql('DROP INDEX UNIQ_6FCD09FA13F7E7C ON telephones');
        $this->addSql('DROP INDEX UNIQ_6FCD09F1DC5B178 ON telephones');
    }
}
