<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator\migrations;

use wbrowar\communicator\Communicator;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%communicator_changelogs}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%communicator_changelogs}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull(),
                    'date' => $this->dateTime()->notNull(),
                    'format' => $this->string(8)->notNull()->defaultValue('markdown'),
                    'version' => $this->string(16)->notNull()->defaultValue(''),
                    'content' => $this->text(),
                ]
            );
        }

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%communicator_globalwidgets}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%communicator_globalwidgets}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull(),
                    'format' => $this->string(8)->notNull()->defaultValue('markdown'),
                    'templatePath' => $this->string(),
                    'title' => $this->string(255)->notNull()->defaultValue('Global Widget'),
                    'content' => $this->text(),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(
            null,
            '{{%communicator_changelogs}}',
            'date',
            false
        );
        $this->createIndex(
            null,
            '{{%communicator_changelogs}}',
            'format',
            false
        );
        $this->createIndex(
            null,
            '{{%communicator_changelogs}}',
            'version',
            false
        );
        $this->createIndex(
            null,
            '{{%communicator_changelogs}}',
            'content(255)',
            false
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }

        $this->createIndex(
            null,
            '{{%communicator_globalwidgets}}',
            'format',
            false
        );
        $this->createIndex(
            null,
            '{{%communicator_globalwidgets}}',
            'templatePath',
            false
        );
        $this->createIndex(
            null,
            '{{%communicator_globalwidgets}}',
            'title',
            false
        );
        $this->createIndex(
            null,
            '{{%communicator_globalwidgets}}',
            'content(255)',
            false
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%communicator_changelogs}}', 'siteId'),
            '{{%communicator_changelogs}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%communicator_globalwidgets}}', 'siteId'),
            '{{%communicator_globalwidgets}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%communicator_globalwidgets}}');

        $this->dropTableIfExists('{{%communicator_changelogs}}');
    }
}
