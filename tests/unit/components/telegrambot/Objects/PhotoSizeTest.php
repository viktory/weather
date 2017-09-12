<?php
/**
 * PhotoSizeTest.php
 * Created for weather
 * 2017-04-23
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace tests\unit\components\telegrambot\Objects;

use app\components\telegrambot\Objects\PhotoSize;
use Codeception\Util\Stub;
use tests\unit\AbstractTest;

/**
 * Class PhotoSizeTest
 * @package tests\unit\components\telegrambot\Objects
 */
class PhotoSizeTest extends AbstractTest
{
    /** @var array */
    protected $data;

    /** @inheritdoc */
    protected function setUp()
    {
        $this->data = [
            'file_id' => 'fileId',
            'width' => 100,
            'height' => 200,
            'file_size' => 12,
        ];

        return parent::setUp();
    }

    public function testGetMethods()
    {
        /** @var PhotoSize $photoSize */
        $photoSize = Stub::construct(PhotoSize::class, [(object)$this->data]);

        $this->specify('photo size fields are correct', function () use ($photoSize) {
            $this->assertEquals($this->data['file_id'], $photoSize->getFileId());
            $this->assertEquals($this->data['width'], $photoSize->getWidth());
            $this->assertEquals($this->data['height'], $photoSize->getHeight());
            $this->assertEquals($this->data['file_size'], $photoSize->getFileSize());
        });
    }
}
