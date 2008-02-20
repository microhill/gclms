<?
/**
 * Contains a course frameset click-around test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Course Frameset Click-Around selenium test case.
 *
 * @author     Aaron Shafovaloff
 * @version    1.0 Dec 21, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class ClassroomTest extends SeleniumTestCase {
    var $title = 'Classroom Test';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Systematic Theology");
		$this->clickAndWait("link=The Attributes of God");
		$this->selectFrame('id=lessonViewportContent');
		
		// Navigate through a few pages
		$this->assertTextPresent('Classifications of Attributes');
		$this->clickAndWait("//img[@alt='Next page']");
		$this->assertTextPresent('Incommunicable Attributes');
		$this->clickAndWait("//img[@alt='Next page']");		
		$this->assertTextPresent('Communicable Attributes');
		
		// When the left side navigation becomes usable, do some click around for it here.
		
	}
}