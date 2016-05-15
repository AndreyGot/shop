<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160515212933 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bill ADD session VARCHAR(50) DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX SESSION ON bill (session)');
        $this->addSql('ALTER TABLE value_product DROP FOREIGN KEY FK_38E871CD1A8C12F5');
        $this->addSql('ALTER TABLE value_product ADD CONSTRAINT FK_38E871CD1A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX SESSION ON bill');
        $this->addSql('ALTER TABLE bill DROP session, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE value_product DROP FOREIGN KEY FK_38E871CD1A8C12F5');
        $this->addSql('ALTER TABLE value_product ADD CONSTRAINT FK_38E871CD1A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
    }
}
