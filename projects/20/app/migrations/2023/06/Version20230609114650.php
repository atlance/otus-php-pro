<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230609114650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[init] created table `banks_statements`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<PGSQL
            CREATE TABLE banks_statements (
                id UUID NOT NULL,
                email VARCHAR(255) NOT NULL,
                start_at DATE NOT NULL,
                end_at DATE NOT NULL,
                status INT DEFAULT 0 NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY(id)
            )
        PGSQL);
        $this->addSql(
            'CREATE UNIQUE INDEX UNIQ_FE53102DE7927C74B75363F737D3107C ON banks_statements (email, start_at, end_at)'
        );
        $this->addSql('COMMENT ON TABLE banks_statements IS \'Банковские выписки.\'');
        $this->addSql('COMMENT ON COLUMN banks_statements.id IS \'Идентификатор.(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN banks_statements.email IS \'Адрес электронной почты.(DC2Type:email)\'');
        $this->addSql('COMMENT ON COLUMN banks_statements.start_at IS \'Дата начала.\'');
        $this->addSql('COMMENT ON COLUMN banks_statements.end_at IS \'Дата окончания.\'');
        $this->addSql('COMMENT ON COLUMN banks_statements.status IS \'Статус выписки.\'');
        $this->addSql(<<<PGSQL
            COMMENT ON COLUMN banks_statements.created_at IS 'Дата и время создания.(DC2Type:datetime_immutable)'
        PGSQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE banks_statements');
    }
}
