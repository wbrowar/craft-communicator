<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator\services;

use wbrowar\communicator\Communicator;

use Craft;
use craft\base\Component;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class EmailSupport extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (Communicator::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
