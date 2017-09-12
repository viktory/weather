<?php
/**
 * ContactTest.php
 * Created for weather
 * 2017-04-23
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace tests\unit\components\telegrambot\Objects;

use app\components\telegrambot\Objects\Contact;
use Codeception\Util\Stub;
use tests\unit\AbstractTest;

/**
 * Class ContactTest
 * @package tests\unit\components\telegrambot\Objects
 */
class ContactTest extends AbstractTest
{
    /** @var array */
    protected $data;

    /** @inheritdoc */
    protected function setUp()
    {
        $this->data = [
            'phone_number' => '123-456-789',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_id' => 123456,
        ];

        return parent::setUp();
    }

    public function testGetMethods()
    {
        /** @var Contact $contact */
        $contact = Stub::construct(Contact::class, [(object)$this->data]);

        $this->specify('contact fields are correct', function () use ($contact) {
            $this->assertEquals($this->data['phone_number'], $contact->getPhoneNumber());
            $this->assertEquals($this->data['first_name'], $contact->getFirstName());
            $this->assertEquals($this->data['last_name'], $contact->getLastName());
            $this->assertEquals($this->data['user_id'], $contact->getUserId());
        });
    }
}
