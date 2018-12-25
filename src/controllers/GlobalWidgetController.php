<?php
/**
 * Communicator plugin for Craft CMS 3.x
 *
 * Widgets that provide content to several users from a single source.
 *
 * @link      https://wbrowar.com
 * @copyright Copyright (c) 2018 Will Browar
 */

namespace wbrowar\communicator\controllers;

use wbrowar\communicator\Communicator;

use Craft;
use craft\web\Controller;
use wbrowar\communicator\models\GlobalWidget;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class GlobalWidgetController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Not Found.';

        return $result;
    }

    /**
     * @return mixed
     */
    public function actionUpdateContent()
    {
        $params = Craft::$app->getRequest()->getBodyParams();

        $content = new GlobalWidget([
            'content' => $params['content'],
            'format' => $params['format'],
            'templatePath' => $params['templatePath'],
            'title' => $params['title'],
        ]);

        $id = $params['id'] ?? null;

        $save = Communicator::$plugin->globalWidget->saveContent($content, $id);

        return $this->redirectToPostedUrl();
    }
}
