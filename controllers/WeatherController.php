<?php
/**
 * WeatherController.php
 * Created for weather
 * 2017-03-11
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\controllers;

use ApiErrorHandler\ApiErrorHandler;
use app\components\commands\ServerErrorCommand;
use app\components\telegrambot\Api;
use yii\rest\Controller;

class WeatherController extends Controller
{
    /**
     * @var Api
     */
    protected $weatherBot;

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->weatherBot = \Yii::$app->bot;
        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    public function actionIndex()
    {
        $this->weatherBot->commandsHandler();

        return [
            'status' => $this->weatherBot->lastExecuteStatus
        ];
    }

    /**
     * @return array
     */
    public function actionError()
    {
        $errorText = 'Oops, there was an error inside of me. But I am already being fixed. Please write me later.';
        $lastUpdate = $this->weatherBot->getWebhookUpdates();
        $chat_id = $lastUpdate->getMessage()->getChat()->getId();
        $lastMessage = $this->weatherBot->sendMessage([
            'text' => $errorText,
            'chat_id' => $chat_id
        ]);
        return [
            'status' => $lastMessage
        ];
    }
}
