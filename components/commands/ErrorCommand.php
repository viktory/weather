<?php
/**
 * ErrorCommand.php
 *
 * @project weather_bot
 * @since 29.04.2016
 * @author Viktory Lysenko <lysenkoviktory@gmail.com>
 * @copyright Copyright (c) 2016, Viktory Lysenko
 */

namespace app\components\commands;

use app\components\telegrambot\Commands\AbstractCommand;

class ErrorCommand extends AbstractCommand
{
    /**
     * @var string Command Description
     */
    protected $description = 'Oops, I do not know this command...';

    /**
     * {@inheritdoc}
     */
    public function handle(array $arguments)
    {
        $this->replyWithMessage([
            'text' => $this->getText()
        ]);
        return true;
    }
}
