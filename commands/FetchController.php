<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Entry;
use Yii;
use yii\db\Exception;
use yii\httpclient\Client;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Get latest 100 entries from the BRDO REST-api
 *
 * Gets latest 100 entries from the BRDO REST-api and if they are retrieved successfully the
 * relevant DB-table is truncated and filled with retrieved values
 *
 */
class FetchController extends Controller
{
    /**
     * Get latest 100 entries from the BRDO REST-api.
     * @param string $action default value is 'update' to update database table
     * @return int Exit code
     */
    public function actionIndex($action = 'update')
    {
        $client = new Client();
        $items = [];
        $brdo_api_url = Yii::$app->params['brdo_api_url'];
        $brdo_api_key = Yii::$app->params['brdo_api_key'];

        for ($i = 1; $i <= 2; $i++) {
            $page = $i;
            try {
                $response = $client->createRequest()
                    ->setMethod('GET')
                    ->setUrl($brdo_api_url . '?apiKey=' . $brdo_api_key . '&page=' . $page)
                    ->send();
            } catch (\Exception $e) {
                echo 'HttpClient exception ' . $e->getMessage();
                return ExitCode::UNSPECIFIED_ERROR;
            }
            if ($response->isOk) {
                $items = array_merge($items, $response->data['items']);
            } else {
                echo 'Response to the API failed';
                return ExitCode::UNSPECIFIED_ERROR;
            }
        }
        Yii::$app->db->createCommand()->truncateTable('entry')->execute();
        $i = 1;
        foreach($items as $item) {
            $entry = new Entry();
            $entry->id = $item['id'];
            $entry->internal_id = $item['internal_id'];
            $entry->regulator = $item['regulator'];

            if (preg_match('/([0-9]{2})-([0-9]{2})-([0-9]{4}) ([0-9]{2}:[0-9]{2})/', $item['last_modify'], $matches) === 1){
                $entry->last_modify = $matches[3] . '-' . $matches[2] . '-' . $matches[1] . ' ' . $matches[4];
            } else {
                throw new Exception('Error on converting date format');
            }

            $entry->save();
            echo "New entry added to the database\n";
            echo $i . ' - ' . $item['id'] . ' - ' . $item['internal_id'] . ' - ' . $item['last_modify'] . ' - ' . $item['regulator'] . "\n";
            $i++;
        }

        return ExitCode::OK;
    }
}
