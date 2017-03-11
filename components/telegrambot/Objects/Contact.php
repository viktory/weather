<?php

namespace app\components\telegrambot\Objects;

/**
 * Class Contact
 * @package app\components\telegrambot\Objects
 * @method string   getPhoneNumber()    Contact's phone number.
 * @method string   getFirstName()      Contact's first name.
 * @method string   getLastName()       (Optional). Contact's last name.
 * @method int      getUserId()         (Optional). Contact's user identifier in Telegram.
 */
class Contact extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
