<?php
/**
 * ResourceTrait.php
 * Created for weather
 * 2017-03-25
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\telegrambot\Resources;

use app\components\telegrambot\Exceptions\TelegramSDKException;

/**
 * Class ResourceTrait
 * @package app\components\telegrambot\Resources
 */
trait ResourceTrait
{
    protected $name;

    /**
     * ResourceTrait constructor.
     * @throws \app\components\telegrambot\Exceptions\TelegramSDKException
     */
    public function __construct()
    {
        if (!isset($this->name)) {
            $reflect = new \ReflectionClass($this);
            $className = $reflect->getShortName();
            $type = $this->getType();
            if (substr($className, -strlen($type)) !== $type) {
                throw new TelegramSDKException(get_class($this) . ' must have a $name');
            }
            $className = preg_replace('/' . $type . '$/', '', $className);
            $this->name = trim($className);
        }
    }

    /**
     * Get Command Name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Command Name in lower case
     * @return string
     */
    public function getLowerName()
    {
        return strtolower($this->name);
    }
}
