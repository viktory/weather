<?php
/**
 * AudioTest.php
 * Created for weather
 * 2017-04-23
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace tests\unit\components\telegrambot\Objects;

use app\components\telegrambot\Objects\Audio;
use Codeception\Util\Stub;
use tests\unit\AbstractTest;

/**
 * Class AudioTest
 * @package tests\unit\components\telegrambot\Objects
 */
class AudioTest extends AbstractTest
{

    /** @var array */
    protected $data;

    /** @inheritdoc */
    protected function setUp()
    {
        $this->data = [
            'file_id' => '123456',
            'duration' => 10,
            'performer' => 'file_performer',
            'title' => 'fileTitle',
            'mime_type' => 'Mb',
            'file_size' => 12
        ];

        return parent::setUp();
    }

    public function testGetMethods()
    {
        /** @var Audio $audio */
        $audio = Stub::construct(Audio::class, [(object)$this->data]);

        $this->specify('audio fields are correct', function () use ($audio) {
            $this->assertEquals($this->data['file_id'], $audio->getFileId());
            $this->assertEquals($this->data['duration'], $audio->getDuration());
            $this->assertEquals($this->data['performer'], $audio->getPerformer());
            $this->assertEquals($this->data['title'], $audio->getTitle());
            $this->assertEquals($this->data['mime_type'], $audio->getMimeType());
            $this->assertEquals($this->data['file_size'], $audio->getFileSize());
        });
    }
}
