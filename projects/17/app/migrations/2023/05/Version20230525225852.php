<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230525225852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[init] create base table: orders.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<PGSQL
            CREATE TABLE orders (
                id UUID NOT NULL,
                number VARCHAR(16) NOT NULL,
                payment_id UUID NOT NULL,
                sum VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            )
        PGSQL);
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE96901F54 ON orders (number)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEE4C3A3BB ON orders (payment_id)');
        $this->addSql('COMMENT ON TABLE orders IS \'Заказы.\'');
        $this->addSql('COMMENT ON COLUMN orders.id IS \'Идентификатор.(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN orders.number IS \'Номер заказа.(DC2Type:order_number)\'');
        $this->addSql('COMMENT ON COLUMN orders.payment_id IS \'Идентификатор платежа.(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN orders.sum IS \'Сумма платежа.(DC2Type:money_amount)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE orders');
    }
}
