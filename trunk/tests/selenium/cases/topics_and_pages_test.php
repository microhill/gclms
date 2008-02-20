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
 * Manage Topics under "Edit Units and Lessons" in a course.
 *
 * @author     Aaron Shafovaloff
 * @version    1.1 Dec 20, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class TopicsAndPagesTest extends SeleniumTestCase {
    var $title = 'Topics and Pages';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
	
		$this->clickAndWait("link=Site Administration");
		$this->clickAndWait("link=Groups");	
    }
}