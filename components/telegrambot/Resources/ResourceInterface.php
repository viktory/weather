<?php
/**
 * ResourceInterface.php
 * Created for weather
 * 2017-03-25
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\telegrambot\Resources;

/**
 * Interface ResourceInterface
 * @package app\components\telegrambot\Resources
 */
interface ResourceInterface
{
    /** @return string */
    public function getName();

    /** @return string */
    public function getLowerName();

    /** @return string */
    public function getType();
}
