<?
/**
 * Contains a test case for selenium to add some group administrators.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

/**
 * Selenium test case to add some group administrators from Site Administration.
 *
 * @author     Brandon Tanner
 * @version    1.1 Jan 1, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class GroupAdministratorsTest extends SeleniumTestCase {
    var $title = 'Group Admins';
     
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Site Administration");
		$this->clickAndWait("link=Group Administrators");
		
		/* Add some Group Admins */
		$this->addGroupAdministrator('aaronshaf','Boyce College');
		$this->addGroupAdministrator('paul.walgren','Covenant Theological Seminary');
		
		// Delete a Group Administrator
		$this->clickAndWait('link=Covenant Theological Seminary');
		$this->click("//input[@value='Delete']");
		$this->clickAndWait('gclmsPopupDialogOkButton');
		$this->assertBadTextNotPresent();
    }
    
    function addGroupAdministrator($username, $group) {
		$this->clickAndWait("gclmsAdd");
		$this->type('GroupAdministratorUsername', $username);
		$this->select('GroupAdministratorGroupId','label=' . $group);
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
    }
    
}