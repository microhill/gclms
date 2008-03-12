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
 * Add/Edit/Del Chapters from a Course Book selenium test case.
 *
 * @author     Aaron Shafovaloff
 * @version    1.0 Dec 21, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class ChaptersTest extends SeleniumTestCase {
    var $title = 'Chapters (create, edit, delete)';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Systematic Theology");
		$this->clickAndWait("link=Edit Books");
		$this->click("link=Desiring God");
		$this->clickAndWait('editBook');
		
		/* Add chapters */
		$this->assertBadTextNotPresent();
		$this->addChapter('The Happiness of God');
		$this->addChapter('Christian Hedonism');
		$this->addChapter('Appendix I');
    	
    	/* Edit chapters */
		$this->open('/boyce-college/systematic-theology/books');
		$this->assertBadTextNotPresent();
		$this->click('link=Desiring God');
		$this->clickAndWait('editBook');
		$this->assertBadTextNotPresent();
		$this->click('link=Christian Hedonism');
		$this->clickAndWait('editChapter');
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('Test content.')",'null');
    	$this->clickAndWait("//input[@value='Save']");		
		$this->assertBadTextNotPresent();
		$this->click('link=Christian Hedonism');
		$this->clickAndWait('editChapter');
		$this->assertTextPresent('Test content.');
	   
    	/* Delete a chapter */
    	$this->click("//input[@value='Delete']");
		$this->clickAndWait('gclmsPopupDialogOkButton');
		$this->assertBadTextNotPresent();
		$this->assertTextPresent('Chapter successfully deleted.');		
    }
	
	function addChapter($title) {
		$this->click('addChapter');
		$this->type('gclmsPopupDialogInputText',$title);
		$this->click('gclmsPopupDialogOkButton');
		$this->pause(500);
	}
}