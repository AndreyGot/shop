<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160426000110 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE value_product (id INT AUTO_INCREMENT NOT NULL, bill_id INT NOT NULL, product_id INT NOT NULL, value INT NOT NULL, INDEX IDX_38E871CD1A8C12F5 (bill_id), INDEX IDX_38E871CD4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE value_product ADD CONSTRAINT FK_38E871CD1A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('ALTER TABLE value_product ADD CONSTRAINT FK_38E871CD4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('DROP TABLE value');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE value (id INT AUTO_INCREMENT NOT NULL, bill_id INT NOT NULL, product_id INT NOT NULL, value INT NOT NULL, INDEX IDX_1D7758344584665A (product_id), INDEX IDX_1D7758341A8C12F5 (bill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE value ADD CONSTRAINT FK_1D7758341A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('ALTER TABLE value ADD CONSTRAINT FK_1D7758344584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('DROP TABLE value_product');
    }
}
