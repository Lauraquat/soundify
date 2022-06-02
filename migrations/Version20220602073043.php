<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602073043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, file VARCHAR(255) NOT NULL, duration INTEGER NOT NULL, listening_number INTEGER NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE song_artiste (song_id INTEGER NOT NULL, artiste_id INTEGER NOT NULL, PRIMARY KEY(song_id, artiste_id))');
        $this->addSql('CREATE INDEX IDX_916C2460A0BDB2F3 ON song_artiste (song_id)');
        $this->addSql('CREATE INDEX IDX_916C246021D25844 ON song_artiste (artiste_id)');
        $this->addSql('DROP INDEX UNIQ_9C07354FA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__artiste AS SELECT id, user_id, name FROM artiste');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('CREATE TABLE artiste (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_9C07354FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO artiste (id, user_id, name) SELECT id, user_id, name FROM __temp__artiste');
        $this->addSql('DROP TABLE __temp__artiste');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C07354FA76ED395 ON artiste (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE song_artiste');
        $this->addSql('DROP INDEX UNIQ_9C07354FA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__artiste AS SELECT id, user_id, name FROM artiste');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('CREATE TABLE artiste (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO artiste (id, user_id, name) SELECT id, user_id, name FROM __temp__artiste');
        $this->addSql('DROP TABLE __temp__artiste');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C07354FA76ED395 ON artiste (user_id)');
    }
}
