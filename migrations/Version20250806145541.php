<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250806145541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart CHANGE created_at created_at DATETIME NOT NULL, CHANGE validated_at validated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_item CHANGE score quantity INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE avalaible available TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE rating ADD created_at DATETIME NOT NULL, DROP date_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart CHANGE created_at created_at VARCHAR(255) NOT NULL, CHANGE validated_at validated_at VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_item CHANGE quantity score INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE available avalaible TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE rating ADD date_time VARCHAR(255) NOT NULL, DROP created_at');
    }
}
