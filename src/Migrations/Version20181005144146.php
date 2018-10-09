<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181005144146 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(50) NOT NULL, code_postal INT NOT NULL, date_naissance DATE NOT NULL, ville VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, siret_siren BIGINT NOT NULL, nom VARCHAR(50) NOT NULL, adresse VARCHAR(50) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, fk_tva_id INT DEFAULT NULL, fk_tarif_id INT DEFAULT NULL, fk_client_id INT DEFAULT NULL, fk_entreprise_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, titre VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, quantite BIGINT NOT NULL, total BIGINT NOT NULL, INDEX IDX_E10AD4006DD71FCF (fk_tva_id), INDEX IDX_E10AD4007544987 (fk_tarif_id), INDEX IDX_E10AD40078B2BEB1 (fk_client_id), INDEX IDX_E10AD400C0E4DA28 (fk_entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarif (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) NOT NULL, tarif_horaire TINYINT(1) NOT NULL, valeur BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarif_entreprise (tarif_id INT NOT NULL, entreprise_id INT NOT NULL, INDEX IDX_5CF4FF82357C0A59 (tarif_id), INDEX IDX_5CF4FF82A4AEAFEA (entreprise_id), PRIMARY KEY(tarif_id, entreprise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) NOT NULL, taux DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_entreprise (user_id INT NOT NULL, entreprise_id INT NOT NULL, INDEX IDX_AA7E3C8CA76ED395 (user_id), INDEX IDX_AA7E3C8CA4AEAFEA (entreprise_id), PRIMARY KEY(user_id, entreprise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4006DD71FCF FOREIGN KEY (fk_tva_id) REFERENCES tva (id)');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD4007544987 FOREIGN KEY (fk_tarif_id) REFERENCES tarif (id)');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD40078B2BEB1 FOREIGN KEY (fk_client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE evenements ADD CONSTRAINT FK_E10AD400C0E4DA28 FOREIGN KEY (fk_entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE tarif_entreprise ADD CONSTRAINT FK_5CF4FF82357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarif (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarif_entreprise ADD CONSTRAINT FK_5CF4FF82A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_entreprise ADD CONSTRAINT FK_AA7E3C8CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_entreprise ADD CONSTRAINT FK_AA7E3C8CA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD40078B2BEB1');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD400C0E4DA28');
        $this->addSql('ALTER TABLE tarif_entreprise DROP FOREIGN KEY FK_5CF4FF82A4AEAFEA');
        $this->addSql('ALTER TABLE user_entreprise DROP FOREIGN KEY FK_AA7E3C8CA4AEAFEA');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4007544987');
        $this->addSql('ALTER TABLE tarif_entreprise DROP FOREIGN KEY FK_5CF4FF82357C0A59');
        $this->addSql('ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD4006DD71FCF');
        $this->addSql('ALTER TABLE user_entreprise DROP FOREIGN KEY FK_AA7E3C8CA76ED395');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE evenements');
        $this->addSql('DROP TABLE tarif');
        $this->addSql('DROP TABLE tarif_entreprise');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_entreprise');
    }
}
