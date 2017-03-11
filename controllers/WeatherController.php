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

use app\components\telegrambot\Api;
use yii\rest\Controller;

class WeatherController extends Controller
{
    /**
     * @var Api
     */
    protected $_weatherBot;

    public function actionIndex()
    {
        $this->_weatherBot = \Yii::$app->bot;
        $this->_weatherBot->commandsHandler();
    }
}
