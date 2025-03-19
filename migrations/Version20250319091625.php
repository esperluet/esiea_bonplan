<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319091625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bon_plan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, proprietaire_id INTEGER DEFAULT NULL, categorie_id INTEGER DEFAULT NULL, titre VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, adresse VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, dat_validite DATETIME DEFAULT NULL, CONSTRAINT FK_FEB1F6F276C50E4A FOREIGN KEY (proprietaire_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FEB1F6F2BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FEB1F6F276C50E4A ON bon_plan (proprietaire_id)');
        $this->addSql('CREATE INDEX IDX_FEB1F6F2BCF5E72D ON bon_plan (categorie_id)');
        $this->addSql('CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER NOT NULL, bon_plan_id INTEGER NOT NULL, contenu CLOB NOT NULL, date_creation DATETIME NOT NULL, CONSTRAINT FK_67F068BC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_67F068BC2E81A751 FOREIGN KEY (bon_plan_id) REFERENCES bon_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_67F068BC60BB6FE6 ON commentaire (auteur_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC2E81A751 ON commentaire (bon_plan_id)');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bon_plan_id INTEGER NOT NULL, url VARCHAR(255) NOT NULL, CONSTRAINT FK_C53D045F2E81A751 FOREIGN KEY (bon_plan_id) REFERENCES bon_plan (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C53D045F2E81A751 ON image (bon_plan_id)');
        $this->addSql('CREATE TABLE utilisateur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:array)
        )');
        $this->addSql('CREATE TABLE utilisateur_bon_plan (utilisateur_id INTEGER NOT NULL, bon_plan_id INTEGER NOT NULL, PRIMARY KEY(utilisateur_id, bon_plan_id), CONSTRAINT FK_E0CA0F6DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E0CA0F6D2E81A751 FOREIGN KEY (bon_plan_id) REFERENCES bon_plan (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E0CA0F6DFB88E14F ON utilisateur_bon_plan (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_E0CA0F6D2E81A751 ON utilisateur_bon_plan (bon_plan_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bon_plan');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_bon_plan');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
