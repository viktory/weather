<?php

/**
 * LocationKeyboard.php
 * Created for weather
 * 2017-03-27
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\keyboards;

use app\components\telegrambot\Keyboard\AbstractKeyboard;

/**
 * Class LocationKeyboard
 * @package app\components\keyboards
 */
class LocationKeyboard extends AbstractKeyboard
{
    protected $commands = ['location'];

    public function getButtons()
    {
        return [
            ['Today', 'Tomorrow'],
            ['Settings']//todo add rate_me btn
        ];
    }
}
