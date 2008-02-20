<?
/**
 * Contains a edit profile test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Edit Student Profile selenium test case.
 *
 * @author     Brandon Tanner <theletterpi@gmail.com>
 * @version    1.2 Dec 29, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class EditProfileTest extends SeleniumTestCase {

    var $title       = 'Edit Profile';
    var $useDbConfig = 'default';

    function execute() {
        $this->open('/users/logout');
		$this->type('UserUsername', 'aaronshaf');
        $this->type('UserPassword', 'test');
        $this->clickAndWait("//input[@value='Login']");
        $this->assertBadTextNotPresent();
		 
        $this->clickAndWait("link=My Profile");
    	$this->type("UserFirstName", "Aaron");
    	$this->type("UserLastName", "Shafovaloff");
		$this->type("UserNewPassword", "test");
		$this->type("UserRepeatNewPassword", "test");
    	$this->type("UserAddress1", "abc");
		$this->type("UserAddress2", "abc");
    	$this->type("UserCity", "Midvale");
    	$this->type("UserState", "UT");
    	$this->type("UserPostalCode", "90210");
    	$this->clickAndWait("//input[@value='Save']");
    	$this->assertBadTextNotPresent();
    }

}