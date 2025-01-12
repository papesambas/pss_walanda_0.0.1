<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250112064328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9C54C8C93 FOREIGN KEY (type_id) REFERENCES users_type (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9C54C8C93 ON users (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9C54C8C93');
        $this->addSql('DROP INDEX IDX_1483A5E9C54C8C93 ON users');
        $this->addSql('ALTER TABLE users DROP type_id');
    }
}
