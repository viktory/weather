<?php
/**
 * AskLocationTrait.php
 * Created for weather
 * 2017-03-27
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\commands;

use app\components\telegrambot\Api;
use app\components\telegrambot\Exceptions\TelegramSDKException;

trait AskLocationTrait
{
    /** @var bool */
    protected $needLocation = true;

    /** @var string */
    protected $locationCommandName = 'location';

    /**
     * @return bool
     * @throws \app\components\telegrambot\Exceptions\TelegramSDKException
     */
    public function isLocationEmpty()
    {
        $telegram = $this->getTelegram();
        if (!isset($telegram)) {
            throw new TelegramSDKException('Telegram Api class must be specified');
        }
        if (!($telegram instanceof Api)) {
            throw new TelegramSDKException('Telegram Api class must instance of ' . Api::class);
        }

        if (isset($this->needLocation) && ($this->needLocation === true)) {
            $user = $telegram->getUser();
            if (isset($user) && !$user->hasLocation()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return null|string
     */
    public function runAnotherCommand()
    {
        if ($this->isLocationEmpty()) {
            return $this->locationCommandName;
        }

        return null;
    }
}
