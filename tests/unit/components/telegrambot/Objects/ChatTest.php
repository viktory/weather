<?php
/**
 * ChatTest.php
 * Created for weather
 * 2017-04-23
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace tests\unit\components\telegrambot\Objects;

use app\components\telegrambot\Objects\Chat;
use Codeception\Util\Stub;
use tests\unit\AbstractTest;

/**
 * Class ChatTest
 * @package tests\unit\components\telegrambot\Objects
 */
class ChatTest extends AbstractTest
{
    /** @var array */
    protected $data;

    /** @inheritdoc */
    protected function setUp()
    {
        $this->data = [
            'id' => 123456,
            'type' => 'chat_type',
            'title' => 'chat_title',
            'username' => 'user_name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name'
        ];

        return parent::setUp();
    }

    public function testGetMethods()
    {
        /** @var Chat $chat */
        $chat = Stub::construct(Chat::class, [(object)$this->data]);

        $this->specify('chat fields are correct', function () use ($chat) {
            $this->assertEquals($this->data['id'], $chat->getId());
            $this->assertEquals($this->data['type'], $chat->getType());
            $this->assertEquals($this->data['title'], $chat->getTitle());
            $this->assertEquals($this->data['username'], $chat->getUsername());
            $this->assertEquals($this->data['first_name'], $chat->getFirstName());
            $this->assertEquals($this->data['last_name'], $chat->getLastName());
        });
    }
}
