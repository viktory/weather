<?php
/**
 * AbstractKeyboard.php
 * Created for weather
 * 2017-03-22
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\telegrambot\Keyboard;

use app\components\telegrambot\Exceptions\TelegramSDKException;
use app\components\telegrambot\Resources\ResourceInterface;
use app\components\telegrambot\Resources\ResourceTrait;

/**
 * Class AbstractKeyboard
 * @package app\components\telegrambot\Keyboard
 */
abstract class AbstractKeyboard implements ResourceInterface, KeyboardInterface
{
    const KEYBOARD = 'Keyboard';

    use ResourceTrait;

    /** @var string */
    protected $name;

    /** @var array */
    protected $commands = [];

    /** @var bool */
    protected $resizeKeyboard = true;

    /** @var bool */
    protected $oneTimeKeyboard = true;

    /**
     * AbstractKeyboard constructor.
     * @throws \app\components\telegrambot\Exceptions\TelegramSDKException
     */
    public function __construct()
    {
        $buttons = $this->getButtons();
        foreach ($buttons as $buttonsArray) {
            foreach ($buttonsArray as $button) {
                if (!is_string($button)) {
                    throw new TelegramSDKException("Button '$button' must be a string");
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::KEYBOARD;
    }

    /**
     * @param string $commandName
     * @return bool
     */
    public function isRelatedTo($commandName)
    {
        return in_array($commandName, $this->commands, true);
    }

    /**
     * @return bool
     */
    public function getResizeKeyboard()
    {
        return $this->resizeKeyboard;
    }

    /**
     * @param bool $resizeKeyboard
     */
    public function setResizeKeyboard($resizeKeyboard)
    {
        $this->resizeKeyboard = $resizeKeyboard;
    }

    /**
     * @return bool
     */
    public function getOneTimeKeyboard()
    {
        return $this->oneTimeKeyboard;
    }

    /**
     * @param bool $oneTimeKeyboard
     */
    public function setOneTimeKeyboard($oneTimeKeyboard)
    {
        $this->oneTimeKeyboard = $oneTimeKeyboard;
    }

    abstract public function getButtons();

    /**
     * @return string
     */
    public function get()
    {
        return json_encode([
            'keyboard' => $this->getButtons(),
            'resize_keyboard' => $this->resizeKeyboard,
            'one_time_keyboard' => $this->oneTimeKeyboard
        ]);
    }
}
