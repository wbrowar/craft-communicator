<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator;

use craft\events\RegisterCpNavItemsEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;
use craft\web\twig\variables\Cp;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use craft\web\View;
use wbrowar\communicator\services\GlobalWidget as GlobalWidgetService;
use wbrowar\communicator\services\Changelog as ChangelogService;
use wbrowar\communicator\services\EmailSupport as EmailSupportService;
use wbrowar\communicator\variables\CommunicatorVariable;
use wbrowar\communicator\models\Settings;
use wbrowar\communicator\widgets\GlobalWidget as GlobalWidgetWidget;
use wbrowar\communicator\widgets\Changelog as ChangelogWidget;
use wbrowar\communicator\widgets\EmailSupport as EmailSupportWidget;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Dashboard;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class Communicator
 *
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 *
 * @property  GlobalWidgetService $globalWidget
 * @property  ChangelogService $changelog
 * @property  EmailSupportService $emailSupport
 */
class Communicator extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Communicator
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var bool
     */
    public $hasCpSection = true;

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        if (Craft::$app->getEdition() > 0) {
            Event::on(UserPermissions::class, UserPermissions::EVENT_REGISTER_PERMISSIONS, function(RegisterUserPermissionsEvent $event) {
                $event->permissions[\Craft::t('communicator', 'Communicator')] = [
                    'editChangelogs' => ['label' => \Craft::t('communicator', 'Edit Changelogs')],
                    'editGlobalWidgets' => ['label' => \Craft::t('communicator', 'Edit Global Widget')],
                ];
            });
        }

        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) {
                if ($this->getSettings()->enableChangelog && Craft::$app->getUser()->checkPermission('accessPlugin-communicator')) {
                    $event->navItems[] = [
                        'url' => 'communicator/changelog',
                        'label' => 'Changelog',
//                    'icon' => '@ns/prefix/path/to/icon.svg',
                    ];
                }
                if ($this->getSettings()->enableGlobalWidget && Craft::$app->getUser()->checkPermission('accessPlugin-communicator') && Craft::$app->getUser()->checkPermission('editGlobalWidgets')) {
                    $event->navItems[] = [
                        'url' => 'communicator/global-widget',
                        'label' => 'Global Widget',
//                    'icon' => '@ns/prefix/path/to/icon.svg',
                    ];
                }
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                if ($this->getSettings()->enableChangelog) {
                    $event->rules['communicator/changelog'] = ['template' => 'communicator/page_changelog'];
                    $event->rules['communicator/changelog/add-log'] = 'communicator/changelog/add-log';
                    $event->rules['communicator/changelog/delete-log'] = 'communicator/changelog/delete-log';
                }
                if ($this->getSettings()->enableEmailSupport) {
                    $event->rules['communicator/email-support/send-email'] = 'communicator/email-support/send-email';
                }
                if ($this->getSettings()->enableGlobalWidget) {
                    $event->rules['communicator/global-widget'] = ['template' => 'communicator/page_global_widget'];
                    $event->rules['communicator/global-widget/update-content'] = 'communicator/global-widget/update-content';
                }
            }
        );

        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
                if ($this->getSettings()->enableChangelog) {
                    $event->types[] = ChangelogWidget::class;
                }
                if ($this->getSettings()->enableEmailSupport) {
                    $event->types[] = EmailSupportWidget::class;
                }
                if ($this->getSettings()->enableGlobalWidget) {
                    $event->types[] = GlobalWidgetWidget::class;
                }
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('communicator', CommunicatorVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        if (Craft::$app->getView()->getTemplateMode() === View::TEMPLATE_MODE_CP) {
            Event::on(View::class, View::EVENT_BEFORE_RENDER_TEMPLATE, function() {
                Craft::$app->getView()->registerJs('window.WBJsDevMode = window.WBJsDevMode || ' . (Craft::$app->getConfig()->getGeneral()->devMode ? 'true' : 'false') . ';', 1);
            });
        }

        Craft::info(
            Craft::t(
                'communicator',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    public function getCpNavItem()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'communicator/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
