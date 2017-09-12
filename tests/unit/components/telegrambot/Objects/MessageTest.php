<?php
/**
 * MessageTest.php
 * Created for weather
 * 2017-05-01
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace tests\unit\components\telegrambot\Objects;

use app\components\telegrambot\Objects\Chat;
use app\components\telegrambot\Objects\Location;
use app\components\telegrambot\Objects\Message;
use app\components\telegrambot\Objects\User;
use Codeception\Util\Stub;
use tests\unit\AbstractTest;

/**
 * Class AudioTest
 * @package tests\unit\components\telegrambot\Objects
 */
class MessageTest extends AbstractTest
{

    /** @var array */
    protected $data;

    /** @inheritdoc */
    protected function setUp()
    {
        $from = Stub::construct(User::class, [(object)[
            'id' => 111222,
            'firstName' => 'firstName',
            'last_name' => 'lastName',
            'username' => 'userName',
        ]]);

        $chat = Stub::construct(Chat::class, [(object)[
            'id' => 123456,
            'type' => 'chat_type',
            'title' => 'chat_title',
            'username' => 'user_name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name'
        ]]);

        $location = Stub::construct(Location::class, [(object)[
            'longitude' => 123.456,
            'latitude' => 654.321,
        ]]);

        $this->data = [
            'message_id' => 123456,
            'from' => $from,
            'date' => '1492549274',
            'chat' => $chat,
            'location' => $location,
        ];

        return parent::setUp();
    }

    public function testGetMethods()
    {
        /** @var Message $message */
        $message = Stub::construct(Message::class, [(object)$this->data]);

        $this->specify('message fields are correct', function () use ($message) {
            $this->assertEquals($this->data['message_id'], $message->getMessageId());
            $this->assertEquals($this->data['date'], $message->getDate());
            $this->assertInstanceOf(User::class, $message->getFrom());
            $this->assertInstanceOf(Chat::class, $message->getChat());
            $this->assertInstanceOf(Location::class, $message->getLocation());
        });
    }
}
