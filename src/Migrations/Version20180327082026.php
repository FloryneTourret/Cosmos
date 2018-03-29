<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180327082026 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parties ADD carte_secrete_j1 LONGTEXT NOT NULL, ADD carte_secrete_j2 LONGTEXT NOT NULL, ADD carte_dissimulee_j1 LONGTEXT NOT NULL, ADD carte_dissimulee_j2 LONGTEXT NOT NULL, DROP carte_secrete, DROP carte_dissimulee');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parties ADD carte_secrete LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, ADD carte_dissimulee LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, DROP carte_secrete_j1, DROP carte_secrete_j2, DROP carte_dissimulee_j1, DROP carte_dissimulee_j2');
    }
}
