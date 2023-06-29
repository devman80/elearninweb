<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418190949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annee (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, libelle VARCHAR(128) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_DE92C5CFB03A8386 (created_by_id), INDEX IDX_DE92C5CF896DBBDE (updated_by_id), INDEX IDX_DE92C5CFC76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classeroom (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_2D73C6F3B03A8386 (created_by_id), INDEX IDX_2D73C6F3896DBBDE (updated_by_id), INDEX IDX_2D73C6F3C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coefficiant (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_380FB3BDB03A8386 (created_by_id), INDEX IDX_380FB3BD896DBBDE (updated_by_id), INDEX IDX_380FB3BDC76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_E2E2D1EEB03A8386 (created_by_id), INDEX IDX_E2E2D1EE896DBBDE (updated_by_id), INDEX IDX_E2E2D1EEC76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dispenser (id INT AUTO_INCREMENT NOT NULL, enseignant_id INT DEFAULT NULL, classeroom_id INT DEFAULT NULL, module_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, datedispenser DATE DEFAULT NULL, brochure_filename VARCHAR(255) DEFAULT NULL, audio LONGTEXT DEFAULT NULL, video LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_849D9917E455FCC0 (enseignant_id), INDEX IDX_849D9917856F58DA (classeroom_id), INDEX IDX_849D9917AFC2B591 (module_id), INDEX IDX_849D9917B03A8386 (created_by_id), INDEX IDX_849D9917896DBBDE (updated_by_id), INDEX IDX_849D9917C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, contact VARCHAR(128) DEFAULT NULL, sexe VARCHAR(128) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, brochure_filename VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_81A72FA1B03A8386 (created_by_id), INDEX IDX_81A72FA1896DBBDE (updated_by_id), INDEX IDX_81A72FA1C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, stagiaire_id INT DEFAULT NULL, enseignant_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, note LONGTEXT DEFAULT NULL, dateevaluation DATE DEFAULT NULL, coefficiant INT DEFAULT NULL, totalcoef INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_1323A575F46CD258 (matiere_id), INDEX IDX_1323A575BBA93DD6 (stagiaire_id), INDEX IDX_1323A575E455FCC0 (enseignant_id), INDEX IDX_1323A575B03A8386 (created_by_id), INDEX IDX_1323A575896DBBDE (updated_by_id), INDEX IDX_1323A575C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, commune_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, brochure_filename VARCHAR(255) DEFAULT NULL, sexe VARCHAR(128) DEFAULT NULL, contact VARCHAR(128) DEFAULT NULL, statutmatri VARCHAR(128) DEFAULT NULL, datenaissance DATE DEFAULT NULL, lieuresidence VARCHAR(255) DEFAULT NULL, paysnaiss VARCHAR(255) DEFAULT NULL, paysvit VARCHAR(255) DEFAULT NULL, typepiece VARCHAR(128) DEFAULT NULL, numpiece VARCHAR(128) DEFAULT NULL, handicap VARCHAR(128) DEFAULT NULL, typehandicap VARCHAR(255) DEFAULT NULL, telephone VARCHAR(128) DEFAULT NULL, cmu VARCHAR(128) DEFAULT NULL, certificat_filename VARCHAR(255) DEFAULT NULL, extrait_filename VARCHAR(255) DEFAULT NULL, matricule VARCHAR(128) DEFAULT NULL, diplome_filename VARCHAR(255) DEFAULT NULL, cni_filename VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, montant_inscription INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_5E90F6D6131A4F72 (commune_id), INDEX IDX_5E90F6D6B03A8386 (created_by_id), INDEX IDX_5E90F6D6896DBBDE (updated_by_id), INDEX IDX_5E90F6D6C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscrire (id INT AUTO_INCREMENT NOT NULL, classeroom_id INT DEFAULT NULL, stagiaire_id INT DEFAULT NULL, dateinscrire DATE DEFAULT NULL, INDEX IDX_84CA37A8856F58DA (classeroom_id), INDEX IDX_84CA37A8BBA93DD6 (stagiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_9014574AB03A8386 (created_by_id), INDEX IDX_9014574A896DBBDE (updated_by_id), INDEX IDX_9014574AC76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, volumeheure VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_C242628F46CD258 (matiere_id), INDEX IDX_C242628B03A8386 (created_by_id), INDEX IDX_C242628896DBBDE (updated_by_id), INDEX IDX_C242628C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, inscription_id INT DEFAULT NULL, modepaiement VARCHAR(255) DEFAULT NULL, montantpaiement INT DEFAULT NULL, datepaiement DATETIME DEFAULT NULL, INDEX IDX_B1DC7A1E5DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_2D737AEFB03A8386 (created_by_id), INDEX IDX_2D737AEF896DBBDE (updated_by_id), INDEX IDX_2D737AEFC76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, sexe VARCHAR(128) DEFAULT NULL, dateinscrit DATE DEFAULT NULL, brochure_filename VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, created_from_ip VARCHAR(45) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, updated_from_ip VARCHAR(45) DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, deleted_from_ip VARCHAR(45) DEFAULT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_4F62F731D823E37A (section_id), INDEX IDX_4F62F731B03A8386 (created_by_id), INDEX IDX_4F62F731896DBBDE (updated_by_id), INDEX IDX_4F62F731C76F1F52 (deleted_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, brochure_filename VARCHAR(255) DEFAULT NULL, contact VARCHAR(128) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annee ADD CONSTRAINT FK_DE92C5CFB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annee ADD CONSTRAINT FK_DE92C5CF896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annee ADD CONSTRAINT FK_DE92C5CFC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classeroom ADD CONSTRAINT FK_2D73C6F3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classeroom ADD CONSTRAINT FK_2D73C6F3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classeroom ADD CONSTRAINT FK_2D73C6F3C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE coefficiant ADD CONSTRAINT FK_380FB3BDB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE coefficiant ADD CONSTRAINT FK_380FB3BD896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE coefficiant ADD CONSTRAINT FK_380FB3BDC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EEB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EEC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dispenser ADD CONSTRAINT FK_849D9917E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE dispenser ADD CONSTRAINT FK_849D9917856F58DA FOREIGN KEY (classeroom_id) REFERENCES classeroom (id)');
        $this->addSql('ALTER TABLE dispenser ADD CONSTRAINT FK_849D9917AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE dispenser ADD CONSTRAINT FK_849D9917B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dispenser ADD CONSTRAINT FK_849D9917896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dispenser ADD CONSTRAINT FK_849D9917C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8856F58DA FOREIGN KEY (classeroom_id) REFERENCES classeroom (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574AC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee DROP FOREIGN KEY FK_DE92C5CFB03A8386');
        $this->addSql('ALTER TABLE annee DROP FOREIGN KEY FK_DE92C5CF896DBBDE');
        $this->addSql('ALTER TABLE annee DROP FOREIGN KEY FK_DE92C5CFC76F1F52');
        $this->addSql('ALTER TABLE classeroom DROP FOREIGN KEY FK_2D73C6F3B03A8386');
        $this->addSql('ALTER TABLE classeroom DROP FOREIGN KEY FK_2D73C6F3896DBBDE');
        $this->addSql('ALTER TABLE classeroom DROP FOREIGN KEY FK_2D73C6F3C76F1F52');
        $this->addSql('ALTER TABLE coefficiant DROP FOREIGN KEY FK_380FB3BDB03A8386');
        $this->addSql('ALTER TABLE coefficiant DROP FOREIGN KEY FK_380FB3BD896DBBDE');
        $this->addSql('ALTER TABLE coefficiant DROP FOREIGN KEY FK_380FB3BDC76F1F52');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EEB03A8386');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EE896DBBDE');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EEC76F1F52');
        $this->addSql('ALTER TABLE dispenser DROP FOREIGN KEY FK_849D9917E455FCC0');
        $this->addSql('ALTER TABLE dispenser DROP FOREIGN KEY FK_849D9917856F58DA');
        $this->addSql('ALTER TABLE dispenser DROP FOREIGN KEY FK_849D9917AFC2B591');
        $this->addSql('ALTER TABLE dispenser DROP FOREIGN KEY FK_849D9917B03A8386');
        $this->addSql('ALTER TABLE dispenser DROP FOREIGN KEY FK_849D9917896DBBDE');
        $this->addSql('ALTER TABLE dispenser DROP FOREIGN KEY FK_849D9917C76F1F52');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1B03A8386');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1896DBBDE');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1C76F1F52');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575F46CD258');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575BBA93DD6');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575E455FCC0');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575B03A8386');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575896DBBDE');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575C76F1F52');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6131A4F72');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6B03A8386');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6896DBBDE');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6C76F1F52');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8856F58DA');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8BBA93DD6');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574AB03A8386');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A896DBBDE');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574AC76F1F52');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628F46CD258');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628B03A8386');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628896DBBDE');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628C76F1F52');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E5DAC5993');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFB03A8386');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF896DBBDE');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFC76F1F52');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731D823E37A');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731B03A8386');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731896DBBDE');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731C76F1F52');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE classeroom');
        $this->addSql('DROP TABLE coefficiant');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE dispenser');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscrire');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
