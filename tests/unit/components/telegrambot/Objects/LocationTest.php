<?php
/**
 * LocationTest.php
 * Created for weather
 * 2017-05-01
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace tests\unit\components\telegrambot\Objects;

use app\components\telegrambot\Objects\Location;
use Codeception\Util\Stub;
use tests\unit\AbstractTest;

/**
 * Class AudioTest
 * @package tests\unit\components\telegrambot\Objects
 */
class LocationTest extends AbstractTest
{

    /** @var array */
    protected $data;

    /** @inheritdoc */
    protected function setUp()
    {
        $this->data = [
            'longitude' => 123.456,
            'latitude' => 654.321,
        ];

        return parent::setUp();
    }

    public function testGetMethods()
    {
        /** @var Location $location */
        $location = Stub::construct(Location::class, [(object)$this->data]);

        $this->specify('location fields are correct', function () use ($location) {
            $this->assertEquals($this->data['longitude'], $location->getLongitude());
            $this->assertEquals($this->data['latitude'], $location->getLatitude());
        });
    }
}
