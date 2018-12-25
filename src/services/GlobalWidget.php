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

use wbrowar\communicator\models\GlobalWidget as GlobalWidgetModel;

use Craft;
use craft\base\Component;
use wbrowar\communicator\records\GlobalWidgets;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class GlobalWidget extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Communicator::$plugin->changelog->deleteContent()
     *
     * @param int $id
     * @return bool
     */
    public function deleteContent(int $id = null):bool
    {
        if ($id ?? false) {
            $record = GlobalWidgets::findOne(['id' => intval($id)]);

            $delete = $record->delete();

            return $delete;
        }

        return false;
    }

    /**
     * Communicator::$plugin->changelog->getContent()
     *
     * @param array $params
     * @param string $queryType
     * @return string
     */
    public function getContent(array $params = [], string $queryType = 'all')
    {
        if ($params['limit'] ?? false) {
            $limit = $params['limit'];
            unset($params['limit']);
        } else {
            $limit = null;
        }

        if ($params['orderBy'] ?? false) {
            $orderBy = $params['orderBy'];
            unset($params['orderBy']);
        } else {
            $orderBy = 'dateCreated desc';
        }

        $params['siteId'] = $params['siteId'] ?? Craft::$app->sites->currentSite->id;

        switch ($queryType) {
            case 'all':
                $record = GlobalWidgets::find()->where($params)->limit($limit)->orderBy($orderBy)->all();
                break;
            case 'one':
                $record = GlobalWidgets::find()->where($params)->orderBy($orderBy)->one();
                break;
            case 'count':
                $record = GlobalWidgets::find()->where($params)->count();
                break;
        }

        return $record ?? null;
    }

    /**
     * Communicator::$plugin->changelog->saveContent()
     *
     * @param ChangelogModel $model
     * @param int $id
     * @return int
     */
    public function saveContent(GlobalWidgetModel $model, int $id = null):int
    {
        if ($id ?? false) {
            $record = GlobalWidgets::findOne(['id' => $id]);
        } else {
            $record = new GlobalWidgets();
        }

        $record->content = $model->content;
        $record->format = $model->format;
        $record->templatePath = $model->templatePath;
        $record->title = $model->title;
        $record->siteId = Craft::$app->sites->currentSite->id;

        $record->save();

        return $record->id;
    }
}
