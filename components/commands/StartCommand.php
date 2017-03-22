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

class StartCommand extends AbstractCommand
{
    /** @var string Command Description */
    protected $description = 'Start command';

    public function getText()
    {
        return <<<TEXT
Hi {$this->getUserName()}!
I'm the Weather bot and I'm here to help you to dress for the weather.
TEXT;
    }

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
