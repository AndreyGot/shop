<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160308230655 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE value ADD bill_id INT NOT NULL');
        $this->addSql('ALTER TABLE value ADD CONSTRAINT FK_1D7758341A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('CREATE INDEX IDX_1D7758341A8C12F5 ON value (bill_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE value DROP FOREIGN KEY FK_1D7758341A8C12F5');
        $this->addSql('DROP INDEX IDX_1D7758341A8C12F5 ON value');
        $this->addSql('ALTER TABLE value DROP bill_id');
    }
}
