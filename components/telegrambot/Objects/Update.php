<?php

namespace app\components\telegrambot\Objects;

/**
 * Class Update
 * @package app\components\telegrambot\Objects
 * @method int getUpdateId() The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially.
 * @method Message getMessage() (Optional). New incoming message of any kind - text, photo, sticker, etc.
 * @method Message getEditedMessage() (Optional). Edited message of any kind - text, photo, sticker, etc.
 */
class Update extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'message' => Message::class,
        ];
    }

    /**
     * Get recent message.
     * @return Update
     */
    public function recentMessage()
    {
        return new static($this->last());
    }

    /**
     * @return int
     */
    public function getChatId()
    {
        $message = $this->getMessage();
        if (!isset($message)) {
            $message = $this->getEditedMessage();
        }

        return $message->getChat()->getId();
    }
}
