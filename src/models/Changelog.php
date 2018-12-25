<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator\models;

use wbrowar\communicator\Communicator;

use Craft;
use craft\base\Model;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class Changelog extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var DateTime
     */
    public $date = '';

    /**
     * @var string
     */
    public $content = '';

    /**
     * @var string
     */
    public $version = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'version'], 'string'],
            ['version', 'default', 'value' => '1.0.0'],
        ];
    }
}
