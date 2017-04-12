<?php

namespace app\components\telegrambot\Commands;

use app\components\telegrambot\Keyboard\AbstractKeyboard;
use app\components\telegrambot\Objects\Update;

/**
 * Interface CommandInterface
 * @package app\components\telegrambot\Commands
 */
interface CommandInterface
{
    /**
     * Process Inbound Command.
     * @param array $arguments
     * @param Update $update
     * @param AbstractKeyboard $keyboard
     * @return mixed
     */
    public function make(array $arguments, Update $update, AbstractKeyboard $keyboard);

    /**
     * Process the command.
     * @param array $arguments
     * @return mixed
     */
    public function handle(array $arguments);
}
