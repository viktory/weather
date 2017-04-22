<?php
/**
 * SaveLocationCommand.php
 *
 * @project weather_bot
 * @since 17.04.2017
 * @author Viktory Lysenko <lysenkoviktory@gmail.com>
 * @copyright Copyright (c) 2016, Viktory Lysenko
 */

namespace app\components\commands;

use app\components\telegrambot\Commands\AbstractCommand;

class SaveLocationCommand extends AbstractCommand
{
    /** @var string Command Description */
    protected $description = 'Location saved successfully';

    /** @var string */
    protected $cantSaveLocationCommandName = 'cantSaveLocation';

    /**
     * @return null|string
     */
    public function runAnotherCommand()
    {
        $telegram = $this->getTelegram();
        $user = $telegram->getUser();
        $locationCommand = new LocationCommand();

        if ($user->command !== $locationCommand->getName()) {
            return $this->cantSaveLocationCommandName;
        }

        return null;
    }
}
