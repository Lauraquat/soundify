<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527080844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_9C07354FA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__artiste AS SELECT id, user_id, name FROM artiste');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('CREATE TABLE artiste (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_9C07354FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO artiste (id, user_id, name) SELECT id, user_id, name FROM __temp__artiste');
        $this->addSql('DROP TABLE __temp__artiste');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C07354FA76ED395 ON artiste (user_id)');
        $this->addSql('ALTER TABLE user ADD COLUMN is_verified BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_9C07354FA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__artiste AS SELECT id, user_id, name FROM artiste');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('CREATE TABLE artiste (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO artiste (id, user_id, name) SELECT id, user_id, name FROM __temp__artiste');
        $this->addSql('DROP TABLE __temp__artiste');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9C07354FA76ED395 ON artiste (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password) SELECT id, email, roles, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
