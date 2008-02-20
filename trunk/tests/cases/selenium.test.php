<?
vendor('selenium' . DS . 'Selenium');

class SeleniumTest extends UnitTestCase
{
    function setUp()
    {
        $this->selenium = new Testing_Selenium("*iexplore", "http://cakephp.org");
        $result = $this->selenium->start();
    }

    function tearDown()
    {
        $this->selenium->stop();
    }

    function testCakePHPTitle()
    {
        $this->selenium->open("/");
        //$this->assertEqual('CakePHP', $this->selenium->getTitle());
    }
}