<?
/**
 * Contains a test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Manage Units and Lessons for a course.
 *
 * @author     Aaron Shafovaloff
 * @version    1.1 Dec 20, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class UnitsAndLessonsTest extends SeleniumTestCase {
    var $title = 'Units and Lessons';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Systematic Theology");
		$this->clickAndWait("link=Edit Units and Lessons");
		
		$this->addUnit('God');
		$this->addUnit('Revelation');
		$this->addUnit('Salvation');

		$this->open('/boyce-college/systematic-theology/lessons');
		$this->assertBadTextNotPresent();
		$this->assertTextPresent('God');
		$this->assertTextPresent('Revelation');
		$this->assertTextPresent('Salvation');
		
		//Delete unit
		$this->click('link=Salvation');
		$this->click('deleteUnit');
		$this->click('gclmsPopupDialogOkButton');
		$this->pause(500);
		$this->open('/boyce-college/systematic-theology/lessons');
		$this->assertTextNotPresent('Salvation');
		
		//Add lessons
		$this->click('link=God');
		$this->addLesson('The Attributes of God');
		$this->addLesson('The Decrees of God');
		$this->addLesson('Three Persons, One Being');
		
		$this->click('link=Revelation');
		$this->addLesson('General Revelation');
		$this->addLesson('Special Revelation');
		$this->pause(1000);
		
		$this->open('/boyce-college/systematic-theology/lessons');
		$this->assertTextPresent('The Attributes of God');
		$this->assertTextPresent('The Decrees of God');
		$this->assertTextPresent('Three Persons, One Being');		
		$this->assertTextPresent('General Revelation');
		$this->assertTextPresent('Special Revelation');
		
		$this->click('link=The Attributes of God');		
		$this->click('editLesson');
		
		$this->assertBadTextNotPresent();
    }
    	
	function addUnit($title) {
		$this->click('addUnit');
		$this->pause(100);
		$this->type('gclmsPopupDialogInputText',$title);
		$this->click('gclmsPopupDialogOkButton');
		$this->pause(500);
	}
	
	function addLesson($title) {
		$this->click('addLesson');
		$this->pause(100);
		$this->type('gclmsPopupDialogInputText',$title);
		$this->click('gclmsPopupDialogOkButton');
		$this->pause(500);
	}
}