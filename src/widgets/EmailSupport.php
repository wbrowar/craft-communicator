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
class EmailSupport extends Widget
{

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $contact = '';

    // Static Methods
    // =========================================================================

    /**
     * Returns whether the widget can be selected more than once.
     *
     * @return bool
     */
    protected static function allowMultipleInstances():bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('communicator', 'Email Support');
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
                ['contact', 'string'],
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
            'communicator/_components/widgets/EmailSupport_settings',
            [
                'communicatorSettings' => Communicator::$plugin->getSettings(),
                'widget' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml()
    {
        if (Communicator::$plugin->getSettings()->enableEmailSupport) {
            Craft::$app->getView()->registerAssetBundle(CommunicatorAsset::class);

            return Craft::$app->getView()->renderTemplate(
                'communicator/_components/widgets/EmailSupport_body',
                [
                    'communicatorSettings' => Communicator::$plugin->getSettings(),
                    'contact' => $this->contact
                ]
            );
        } else {
            return 'Email Support has been disabled. You may remove this widget.';
        }
    }
}
