<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190819133438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD45741EEB9');
        $this->addSql('DROP INDEX IDX_8ECAEAD45741EEB9 ON command');
        $this->addSql('ALTER TABLE command CHANGE fk_user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD4A76ED395 ON command (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E1E7C66D');
        $this->addSql('DROP INDEX UNIQ_8D93D649E1E7C66D ON user');
        $this->addSql('ALTER TABLE user CHANGE fk_bank_id bank_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64911C8FB41 FOREIGN KEY (bank_id) REFERENCES user_bank (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64911C8FB41 ON user (bank_id)');
        $this->addSql('ALTER TABLE user_bank CHANGE adress address LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4A76ED395');
        $this->addSql('DROP INDEX IDX_8ECAEAD4A76ED395 ON command');
        $this->addSql('ALTER TABLE command CHANGE user_id fk_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD45741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD45741EEB9 ON command (fk_user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64911C8FB41');
        $this->addSql('DROP INDEX UNIQ_8D93D64911C8FB41 ON user');
        $this->addSql('ALTER TABLE user CHANGE bank_id fk_bank_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E1E7C66D FOREIGN KEY (fk_bank_id) REFERENCES user_bank (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E1E7C66D ON user (fk_bank_id)');
        $this->addSql('ALTER TABLE user_bank CHANGE address adress LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
