<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator\variables;

use wbrowar\communicator\Communicator;

use Craft;

/**
 * Communicator Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.communicator }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class CommunicatorVariable
{
    // Public Methods
    // =========================================================================

    /**
     * {{ craft.communicator.getAllLogs }}
     *
     * @return mixed
     */
    public function getChanglogs(array $params = [], string $queryType = 'all')
    {
        return Communicator::$plugin->changelog->getLogs($params, $queryType);
    }

    /**
     * {{ craft.communicator.getGlobalWidgetContent }}
     *
     * @return mixed
     */
    public function getGlobalWidget(array $params = [], string $queryType = 'all')
    {
        return Communicator::$plugin->globalWidget->getContent($params, $queryType);
    }

    /**
     * {{ craft.communicator.getNextSemver }}
     *
     * @return string
     */
    public function getNextSemver()
    {
        $latestLog = Communicator::$plugin->changelog->getLogs([], 'one');

        $currentSemver = ($latestLog ?? false) ? $latestLog->version : '1.0.0';

        return $currentSemver;
    }

    /**
     * {{ craft.communicator.parsePhoneNumber }}
     *
     * @return string
     */
    public function parsePhoneNumber($number)
    {
        return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $number);
    }
}
