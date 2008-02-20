<?
/**
 * Contains a test case for selenium to add some groups.
 *
 * @package GCLMS
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Selenium test case to add some groups from Site Administration.
 *
 * @author  Aaron Shafovaloff
 * @version 1.0 Dec 21, 2007
 * @package GCLMS
 * @todo    Should make another test to edit/delete a group from this area of administration.
 */
class GroupsTest extends SeleniumTestCase {
    var $title = 'Group Administrators Setup';
    var $useDbConfig = 'default';
	
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Site Administration");
		$this->clickAndWait("link=Groups");
		
		$this->addGroup('Boyce College','Louisville','KY','boyce-college');
		$this->addGroup('Covenant Theological Seminary','St. Louis','MO','covenant-theological-seminary');
		$this->addGroup('Fuller Seminary','Pasadena','CA','fuller-seminary');
		
		$this->clickAndWait("link=Fuller Seminary");
		$this->click('GroupDelete');
		$this->clickAndWait('gclmsPopupDialogOkButton');
		$this->assertBadTextNotPresent();
    }
    
    function addGroup($name, $city, $state, $webPath) {
		$this->clickAndWait("//button");
		$this->type('GroupName', $name);
		$this->type('GroupWebPath', $webPath);
		$this->type('GroupPhone', '8675309');
		$this->type('GroupAddress1', '9 Westlake Ave');
		$this->type('GroupAddress2', 'APO 320');
		$this->type('GroupCity', $city);
		$this->type('GroupState', $state);
		$this->type('GroupPostalCode', '80132');
		//$this->type('GroupLogo', '');
		$this->type('GroupExternalWebAddress', 'http://www.letu.edu/');
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('Some very descriptive text here.')",'null');
		$this->type('GroupCss', '');
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
    }
}