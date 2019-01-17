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
class GlobalWidget extends Widget
{

    // Public Properties
    // =========================================================================

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('communicator', 'Global Widget');
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@wbrowar/communicator/assetbundles/communicator/dist/icon/icon-mask.svg");
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
//                ['message', 'default', 'value' => 'DEFAULT'],
            ]
        );
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return false;
//        return Craft::$app->getView()->renderTemplate(
//            'communicator/_components/widgets/GlobalWidget_settings',
//            [
//                'widget' => $this
//            ]
//        );
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml()
    {
        if (Communicator::$plugin->getSettings()->enableGlobalWidget) {
            Craft::$app->getView()->registerAssetBundle(CommunicatorAsset::class);

            return Craft::$app->getView()->renderTemplate(
                'communicator/_components/widgets/GlobalWidget_body',
                [
                    'globalWidget' => Communicator::$plugin->globalWidget->getContent([], 'one'),
                ]
            );
        } else {
            return 'Global Widget has been disabled. You may remove this widget.';
        }
    }
}