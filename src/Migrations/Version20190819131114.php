<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190819131114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, fk_user_id INT DEFAULT NULL, command_date DATETIME NOT NULL, status INT NOT NULL, INDEX IDX_8ECAEAD45741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, command_id INT DEFAULT NULL, retro_shape INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, name VARCHAR(120) NOT NULL, stock INT NOT NULL, status SMALLINT NOT NULL, price DOUBLE PRECISION NOT NULL, creation_date DATETIME NOT NULL, platform VARCHAR(50) NOT NULL, pegi INT NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_232B318C33E1689A (command_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, fk_bank_id INT DEFAULT NULL, command_id INT DEFAULT NULL, pseudo VARCHAR(30) NOT NULL, picture VARCHAR(255) DEFAULT NULL, mail VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E1E7C66D (fk_bank_id), INDEX IDX_8D93D64933E1689A (command_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_bank (id INT AUTO_INCREMENT NOT NULL, nb_card VARCHAR(50) NOT NULL, date_exp DATETIME NOT NULL, cryptogram VARCHAR(20) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, adress LONGTEXT NOT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(60) NOT NULL, birthday_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD45741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C33E1689A FOREIGN KEY (command_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E1E7C66D FOREIGN KEY (fk_bank_id) REFERENCES user_bank (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64933E1689A FOREIGN KEY (command_id) REFERENCES command (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C33E1689A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64933E1689A');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD45741EEB9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E1E7C66D');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_bank');
    }
}
