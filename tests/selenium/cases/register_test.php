<?
/**
 * Contains a new student register test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Register as New Student selenium test case.
 *
 * @author     Brandon Tanner <theletterpi@gmail.com>
 * @version    1.2 Dec 18, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class RegisterTest extends SeleniumTestCase {
    var $title       = 'Register as New Student';
    var $useDbConfig = 'default';

	/**
	 * Generate Random Letters.
	 *  
	 * @param integer $cnt The number of random letters to generate
	 * @return             The random letters
	 */
    protected function randomLetters($cnt) {
		$text = '';
		for ($i=0; $i < $cnt; $i++) {
			$spoon = mt_rand(0, 51);
			$alphabetSoup = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$text.= $alphabetSoup[$spoon];
		}
		return $text;
    }

    public function execute() {
		$newUserName = "TestUser".$this->randomLetters(3);
		$this->open("/register");
    	$this->type("UserNewUsername", $newUserName);
    	$this->type("UserNewPassword", "shakeandbake");
    	$this->type("UserRepeatNewPassword", "shakeandbake");
    	$this->type("UserEmail", "spamthisallyouwant@pysquared.com");
    	$this->type("UserFirstName", "John");
    	$this->type("UserLastName", "Doe");
    	$this->type("UserAddress1", "32325 CR 323");
		$this->type("UserAddress2", "some 32 houses down");
    	$this->type("UserCity", "Killgore");
    	$this->type("UserState", "TX");
    	$this->type("UserPostalCode", "75603");
		$this->check("UserMailingList");
    	$this->click("//input[@value='Register']");
    	$this->assertBadTextNotPresent();
    	$this->waitForPageToLoad("30000");
    }
}