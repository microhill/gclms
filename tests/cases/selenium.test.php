<?
App::import('Vendor', 'selenium' . DS . 'Selenium');

class SeleniumTest extends UnitTestCase
{
    function setUp() {
        $this->selenium = new Testing_Selenium('*firefox', 'http://lms');
        $result = $this->selenium->start();
    }

    function tearDown() {
        $this->selenium->stop();
    }

    function test1() {
        $this->selenium->open('/');
        $this->assertEqual('Internet Biblical Seminary - A hub for evangelical Christian e-learning', $this->selenium->getTitle());
    }
}