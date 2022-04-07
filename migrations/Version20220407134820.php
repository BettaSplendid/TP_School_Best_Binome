<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407134820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD176F85E0677 ON person (username)');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33D823E37A');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_34DCD176F85E0677 ON person');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33D823E37A');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
    }
}
