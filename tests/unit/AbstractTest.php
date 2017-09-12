<?php
/**
 * AbstractTest.php
 * Created for weather
 * 2017-04-23
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace tests\unit;

use Codeception\Specify;
use Codeception\Test\Unit;

/**
 * Class AbstractTest
 * @package tests\unit
 */
abstract class AbstractTest extends Unit
{
    use Specify;
}
