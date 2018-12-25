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
class Settings extends Model
{
    // Public Properties
    // =========================================================================


    /**
     * A list of emails and available for use in the Email Supports widget
     *
     * @var array
     */
    public $emailSupportContacts = [];

    /**
     * @var bool
     */
    public $enableChangelog = true;

    /**
     * @var bool
     */
    public $enableEmailSupport = true;

    /**
     * Enables display and functionality of the form in the Email Support widget
     *
     * @var bool
     */
    public $enableEmailSupportForm = true;

    /**
     * @var bool
     */
    public $enableGlobalWidget = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            ['someAttribute', 'string'],
//            ['someAttribute', 'default', 'value' => 'Some Default'],
//        ];
//    }
}
