<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213132335 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE add_stay (id INT AUTO_INCREMENT NOT NULL, id_stay_id INT NOT NULL, id_staff_id INT NOT NULL, modification DATETIME NOT NULL, INDEX IDX_50F15E6C25A75EA6 (id_stay_id), INDEX IDX_50F15E6C5D96BB58 (id_staff_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bed (id INT AUTO_INCREMENT NOT NULL, id_hospital_room_id INT NOT NULL, number INT NOT NULL, INDEX IDX_E647FCFF452044B9 (id_hospital_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospital_room (id INT AUTO_INCREMENT NOT NULL, id_service_id INT NOT NULL, number VARCHAR(255) NOT NULL, INDEX IDX_F37EFBDA48D62931 (id_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manage (id INT AUTO_INCREMENT NOT NULL, id_patient_id INT NOT NULL, id_staff_id INT NOT NULL, modification DATETIME NOT NULL, INDEX IDX_2472AA4ACE0312AE (id_patient_id), INDEX IDX_2472AA4A5D96BB58 (id_staff_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, social_security_number VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, blood_type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_426EF392AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stay (id INT AUTO_INCREMENT NOT NULL, id_bed_id INT NOT NULL, id_patient_id INT NOT NULL, entry_date DATETIME NOT NULL, leave_date DATETIME NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_5E09839CAE5F3E54 (id_bed_id), INDEX IDX_5E09839CCE0312AE (id_patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE add_stay ADD CONSTRAINT FK_50F15E6C25A75EA6 FOREIGN KEY (id_stay_id) REFERENCES stay (id)');
        $this->addSql('ALTER TABLE add_stay ADD CONSTRAINT FK_50F15E6C5D96BB58 FOREIGN KEY (id_staff_id) REFERENCES staff (id)');
        $this->addSql('ALTER TABLE bed ADD CONSTRAINT FK_E647FCFF452044B9 FOREIGN KEY (id_hospital_room_id) REFERENCES hospital_room (id)');
        $this->addSql('ALTER TABLE hospital_room ADD CONSTRAINT FK_F37EFBDA48D62931 FOREIGN KEY (id_service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE manage ADD CONSTRAINT FK_2472AA4ACE0312AE FOREIGN KEY (id_patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE manage ADD CONSTRAINT FK_2472AA4A5D96BB58 FOREIGN KEY (id_staff_id) REFERENCES staff (id)');
        $this->addSql('ALTER TABLE stay ADD CONSTRAINT FK_5E09839CAE5F3E54 FOREIGN KEY (id_bed_id) REFERENCES bed (id)');
        $this->addSql('ALTER TABLE stay ADD CONSTRAINT FK_5E09839CCE0312AE FOREIGN KEY (id_patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stay DROP FOREIGN KEY FK_5E09839CAE5F3E54');
        $this->addSql('ALTER TABLE bed DROP FOREIGN KEY FK_E647FCFF452044B9');
        $this->addSql('ALTER TABLE manage DROP FOREIGN KEY FK_2472AA4ACE0312AE');
        $this->addSql('ALTER TABLE stay DROP FOREIGN KEY FK_5E09839CCE0312AE');
        $this->addSql('ALTER TABLE hospital_room DROP FOREIGN KEY FK_F37EFBDA48D62931');
        $this->addSql('ALTER TABLE add_stay DROP FOREIGN KEY FK_50F15E6C5D96BB58');
        $this->addSql('ALTER TABLE manage DROP FOREIGN KEY FK_2472AA4A5D96BB58');
        $this->addSql('ALTER TABLE add_stay DROP FOREIGN KEY FK_50F15E6C25A75EA6');
        $this->addSql('DROP TABLE add_stay');
        $this->addSql('DROP TABLE bed');
        $this->addSql('DROP TABLE hospital_room');
        $this->addSql('DROP TABLE manage');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE staff');
        $this->addSql('DROP TABLE stay');
    }
}
