<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator\widgets;

use wbrowar\communicator\Communicator;
use wbrowar\communicator\assetbundles\communicator\CommunicatorAsset;

use Craft;
use craft\base\Widget;

/**
 * Communicator Widget
 *
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class Changelog extends Widget
{

    // Public Properties
    // =========================================================================

    /**
     * @var string The message to display
     */
    public $totalLogs = 1;

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('communicator', 'Changelog');
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@wbrowar/communicator/assetbundles/communicator/dist/icon/close.svg");
    }

    /**
     * @inheritdoc
     */
    public static function maxColspan()
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge(
            $rules,
            [
                ['totalLogs', 'integer'],
                ['totalLogs', 'default', 'value' => 1],
            ]
        );
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'communicator/_components/widgets/Changelog_settings',
            [
                'widget' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml()
    {
        if (Communicator::$plugin->getSettings()->enableChangelog) {
            Craft::$app->getView()->registerAssetBundle(CommunicatorAsset::class);

            $total = $this->totalLogs > 0 ? $this->totalLogs : 1;

            return Craft::$app->getView()->renderTemplate(
                'communicator/_components/widgets/Changelog_body',
                [
                    'logs' => Communicator::$plugin->changelog->getLogs(['limit' => $total]),
                ]
            );
        } else {
            return 'Changelog has been disabled. You may remove this widget.';
        }
    }
}
