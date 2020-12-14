<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214210415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE add_stay CHANGE id_stay_id id_stay_id INT DEFAULT NULL, CHANGE id_staff_id id_staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bed CHANGE id_hospital_room_id id_hospital_room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital_room CHANGE id_service_id id_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manage ADD action VARCHAR(255) NOT NULL, CHANGE id_patient_id id_patient_id INT DEFAULT NULL, CHANGE id_staff_id id_staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stay CHANGE id_bed_id id_bed_id INT DEFAULT NULL, CHANGE id_patient_id id_patient_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE add_stay CHANGE id_stay_id id_stay_id INT NOT NULL, CHANGE id_staff_id id_staff_id INT NOT NULL');
        $this->addSql('ALTER TABLE bed CHANGE id_hospital_room_id id_hospital_room_id INT NOT NULL');
        $this->addSql('ALTER TABLE hospital_room CHANGE id_service_id id_service_id INT NOT NULL');
        $this->addSql('ALTER TABLE manage DROP action, CHANGE id_patient_id id_patient_id INT NOT NULL, CHANGE id_staff_id id_staff_id INT NOT NULL');
        $this->addSql('ALTER TABLE stay CHANGE id_bed_id id_bed_id INT NOT NULL, CHANGE id_patient_id id_patient_id INT NOT NULL');
    }
}
