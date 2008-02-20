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
class PluginsTest extends SeleniumTestCase {
    var $title = 'Classroom Test';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Site Administration");
		$this->clickAndWait("link=Plugins");
		$this->clickAndWait("link=King James Version (Bible)");
	}
}