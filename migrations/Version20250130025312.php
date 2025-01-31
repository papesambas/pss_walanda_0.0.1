<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130025312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_3AA9D975989D9B62 ON enseignements');
        $this->addSql('DROP INDEX UNIQ_E4922669989D9B62 ON etablissements');
        $this->addSql('DROP INDEX UNIQ_B7252347989D9B62 ON annee_scolaires');
        $this->addSql('DROP INDEX UNIQ_45C1718D989D9B62 ON cercles');
        $this->addSql('DROP INDEX UNIQ_2ED7EC5989D9B62 ON classes');
        $this->addSql('DROP INDEX UNIQ_5C5EE2A5989D9B62 ON communes');
        $this->addSql('DROP INDEX UNIQ_72B88B24989D9B62 ON cycles');
        $this->addSql('DROP INDEX UNIQ_CF7489B2989D9B62 ON departements');
        $this->addSql('DROP INDEX UNIQ_383B09B1989D9B62 ON eleves');
        $this->addSql('DROP INDEX UNIQ_51AD1AF2989D9B62 ON ninas');
        $this->addSql('DROP INDEX UNIQ_56F771A0989D9B62 ON niveaux');
        $this->addSql('DROP INDEX UNIQ_A069E65D989D9B62 ON noms');
        $this->addSql('DROP INDEX UNIQ_FD501D6A989D9B62 ON parents');
        $this->addSql('DROP INDEX UNIQ_E71162E3989D9B62 ON prenoms');
        $this->addSql('DROP INDEX UNIQ_2FDA85FA989D9B62 ON professions');
        $this->addSql('DROP INDEX UNIQ_A26779F3989D9B62 ON regions');
        $this->addSql('DROP INDEX UNIQ_8FB4A8E5989D9B62 ON statut_eleves');
        $this->addSql('DROP INDEX UNIQ_6FCD09F989D9B62 ON telephones');
        $this->addSql('DROP INDEX UNIQ_1483A5E9989D9B62 ON users');
        $this->addSql('DROP INDEX UNIQ_43571927989D9B62 ON users_type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B7252347989D9B62 ON annee_scolaires (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_45C1718D989D9B62 ON cercles (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2ED7EC5989D9B62 ON classes (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C5EE2A5989D9B62 ON communes (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_72B88B24989D9B62 ON cycles (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF7489B2989D9B62 ON departements (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_383B09B1989D9B62 ON eleves (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AA9D975989D9B62 ON Enseignements (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4922669989D9B62 ON Etablissements (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51AD1AF2989D9B62 ON ninas (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_56F771A0989D9B62 ON niveaux (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A069E65D989D9B62 ON noms (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD501D6A989D9B62 ON parents (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E71162E3989D9B62 ON prenoms (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2FDA85FA989D9B62 ON professions (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A26779F3989D9B62 ON regions (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB4A8E5989D9B62 ON statut_eleves (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6FCD09F989D9B62 ON telephones (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9989D9B62 ON users (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_43571927989D9B62 ON users_type (slug)');
    }
}
