<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190116004031 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis_user DROP FOREIGN KEY FK_C241B796A76ED395');
        $this->addSql('ALTER TABLE invoice_user DROP FOREIGN KEY FK_8F56B42CA76ED395');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('ALTER TABLE user_person DROP FOREIGN KEY FK_518ECA4BA76ED395');
        $this->addSql('ALTER TABLE user_report DROP FOREIGN KEY FK_A17D6CB9A76ED395');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE devis_user DROP FOREIGN KEY FK_C241B796A76ED395');
        $this->addSql('ALTER TABLE devis_user ADD CONSTRAINT FK_C241B796A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE invoice_user DROP FOREIGN KEY FK_8F56B42CA76ED395');
        $this->addSql('ALTER TABLE invoice_user ADD CONSTRAINT FK_8F56B42CA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE user_person DROP FOREIGN KEY FK_518ECA4BA76ED395');
        $this->addSql('ALTER TABLE user_person ADD CONSTRAINT FK_518ECA4BA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE user_report DROP FOREIGN KEY FK_A17D6CB9A76ED395');
        $this->addSql('ALTER TABLE user_report ADD CONSTRAINT FK_A17D6CB9A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('ALTER TABLE devis_user DROP FOREIGN KEY FK_C241B796A76ED395');
        $this->addSql('ALTER TABLE invoice_user DROP FOREIGN KEY FK_8F56B42CA76ED395');
        $this->addSql('ALTER TABLE user_person DROP FOREIGN KEY FK_518ECA4BA76ED395');
        $this->addSql('ALTER TABLE user_report DROP FOREIGN KEY FK_A17D6CB9A76ED395');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, username_canonical VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, email_canonical VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL COLLATE utf8mb4_unicode_ci, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('ALTER TABLE devis_user DROP FOREIGN KEY FK_C241B796A76ED395');
        $this->addSql('ALTER TABLE devis_user ADD CONSTRAINT FK_C241B796A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice_user DROP FOREIGN KEY FK_8F56B42CA76ED395');
        $this->addSql('ALTER TABLE invoice_user ADD CONSTRAINT FK_8F56B42CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_person DROP FOREIGN KEY FK_518ECA4BA76ED395');
        $this->addSql('ALTER TABLE user_person ADD CONSTRAINT FK_518ECA4BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_report DROP FOREIGN KEY FK_A17D6CB9A76ED395');
        $this->addSql('ALTER TABLE user_report ADD CONSTRAINT FK_A17D6CB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
