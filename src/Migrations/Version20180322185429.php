<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180322185429 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE objectifs (id INT AUTO_INCREMENT NOT NULL, objectif_img VARCHAR(50) NOT NULL, objectif_points INT NOT NULL, objectif_ordre INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objets (id INT AUTO_INCREMENT NOT NULL, objet_id INT NOT NULL, carte_nom VARCHAR(20) NOT NULL, carte_points INT NOT NULL, carte_img VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parties (id INT AUTO_INCREMENT NOT NULL, joueur1_id INT DEFAULT NULL, joueur2_id INT DEFAULT NULL, partie_nom VARCHAR(30) NOT NULL, commence_le DATETIME NOT NULL, partie_tour VARCHAR(2) NOT NULL, partie_manche INT NOT NULL, partie_pioche LONGTEXT NOT NULL, partie_objectifs LONGTEXT NOT NULL, main_j1 LONGTEXT NOT NULL, main_j2 LONGTEXT NOT NULL, action_j1 LONGTEXT NOT NULL, action_j2 LONGTEXT NOT NULL, carte_jetee INT NOT NULL, terrain_j1 LONGTEXT NOT NULL, terrain_j2 LONGTEXT NOT NULL, score_j1 INT NOT NULL, score_j2 INT NOT NULL, INDEX IDX_4363180592C1E237 (joueur1_id), INDEX IDX_4363180580744DD9 (joueur2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, actif INT NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parties ADD CONSTRAINT FK_4363180592C1E237 FOREIGN KEY (joueur1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE parties ADD CONSTRAINT FK_4363180580744DD9 FOREIGN KEY (joueur2_id) REFERENCES user (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parties DROP FOREIGN KEY FK_4363180592C1E237');
        $this->addSql('ALTER TABLE parties DROP FOREIGN KEY FK_4363180580744DD9');
        $this->addSql('DROP TABLE objectifs');
        $this->addSql('DROP TABLE objets');
        $this->addSql('DROP TABLE parties');
        $this->addSql('DROP TABLE user');
    }
}
