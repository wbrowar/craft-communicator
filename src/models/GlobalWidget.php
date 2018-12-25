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
class GlobalWidget extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $content = '';

    /**
     * @var string
     */
    public $format = '';

    /**
     * @var string
     */
    public $templatePath = '';

    /**
     * @var string
     */
    public $title;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'format', 'templatePath', 'title'], 'string'],
        ];
    }
}
