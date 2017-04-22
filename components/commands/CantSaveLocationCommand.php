<?php
/**
 * CantSaveLocationCommand.php
 *
 * @project weather_bot
 * @since 18.04.2017
 * @author Viktory Lysenko <lysenkoviktory@gmail.com>
 * @copyright Copyright (c) 2016, Viktory Lysenko
 */

namespace app\components\commands;

use app\components\telegrambot\Commands\AbstractCommand;

class CantSaveLocationCommand extends AbstractCommand
{
    /** @var string Command Description */
    protected $description = 'Hmm ... looks like you sent me your location. If I need to save it,  please enter the command /save_location';
}
