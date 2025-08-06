<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250806094445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE staff_shift (id UUID NOT NULL, staff_id UUID NOT NULL, shop_id UUID NOT NULL, work_shift_id UUID NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D8EE9382D4D57CD ON staff_shift (staff_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D8EE93824D16C4DD ON staff_shift (shop_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D8EE93826EC53652 ON staff_shift (work_shift_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN staff_shift.id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN staff_shift.staff_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN staff_shift.shop_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN staff_shift.work_shift_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE staff_shift ADD CONSTRAINT FK_D8EE9382D4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE staff_shift ADD CONSTRAINT FK_D8EE93824D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE staff_shift ADD CONSTRAINT FK_D8EE93826EC53652 FOREIGN KEY (work_shift_id) REFERENCES work_shift (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE staff_shift DROP CONSTRAINT FK_D8EE9382D4D57CD
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE staff_shift DROP CONSTRAINT FK_D8EE93824D16C4DD
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE staff_shift DROP CONSTRAINT FK_D8EE93826EC53652
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE staff_shift
        SQL);
    }
}
