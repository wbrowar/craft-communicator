<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator\records;

use wbrowar\communicator\Communicator;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class Changelogs extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%communicator_changelogs}}';
    }
}
