<?php

namespace app\components\telegrambot\Objects;

/**
 * Class Sticker
 * @package app\components\telegrambot\Objects
 * @method string       getFileId()     Unique identifier for this file.
 * @method int          getWidth()      Sticker width.
 * @method int          getHeight()     Sticker height.
 * @method PhotoSize    getThumb()      (Optional). Sticker thumbnail in .webp or .jpg format.
 * @method int          getFileSize()   (Optional). File size.
 */
class Sticker extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}
