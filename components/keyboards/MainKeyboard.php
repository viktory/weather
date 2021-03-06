<?php

/**
 * MainKeyboard.php
 * Created for weather
 * 2017-03-25
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\keyboards;

use app\components\telegrambot\Keyboard\AbstractKeyboard;

/**
 * Class MainKeyboard
 * @package app\components\keyboards
 */
class MainKeyboard extends AbstractKeyboard
{
    protected $commands = ['start'];

    public function getButtons()
    {
        return [
            ['Today', 'Tomorrow'],
            ['Settings']//todo add rate_me btn
        ];
    }
}
