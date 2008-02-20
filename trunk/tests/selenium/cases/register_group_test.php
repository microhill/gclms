<?
/**
 * Contains a "Register Your Group" test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Register/Configure a new group selenium test case.
 *
 * @author     Brandon Tanner <theletterpi@gmail.com>
 * @version    1.3 Jan 4, 2008
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @todo       Tinymce is broken on this page, when it gets fixed, uncomment the line to use the tinmce description part.
 */
class RegisterGroupTest extends SeleniumTestCase {
    var $title       = 'Register Your Group';

    public function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		// Register Group
		$this->clickAndWait("link=Register Your Group");
		$this->type("GroupName", "The Cult of Aptana");
		$this->type("GroupWebPath", "aptana-cult");
		$this->type("GroupPhone", "8675309");
		$this->type("GroupAddress1", "13 Friday Street");
		$this->type("GroupAddress2", "Apartment 10/13");
		$this->type("GroupCity", "Erie");
		$this->type("GroupState", "Indiana");
		$this->type("GroupPostalCode", "30293");
		$this->type("GroupLogo", "");
		$this->type("GroupExternalWebAddress", "http://www.aptana.com/");
		//Uncomment this when tinymce starts working on this page.
		//$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('Aptana was founded by Paul Colton in 2005.')",'null');
		$this->type("GroupDescription", "Aptana was founded by Paul Colton in 2005.");
		$this->click("//input[@value='Submit']");
		$this->assertBadTextNotPresent();
		$this->waitForPageToLoad("30000");
		
		// Configure Group
		$this->open('/aptana-cult');
		$this->clickAndWait("link=Configure Group");
		$this->type('GroupPhone', '(719) 488-5837');
		$this->clickAndWait("//input[@value='Save']");
		$this->assertBadTextNotPresent();
		
    }
        
}