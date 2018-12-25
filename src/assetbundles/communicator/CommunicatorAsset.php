<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator\assetbundles\Communicator;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class CommunicatorAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@wbrowar/communicator/assetbundles/communicator/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/communicator.1.0.0.js',
        ];

        $this->css = [
            'css/communicator.1.0.0.css',
        ];

        parent::init();
    }
}