<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210513111650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD image_id INT DEFAULT NULL, ADD category_id INT NOT NULL, ADD tva_id INT NOT NULL, ADD description LONGTEXT DEFAULT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD available TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4D79775F FOREIGN KEY (tva_id) REFERENCES tva (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD3DA5256D ON product (image_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4D79775F ON product (tva_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3DA5256D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4D79775F');
        $this->addSql('DROP INDEX UNIQ_D34A04AD3DA5256D ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD4D79775F ON product');
        $this->addSql('ALTER TABLE product DROP image_id, DROP category_id, DROP tva_id, DROP description, DROP price, DROP available');
    }
}
