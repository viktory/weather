<?php
/**
 * KeyboardTrait.php
 * Created for weather
 * 2017-03-25
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\telegrambot\Keyboard;

use app\components\telegrambot\Exceptions\TelegramSDKException;
use app\components\telegrambot\Resources\ResourceInterface;

/**
 * Class KeyboardTrait
 * @package app\components\telegrambot\Keyboard
 */
trait KeyboardTrait
{
    /** @var string */
    public $keyboardPath = null;

    /** @var AbstractKeyboard[] */
    protected $keyboards = [];

    public function init()
    {
        if (!empty($this->keyboardPath)) {
            $this->_loadKeyboards();
        }
    }

    /**
     * @param KeyboardInterface|string $keyboard
     * @return $this
     * @throws \app\components\telegrambot\Exceptions\TelegramSDKException
     */
    public function addKeyboard($keyboard)
    {
        if (!is_object($keyboard)) {
            $keyboard = $this->createResourceByClassName($keyboard);
        }

        if ($keyboard instanceof KeyboardInterface) {
            /** @var ResourceInterface $keyboard */
            $this->keyboards[$keyboard->getName()] = $keyboard;

            return $this;
        }

        throw new TelegramSDKException(
            sprintf(
                'Keyboard class "%s" should be an instance of "app\components\telegrambot\Keyboards\KeyboardInterface"',
                get_class($keyboard)
            )
        );
    }

    /**
     * @return AbstractKeyboard[]
     */
    public function getKeyboards()
    {
        return $this->keyboards;
    }

    private function _loadKeyboards()
    {
        if (method_exists($this, '_loadResource')) {
            $this->_loadResource(AbstractKeyboard::KEYBOARD, $this->keyboardPath, 'addKeyboard');
        }
    }
}
