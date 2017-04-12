<?php

/**
 * Keyboard.php
 * Created for weather
 * 2017-03-22
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\telegrambot\Keyboard;

/**
 * Class Keyboard
 * @package app\components\telegrambot\Keyboard
 */
class Keyboard
{
    /**
     * Keyboard constructor.
     * @param AbstractKeyboard[] $keyboards
     * @param string $commandName
     * @return array|mixed
     */
    public static function get(array $keyboards, $commandName)
    {
        $commandName = strtolower($commandName);
        foreach ($keyboards as $keyboard) {
            if ($keyboard->isRelatedTo($commandName)) {
                $keyboard->setLastCommand($commandName);
                return $keyboard;
            }
        }

        return null;
    }
}
