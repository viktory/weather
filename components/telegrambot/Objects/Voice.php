<?php

namespace app\components\telegrambot\Objects;

/**
 * Class Voice
 * @package app\components\telegrambot\Objects
 * @method string   getFileId()     Unique identifier for this file.
 * @method int      getDuration()   Duration of the audio in seconds as defined by sender.
 * @method string   getMimeType()   (Optional). MIME type of the file as defined by sender.
 * @method int      getFileSize()   (Optional). File size.
 */
class Voice extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
