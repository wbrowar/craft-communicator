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
use wbrowar\communicator\models\Changelog;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class ChangelogController extends Controller
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
    public function actionAddLog()
    {
        $params = Craft::$app->getRequest()->getBodyParams();

        $log = new Changelog([
            'content' => $params['content'],
            'date' => $params['date'],
            'version' => $params['version'],
        ]);

        $save = Communicator::$plugin->changelog->saveLog($log);

        return $this->redirectToPostedUrl();
    }

    /**
     * @return mixed
     */
    public function actionDeleteLog()
    {
        $response = ['result' => 'error'];
        $params = Craft::$app->getRequest()->getBodyParams();

        $delete = Communicator::$plugin->changelog->deleteLog($params['id']);

        if ($delete) {
            $response['result'] = 'success';
        }

        return $this->asJson($response);
//        $log = new Changelog([
//            'content' => $params['content'],
//            'date' => $params['date'],
//            'version' => $params['version'],
//        ]);
//
//        $save = Communicator::$plugin->changelog->saveLog($log);
//
//        return $this->redirectToPostedUrl();
    }
}
