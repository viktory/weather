<?php

namespace app\components\telegrambot\Objects;

/**
 * Class Audio
 * @package app\components\telegrambot\Objects
 * @method string   getFileId()     Unique identifier for this file.
 * @method int      getDuration()   Duration of the audio in seconds as defined by sender.
 * @method string   getPerformer()  (Optional). Performer of the audio as defined by sender or by audio tags.
 * @method string   getTitle()      (Optional). Title of the audio as defined by sender or by audio tags.
 * @method string   getMimeType()   (Optional). MIME type of the file as defined by sender.
 * @method int      getFileSize()   (Optional). File size.
 */
class Audio extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
