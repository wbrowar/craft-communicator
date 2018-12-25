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

use craft\helpers\DateTimeHelper;
use wbrowar\communicator\models\Changelog as ChangelogModel;

use Craft;
use craft\base\Component;
use wbrowar\communicator\records\Changelogs;

/**
 * @author    Will Browar
 * @package   Communicator
 * @since     1.0.0
 */
class Changelog extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Communicator::$plugin->changelog->deleteLog()
     *
     * @param int $id
     * @return bool
     */
    public function deleteLog(int $id = null):bool
    {
        if ($id ?? false) {
            $record = Changelogs::findOne(['id' => intval($id)]);

            $delete = $record->delete();

            return $delete;
        }

        return false;
    }

    /**
     * Communicator::$plugin->changelog->getLogs()
     *
     * @param array $params
     * @param string $queryType
     * @return string
     */
    public function getLogs(array $params = [], string $queryType = 'all')
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
            $orderBy = 'date desc, dateCreated desc';
        }

        $params['siteId'] = $params['siteId'] ?? Craft::$app->sites->currentSite->id;

        switch ($queryType) {
            case 'all':
                $record = Changelogs::find()->where($params)->limit($limit)->orderBy($orderBy)->all();
                break;
            case 'one':
                $record = Changelogs::find()->where($params)->orderBy($orderBy)->one();
                break;
            case 'count':
                $record = Changelogs::find()->where($params)->count();
                break;
        }

        return $record ?? null;
    }

    /**
     * Communicator::$plugin->changelog->saveLog()
     *
     * @param ChangelogModel $model
     * @param int $id
     * @return int
     */
    public function saveLog(ChangelogModel $model, int $id = null):int
    {
        if ($id ?? false) {
            $record = Changelogs::findOne(['id' => $id]);
        } else {
            $record = new Changelogs();
        }

        $record->content = $model->content;
        $record->date = DateTimeHelper::toIso8601($model->date);
        $record->version = $model->version;
        $record->siteId = Craft::$app->sites->currentSite->id;

        $record->save();

        return $record->id;
    }
}