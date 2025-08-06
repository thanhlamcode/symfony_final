<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250806102212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE delivery (id UUID NOT NULL, order_id UUID NOT NULL, status VARCHAR(255) NOT NULL, shipper_name VARCHAR(255) DEFAULT NULL, shipper_phone VARCHAR(50) DEFAULT NULL, tracking_code VARCHAR(100) DEFAULT NULL, estimated_delivery TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, note TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_3781EC108D9F6D38 ON delivery (order_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN delivery.id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN delivery.order_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE delivery_tracking (id UUID NOT NULL, delivery_id UUID NOT NULL, status VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, note TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C91D837012136921 ON delivery_tracking (delivery_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN delivery_tracking.id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN delivery_tracking.delivery_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE delivery ADD CONSTRAINT FK_3781EC108D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE delivery_tracking ADD CONSTRAINT FK_C91D837012136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE delivery DROP CONSTRAINT FK_3781EC108D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE delivery_tracking DROP CONSTRAINT FK_C91D837012136921
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE delivery
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE delivery_tracking
        SQL);
    }
}
