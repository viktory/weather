<?php
namespace tests\unit\models;

use app\models\User;
use app\components\telegrambot\Objects\User as TelegramUser;
use Codeception\Util\Stub;
use tests\unit\AbstractTest;
use yii\db\Exception;

class UserTest extends AbstractTest
{
    /** @var \UnitTester */
    public $tester;

    /** @var TelegramUser */
    public $from = null;

    /** @inheritdoc */
    protected function setUp()
    {
        $data = (object)[
            'id' => 123456,
            'first_name' => 'Test',
            'last_name' => 'User',
        ];
        $this->from = Stub::construct(TelegramUser::class, [$data]);

        return parent::setUp();
    }

    public function testGetUser()
    {
        $this->specify('sender is specified', function () {
            $this->tester->expectException(
                new \InvalidArgumentException('Sender is empty'),
                function () {
                    User::getUser(Stub::construct(TelegramUser::class, [(object)[]]));
                }
            );

            $this->tester->expectException(
                new Exception('Can not create new user with user_id=\'123456\' and first_name=\'\' ' .
                    '({"first_name":["First Name cannot be blank."]})'),
                function () {
                    User::getUser(Stub::construct(TelegramUser::class, [(object)['id' => 123456]]));
                }
            );
        });

        $this->specify('save new user', function () {
            $this->tester->dontSeeRecord(User::class, ['user_id' => $this->from->getId()]);
            $user = User::getUser($this->from);
            $this->tester->seeRecord(User::class, ['user_id' => $this->from->getId()]);
        });
    }

    public function testHasLocation()
    {
        $this->specify('user has not location', function () {
            $user = new User();
            $this->assertFalse($user->hasLocation());

            $user->lat = 123;
            $this->assertFalse($user->hasLocation());

            $user->lat = null;
            $user->lng = 123;
            $this->assertFalse($user->hasLocation());
        });

        $this->specify('user has location', function () {
            $user = new User();
            $user->city = 'User\'s city';
            $this->assertTrue($user->hasLocation());

            $user->city = null;
            $user->lat = 123;
            $user->lng = 321;
            $this->assertTrue($user->hasLocation());
        });
    }
}
