<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216201914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE add_stay ADD CONSTRAINT FK_50F15E6C25A75EA6 FOREIGN KEY (id_stay_id) REFERENCES stay (id)');
        $this->addSql('ALTER TABLE add_stay ADD CONSTRAINT FK_50F15E6C5D96BB58 FOREIGN KEY (id_staff_id) REFERENCES staff (id)');
        $this->addSql('ALTER TABLE patient ADD activate TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE stay ADD activate TINYINT(1) DEFAULT \'1\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE add_stay DROP FOREIGN KEY FK_50F15E6C25A75EA6');
        $this->addSql('ALTER TABLE add_stay DROP FOREIGN KEY FK_50F15E6C5D96BB58');
        $this->addSql('ALTER TABLE patient DROP activate');
        $this->addSql('ALTER TABLE stay DROP activate');
    }
}
