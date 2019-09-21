<?php

namespace InstitutionBundle\Migrations\Schema;

use AccountancyBundle\Migrations\Schema\AccountancyBundleInstaller;
use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class InstitutionBundleInstaller implements Installation
{
    const INSTITUTION_TABLE_NAME        = 'fnz_institution';
    const ACCOUNT_TABLE_NAME            = 'fnz_account';
    const ADDRESS_TABLE_NAME            = 'fnz_address';
    const USER_TABLE_NAME               = 'oro_user';
    const DICTIONARY_COUNTRY_TABLE_NAME = 'oro_dictionary_country';
    const DICTIONARY_REGION_TABLE_NAME  = 'oro_dictionary_region';

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
        $this->createInstitutionTable($schema);
        $this->createAccountTable($schema);
        $this->createAddressTable($schema);

        /** Extern tables */
        AccountancyBundleInstaller::createBookTable($schema);

        /** Foreign keys generation **/
        $this->addInstitutionForeignKeys($schema);
        $this->addAccountForeignKeys($schema);
        $this->addAddressForeignKeys($schema);
    }

    /**
     * Create fnz_institution table
     *
     * @param Schema $schema
     */
    protected function createInstitutionTable(Schema $schema)
    {
        $table = $schema->createTable(self::INSTITUTION_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('address_id',                 'integer', ['notnull' => false]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('name',                       'string',  ['notnull' => true, 'length' => 100]);
        $table->addColumn('branch_number',              'string',  ['notnull' => true, 'length' =>  11]);
        $table->addColumn('bic',                        'string',  ['notnull' => true, 'length' =>  11, 'default' => NULL]);
        $table->addColumn('iban',                       'string',  ['notnull' => true, 'length' => 100, 'default' => NULL]);
        $table->addColumn('created_at',                 'datetime',['default' => NULL]);
        $table->addColumn('updated_at',                 'datetime',['default' => NULL]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name']);
        $table->addUniqueIndex(['bic']);
        $table->addUniqueIndex(['iban']);
        $table->addIndex(['address_id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

    /**
     * Create fnz_account table
     *
     * @param Schema $schema
     */
    protected function createAccountTable(Schema $schema)
    {
        $table = $schema->createTable(self::ACCOUNT_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('parent_account_id',          'integer', ['notnull' => false]);
        $table->addColumn('institution_id',             'integer', ['notnull' => false]);
        $table->addColumn('book_id',                    'integer', ['notnull' => false]);
        $table->addColumn('created_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id',         'integer', ['notnull' => false]);
        $table->addColumn('name',                       'string',  ['notnull' => true, 'length' => 255]);
        $table->addColumn('number',                     'string',  ['notnull' => true, 'length' =>  11, 'default' => NULL]);
        $table->addColumn('currency',                   'string',  ['notnull' => false, 'length' =>   3, 'default' => NULL]);
        $table->addColumn('opening_date',               'datetime',[]);
        $table->addColumn('opening_balance',            'decimal', ['notnull' => false,'scale'  =>   4, 'precision' => 19, 'default' => NULL]);
        $table->addColumn('accounting_type',            'integer', ['notnull' => false]);
        $table->addColumn('type',                       'integer', ['notnull' => false]);
        $table->addColumn('is_favorite',                'boolean', ['notnull' => false]);
        $table->addColumn('created_at',                 'datetime',[]);
        $table->addColumn('updated_at',                 'datetime',[]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name']);
        $table->addUniqueIndex(['number']);
        $table->addUniqueIndex(['book_id']);
        $table->addIndex(['parent_account_id']);
        $table->addIndex(['institution_id']);
        $table->addIndex(['book_id']);
        $table->addIndex(['created_by_user_id']);
        $table->addIndex(['updated_by_user_id']);
    }

    /**
     * Create fnz_address table
     *
     * @param Schema $schema
     */
    protected function createAddressTable(Schema $schema)
    {
        $table = $schema->createTable(self::ADDRESS_TABLE_NAME);
        $table->addColumn('id',                         'integer', ['notnull' => true, 'autoincrement' => true]);
        $table->addColumn('country_code',               'string',  ['notnull' => true, 'length' =>   2, 'default' => NULL]);
        $table->addColumn('region_code',                'string',  ['notnull' => true, 'length' =>  16, 'default' => NULL]);
        $table->addColumn('label',                      'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('street',                     'string',  ['notnull' => false,'length' => 500]);
        $table->addColumn('street2',                    'string',  ['notnull' => false,'length' => 500]);
        $table->addColumn('city',                       'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('postal_code',                'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('region_text',                'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('organization',               'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('name_prefix',                'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('first_name',                 'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('middle_name',                'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('last_name',                  'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('name_suffix',                'string',  ['notnull' => false,'length' => 255]);
        $table->addColumn('created',                    'datetime',[]);
        $table->addColumn('updated',                    'datetime',[]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['region_code']);
        $table->addIndex(['country_code']);
    }

    /**
     * Add fnz_institution foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addInstitutionForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::INSTITUTION_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::ADDRESS_TABLE_NAME),
            ['address_id'],
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
     * Add fnz_account foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function addAccountForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::ACCOUNT_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::INSTITUTION_TABLE_NAME),
            ['institution_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::ACCOUNT_TABLE_NAME),
            ['parent_account_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(AccountancyBundleInstaller::BOOK_TABLE_NAME),
            ['book_id'],
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
     * Add fnz_address foreign keys.
     *
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    protected function addAddressForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::ADDRESS_TABLE_NAME);
        $table->addForeignKeyConstraint(
            $schema->getTable(self::DICTIONARY_COUNTRY_TABLE_NAME),
            ['country_code'],
            ['iso2_code'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable(self::DICTIONARY_REGION_TABLE_NAME),
            ['region_code'],
            ['combined_code'],
            ['onDelete' => null, 'onUpdate' => null]
        );
    }
}
