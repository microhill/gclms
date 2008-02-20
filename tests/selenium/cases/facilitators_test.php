<?
/**
 * Contains a facilitators test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Facilitators selenium test case.
 *
 * @author     Brandon Tanner
 * @version    1.3 Jan 4, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @todo       The edit/delete part once it is working.
 */
class FacilitatorsTest extends SeleniumTestCase {
    var $title = 'Facilitators Test';
    var $useDbConfig = 'default';
	
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Facilitators");
		
		$this->clickAndWait("gclmsAdd");    // click add button
		$this->addFacilitator('aaronshaf'); // user must exist
		
		//Edit (view not made yet)
		//Delete

    }
	
	/**
	 * Add a new facilitator.
	 * 
	 * @param string $username The username to add as a facilitator
	 */
	function addFacilitator($username) {
		$this->type('GroupFacilitatorUsername', $username);
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
		$this->assertTextNotPresent('This field cannot be left blank');
	}
	   
}