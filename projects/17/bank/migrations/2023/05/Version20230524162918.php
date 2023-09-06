<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230524162918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[init] create base tables: banks_cards, payments.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<PGSQL
            CREATE TABLE banks_cards (
                id UUID NOT NULL,
                number VARCHAR(16) NOT NULL,
                expiration_at DATE NOT NULL,
                cvv VARCHAR(3) NOT NULL,
                holder VARCHAR(255) DEFAULT NULL,
                PRIMARY KEY(id)
            )
        PGSQL);
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A682C8F496901F54 ON banks_cards (number)');
        $this->addSql('COMMENT ON TABLE banks_cards IS \'Банковские карты.\'');
        $this->addSql('COMMENT ON COLUMN banks_cards.id IS \'Идентификатор.(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN banks_cards.number IS \'Номер карты.(DC2Type:bank_card_number)\'');
        $this->addSql('COMMENT ON COLUMN banks_cards.expiration_at IS \'Месяц/год окончания действия карты(DC2Type:bank_card_expiry)\'');
        $this->addSql('COMMENT ON COLUMN banks_cards.cvv IS \'Код с обратной стороны карты(DC2Type:bank_card_cvv)\'');
        $this->addSql('COMMENT ON COLUMN banks_cards.holder IS \'Владелец карты, имя и фамилия латиницей, может также содержать дефис(DC2Type:bank_card_holder)\'');

        $this->addSql(<<<PGSQL
            CREATE TABLE payments (
                id UUID NOT NULL,
                card_id UUID NOT NULL,
                status INT DEFAULT 0 NOT NULL,
                amount VARCHAR(255) DEFAULT NULL,
                PRIMARY KEY(id)
            )
        PGSQL);
        $this->addSql('CREATE INDEX IDX_65D29B324ACC9A20 ON payments (card_id)');
        $this->addSql('COMMENT ON TABLE payments IS \'Платежи.\'');
        $this->addSql('COMMENT ON COLUMN payments.id IS \'Идентификатор.(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN payments.card_id IS \'Идентификатор.(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN payments.status IS \'Статус платежа.\'');
        $this->addSql('COMMENT ON COLUMN payments.amount IS \'Сумма платежа.(DC2Type:money_amount)\'');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B324ACC9A20 FOREIGN KEY (card_id) REFERENCES banks_cards (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE payments DROP CONSTRAINT FK_65D29B324ACC9A20');
        $this->addSql('DROP TABLE banks_cards');
        $this->addSql('DROP TABLE payments');
    }
}
