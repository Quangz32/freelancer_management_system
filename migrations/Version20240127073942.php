<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127073942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, job VARCHAR(255) NOT NULL, year_of_exp INT NOT NULL, gender VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info_user_security (user_info_id INT NOT NULL, user_security_id INT NOT NULL, INDEX IDX_C1CD3CA6586DFF2 (user_info_id), INDEX IDX_C1CD3CA6C4A58B81 (user_security_id), PRIMARY KEY(user_info_id, user_security_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_info_user_security ADD CONSTRAINT FK_C1CD3CA6586DFF2 FOREIGN KEY (user_info_id) REFERENCES user_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_info_user_security ADD CONSTRAINT FK_C1CD3CA6C4A58B81 FOREIGN KEY (user_security_id) REFERENCES user_security (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE freelancer DROP FOREIGN KEY FK_4C2ED1E89D86650F');
        $this->addSql('ALTER TABLE freelancer_role DROP FOREIGN KEY FK_E21FC3708545BDF5');
        $this->addSql('ALTER TABLE freelancer_role DROP FOREIGN KEY FK_E21FC370D60322AC');
        $this->addSql('DROP TABLE freelancer');
        $this->addSql('DROP TABLE freelancer_role');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE freelancer (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, years_of_experience INT NOT NULL, gender VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_4C2ED1E89D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE freelancer_role (freelancer_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_E21FC3708545BDF5 (freelancer_id), INDEX IDX_E21FC370D60322AC (role_id), PRIMARY KEY(freelancer_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE freelancer ADD CONSTRAINT FK_4C2ED1E89D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE freelancer_role ADD CONSTRAINT FK_E21FC3708545BDF5 FOREIGN KEY (freelancer_id) REFERENCES freelancer (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE freelancer_role ADD CONSTRAINT FK_E21FC370D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_info_user_security DROP FOREIGN KEY FK_C1CD3CA6586DFF2');
        $this->addSql('ALTER TABLE user_info_user_security DROP FOREIGN KEY FK_C1CD3CA6C4A58B81');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP TABLE user_info_user_security');
    }
}
