<?php

namespace AccountancyBundle\Migrations\Schema;

use InstitutionBundle\Migrations\Schema\InstitutionBundleInstaller;
use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AccountancyBundleInstaller implements Installation
{
    const RECORD_TABLE_NAME                     = 'fnz_record';
    const BOOK_TABLE_NAME                       = 'fnz_book';
    const BENEFICIARY_TABLE_NAME                = 'fnz_beneficiary';
    const CATEGORY_TABLE_NAME                   = 'fnz_category';
    const TAG_TABLE_NAME                        = 'fnz_tag';
    const RECORD_TAG_TABLE_NAME                 = 'fnz_record_tag';
    const SCHEDULED_TRANSACTION_TABLE_NAME      = 'fnz_scheduled_transaction';
    const SCHEDULED_TRANSACTION_TAG_TABLE_NAME  = 'fnz_scheduled_transaction_tag';
    const USER_TABLE_NAME                       = 'oro_user';

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createRecordTable($schema);
        $this->createTagTable($schema);
        $this->createRecordTagTable($schema);
        $this->createScheduledTransactionTable($schema);
        $this->createScheduledTransactionTagTable($schema);
//        $this->createBookTable($schema);
        $this->createBeneficiaryTable($schema);
        $this->createCategoryTable($schema);

        /** Foreign keys generation **/
        $this->addRecordForeignKeys($schema);
        $this->addTagForeignKeys($schema);
        $this->addRecordTagForeignKeys($schema);
        $this->addScheduledTransactionTagForeignKeys($schema);
        $this->addBookForeignKeys($schema);
        $this->addBeneficiaryForeignKeys($schema);
        $this->addCategoryForeignKeys($schema);
    }

    /**
     * Create fnz_record table
     *
     * @param Schema $schema
     */
    protected function createRecordTable(Schema $schema)
    {
        $table = $schema->createTable(self::RECORD_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('book_id',                    'integer', ['notnull' => true ]);
        $table->addColumn('beneficiary_id',             'integer', ['notnull' => false]);
        $table->addColumn('category_id',                'integer', ['notnull' => false]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('memo',                       'string',  ['notnull' => true, 'length' => 1000]);
        $table->addColumn('status',                     'integer', ['notnull' => true, 'length' =>    3]);
        $table->addColumn('operation',                  'integer', ['notnull' => true, 'length' =>    3]);
        $table->addColumn('amount',                     'decimal', ['notnull' => false,'scale'  =>    4, 'precision' => 19, 'default' => NULL]);
        $table->addColumn('date',                       'datetime',[]);
        $table->addColumn('created_at',                 'datetime',[]);
        $table->addColumn('updated_at',                 'datetime',[]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['book_id']);
        $table->addIndex(['category_id']);
        $table->addIndex(['beneficiary_id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

    /**
     * Create fnz_tag table
     *
     * @param Schema $schema
     */
    protected function createTagTable(Schema $schema)
    {
        $table = $schema->createTable(self::TAG_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('name',                       'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('color',                      'string',  ['notnull' => true, 'length' =>   7]);
        $table->addColumn('created_at',                 'datetime',[]);
        $table->addColumn('updated_at',                 'datetime',[]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

    /**
     * Create fnz_record_tag table
     *
     * @param Schema $schema
     */
    protected function createRecordTagTable(Schema $schema)
    {
        $table = $schema->createTable(self::RECORD_TAG_TABLE_NAME);
        $table->addColumn('record_id',                  'integer', ['notnull' => true]);
        $table->addColumn('tag_id',                     'integer', ['notnull' => true]);
        $table->setPrimaryKey(['record_id', 'tag_id']);
    }

    /**
     * Create fnz_scheduled_transaction table
     *
     * @param Schema $schema
     */
    protected function createScheduledTransactionTable(Schema $schema)
    {
        $table = $schema->createTable(self::SCHEDULED_TRANSACTION_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('account_id',                 'integer', ['notnull' => true] );
        $table->addColumn('beneficiary_id',             'integer', ['notnull' => false]);
        $table->addColumn('category_id',                'integer', ['notnull' => false]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('name',                       'string',  ['notnull' => false, 'length' =>  255]);
        $table->addColumn('memo',                       'string',  ['notnull' => true,  'length' => 1000]);
        $table->addColumn('amount',                     'decimal', ['notnull' => false, 'scale'  =>    4, 'precision' => 19, 'default' => NULL]);
        $table->addColumn('payment_method',             'decimal', ['notnull' => false, 'scale'  =>    4, 'precision' => 19, 'default' => NULL]);
        $table->addColumn('frequency',                  'integer', ['notnull' => false]);
        $table->addColumn('frequency_type',             'integer', ['notnull' => false]);
        $table->addColumn('status',                     'integer', ['notnull' => false]);
        $table->addColumn('operation',                  'integer', ['notnull' => false]);
        $table->addColumn('is_approximate',             'boolean', ['notnull' => false]);
        $table->addColumn('is_last_day_of_the_month',   'boolean', ['notnull' => false]);
        $table->addColumn('is_register_automatic',      'boolean', ['notnull' => false]);
        $table->addColumn('is_finite_scheduling',       'boolean', ['notnull' => false]);
        $table->addColumn('last_transaction_date',      'datetime',[]);
        $table->addColumn('date',                       'datetime',[]);
        $table->addColumn('created_at',                 'datetime',[]);
        $table->addColumn('updated_at',                 'datetime',[]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['account_id']);
        $table->addIndex(['beneficiary_id']);
        $table->addIndex(['category_id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

    /**
     * Create fnz_scheduled_transaction_tag table
     *
     * @param Schema $schema
     */
    protected function createScheduledTransactionTagTable(Schema $schema)
    {
        $table = $schema->createTable(self::SCHEDULED_TRANSACTION_TAG_TABLE_NAME);
        $table->addColumn('scheduled_transaction_id',   'integer', ['notnull' => true]);
        $table->addColumn('tag_id',                     'integer', ['notnull' => true]);
        $table->setPrimaryKey(['scheduled_transaction_id', 'tag_id']);
    }

    /**
     * Create fnz_book table
     *
     * @param Schema $schema
     */
    public function createBookTable(Schema $schema)
    {
        $table = $schema->createTable(self::BOOK_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('name',                       'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('created_at',                 'datetime',[]);
        $table->addColumn('updated_at',                 'datetime',[]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

    /**
     * Create fnz_beneficiary table
     *
     * @param Schema $schema
     */
    protected function createBeneficiaryTable(Schema $schema)
    {
        $table = $schema->createTable(self::BENEFICIARY_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('category_id',                'integer', ['notnull' => false]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('name_prefix',                'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('first_name',                 'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('last_name',                  'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('name_suffix',                'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('email',                      'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('gender',                     'string',  ['notnull' => true, 'length' =>   8]);
        $table->addColumn('birthday',                   'datetime',[]);
        $table->addColumn('created_at',                 'datetime',[]);
        $table->addColumn('updated_at',                 'datetime',[]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['category_id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

    /**
     * Create fnz_category table
     *
     * @param Schema $schema
     */
    protected function createCategoryTable(Schema $schema)
    {
        $table = $schema->createTable(self::CATEGORY_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('parent_category_id',         'integer', ['notnull' => false]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('name',                       'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('type',                       'integer', ['notnull' => true, 'length' =>   3]);
        $table->addColumn('created_at',                 'datetime',[]);
        $table->addColumn('updated_at',                 'datetime',[]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['parent_category_id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

    /**
     * Add fnz_record foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addRecordForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::RECORD_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::BOOK_TABLE_NAME),
            ['book_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::BENEFICIARY_TABLE_NAME),
            ['beneficiary_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::CATEGORY_TABLE_NAME),
            ['category_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['updated_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['created_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add fnz_tag foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addTagForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::TAG_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['updated_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['created_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add fnz_record_tag foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addRecordTagForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::RECORD_TAG_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::RECORD_TABLE_NAME),
            ['record_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::TAG_TABLE_NAME),
            ['tag_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * Add fnz_scheduled_transaction foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addScheduledTransactionForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::SCHEDULED_TRANSACTION_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(InstitutionBundleInstaller::ACCOUNT_TABLE_NAME),
            ['account_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::BENEFICIARY_TABLE_NAME),
            ['beneficiary_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::CATEGORY_TABLE_NAME),
            ['category_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['updated_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['created_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add fnz_book foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addBookForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::BOOK_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['updated_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['created_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add fnz_beneficiary foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addBeneficiaryForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::BENEFICIARY_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::CATEGORY_TABLE_NAME),
            ['category_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['updated_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['created_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add fnz_category foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addCategoryForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::CATEGORY_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::CATEGORY_TABLE_NAME),
            ['parent_category_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['updated_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::USER_TABLE_NAME),
            ['created_by_user_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add fnz_scheduled_transaction_tag foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addScheduledTransactionTagForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::SCHEDULED_TRANSACTION_TAG_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::SCHEDULED_TRANSACTION_TABLE_NAME),
            ['scheduled_transaction_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::TAG_TABLE_NAME),
            ['tag_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

}
