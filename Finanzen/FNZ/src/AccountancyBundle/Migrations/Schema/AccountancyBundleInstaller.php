<?php

namespace AccountancyBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AccountancyBundleInstaller implements Installation
{
    const LEDGER_LOG_TABLE_NAME   = 'fnz_ledger_log';
    const USER_TABLE_NAME         = 'oro_user';

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createLedgerLogTable($schema);
    }

    /**
     * Create fnz_institution table
     *
     * @param Schema $schema
     */
    protected function createLedgerLogTable(Schema $schema)
    {
        $table = $schema->createTable(self::LEDGER_LOG_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

}
