<?
/**
 * Contains a test case for selenium to add some users.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Selenium test case to add some users from Site Administration.
 *
 * @author     Aaron Shafovaloff
 * @version    1.1 Jan 4, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class UsersTest extends SeleniumTestCase {
    var $title = 'Users Setup';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Site Administration");
		$this->clickAndWait("link=Users");
		
		$this->addUser('Patty','Thompson');
		$this->addUser('Paul','Walgren');
		$this->addUser('Clyde','Everett');
		$this->addUser('Linus', 'Torvalds');
		
		// Edit a User
		$this->clickAndWait('link=clyde.everett');
		$this->type('UserAddress1', 'PO BOX 1182');
		$this->type('UserAddress2', '');
		$this->type('UserCity', 'Monument');
		$this->type('UserState', 'CO');
		$this->type('UserPostalCode', '80132');
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
		
		// Delete a User
		$this->clickAndWait('link=clyde.everett');
		$this->click('UserDelete');
		$this->clickAndWait('gclmsPopupDialogOkButton');
		$this->assertBadTextNotPresent();
    }
    
    function addUser($firstName, $lastName) {
		$this->clickAndWait('gclmsAdd');
		$this->type('UserUsername', strtolower($firstName.'.'.$lastName));
		$this->type('UserEmail', strtolower($firstName.'.'.$lastName) . '@fake_domain_name.org');
		$this->type('UserFirstName', $firstName);
		$this->type('UserLastName', $lastName);
		$this->type('UserAddress1', '21 Lakeside Drive');
		$this->type('UserAddress2', 'Apt #11');
		$this->type('UserCity', 'Beverly Hills');
		$this->type('UserState', 'CA');
		$this->type('UserPostalCode', '90210');
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
    }
       
    function __executeSQLScript($db, $fileName) {
        $statements = file_get_contents($fileName);
        $statements = explode(';', $statements);

        foreach ($statements as $statement) {
            if (trim($statement) != '') {
                $db->query($statement);
            }
        }
    }
}