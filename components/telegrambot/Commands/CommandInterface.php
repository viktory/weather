<?php

namespace app\components\telegrambot\Commands;

use app\components\telegrambot\Api;
use app\components\telegrambot\Objects\Update;

/**
 * Interface CommandInterface
 * @package app\components\telegrambot\Commands
 */
interface CommandInterface
{
    /**
     * Process Inbound Command.
     * @param Api $telegram
     * @param array $arguments
     * @param Update $update
     * @param array $keyboard
     * @return mixed
     */
    public function make(Api $telegram, array $arguments, Update $update, array $keyboard);

    /**
     * Process the command.
     * @param array $arguments
     * @return mixed
     */
    public function handle(array $arguments);
}
