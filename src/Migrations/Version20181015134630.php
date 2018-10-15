<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181015134630 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dnd_equipment (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, cost INT NOT NULL, weight INT NOT NULL, info VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, damage INT DEFAULT NULL, damage_type VARCHAR(255) DEFAULT NULL, armour_class VARCHAR(255) DEFAULT NULL, INDEX IDX_9D7EB00EC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dnd_equipment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dnd_equipment ADD CONSTRAINT FK_9D7EB00EC54C8C93 FOREIGN KEY (type_id) REFERENCES dnd_equipment_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dnd_equipment DROP FOREIGN KEY FK_9D7EB00EC54C8C93');
        $this->addSql('DROP TABLE dnd_equipment');
        $this->addSql('DROP TABLE dnd_equipment_type');
    }
}
