<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190116005034 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, amount VARCHAR(45) NOT NULL, date DATETIME NOT NULL, INDEX fk_subscription_user1_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_person (team_id INT NOT NULL, person_id INT NOT NULL, INDEX IDX_42C796AF296CD8AE (team_id), INDEX IDX_42C796AF217BBB47 (person_id), PRIMARY KEY(team_id, person_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Invoice (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(45) NOT NULL, registre_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, lastName VARCHAR(255) NOT NULL, firstName VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, mobilePhone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, job VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commercial (id INT NOT NULL, salary VARCHAR(255) DEFAULT NULL, INDEX id_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provider (id INT NOT NULL, categoryName VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE team_person ADD CONSTRAINT FK_42C796AF296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team_person ADD CONSTRAINT FK_42C796AF217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09BF396750 FOREIGN KEY (id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE commercial ADD CONSTRAINT FK_7653F3AEBF396750 FOREIGN KEY (id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE provider ADD CONSTRAINT FK_92C4739CBF396750 FOREIGN KEY (id) REFERENCES person (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team_person DROP FOREIGN KEY FK_42C796AF296CD8AE');
        $this->addSql('ALTER TABLE team_person DROP FOREIGN KEY FK_42C796AF217BBB47');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09BF396750');
        $this->addSql('ALTER TABLE commercial DROP FOREIGN KEY FK_7653F3AEBF396750');
        $this->addSql('ALTER TABLE provider DROP FOREIGN KEY FK_92C4739CBF396750');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_person');
        $this->addSql('DROP TABLE Invoice');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE commercial');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE provider');
    }
}
