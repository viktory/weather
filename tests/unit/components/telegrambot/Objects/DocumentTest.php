<?php
/**
 * DocumentTest.php
 * Created for weather
 * 2017-04-23
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace tests\unit\components\telegrambot\Objects;

use app\components\telegrambot\Objects\Document;
use app\components\telegrambot\Objects\PhotoSize;
use Codeception\Util\Stub;
use tests\unit\AbstractTest;

/**
 * Class DocumentTest
 * @package tests\unit\components\telegrambot\Objects
 */
class DocumentTest extends AbstractTest
{
    /** @var array */
    protected $data;

    /** @inheritdoc */
    protected function setUp()
    {
        $photoSize = Stub::construct(PhotoSize::class, [(object)[
            'file_id' => 'fileId',
            'width' => 100,
            'height' => 200,
            'file_size' => 12,
        ]]);

        $this->data = [
            'file_id' => 'fileId',
            'thumb' => $photoSize,
            'file_name' => 'fileName',
            'mime_type' => 'mimeType',
            'file_size' => 12,
        ];

        return parent::setUp();
    }

    public function testGetMethods()
    {
        /** @var Document $document */
        $document = Stub::construct(Document::class, [(object)$this->data]);

        $this->specify('document fields are correct', function () use ($document) {
            $this->assertEquals($this->data['file_id'], $document->getFileId());
            $trumb = $document->getThumb();
            $this->assertInstanceOf(PhotoSize::class, $trumb);
            $this->assertEquals($this->data['file_name'], $document->getFileName());
            $this->assertEquals($this->data['mime_type'], $document->getMimeType());
            $this->assertEquals($this->data['file_size'], $document->getFileSize());
        });
    }
}
