<?php
/**
 * TodayCommand.php
 *
 * @project weather_bot
 * @since 22.03.2017
 * @author Viktory Lysenko <lysenkoviktory@gmail.com>
 * @copyright Copyright (c) 2016, Viktory Lysenko
 */

namespace app\components\commands;

use app\components\telegrambot\Commands\AbstractCommand;

class TodayCommand extends AbstractCommand
{
    use AskLocationTrait;

    /** @var string Command Description */
    protected $description = 'Today forecast';

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
