<?
/**
 * Contains a edit course articles test case for selenium.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

uses('model' . DS . 'connection_manager');

/**
 * Edit Course Articles selenium test case.
 *
 * @author     Brandon Tanner <theletterpi@gmail.com>
 * @version    1.0 Dec 21, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @todo       Add the click command for Add, Edit and Delete. Also delete is broken it seems.
 */
class EditArticlesTest extends SeleniumTestCase {
    var $title = 'Edit Articles';
    var $useDbConfig = 'default';
    
    function execute() {
        $this->open('/users/logout');
        $this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->clickAndWait("//input[@value='Login']");
		$this->assertBadTextNotPresent();
		
		$this->clickAndWait("link=Boyce College");
		$this->clickAndWait("link=Systematic Theology");
		$this->clickAndWait("link=Edit Articles");
		
		/* Add a new article */
		$this->addArticle('Test Article 1','Test Content 1');
		$this->addArticle('Test Article 2','Test Content 2');
		$this->addArticle('Test Article 3','Test Content 3');
		$this->addArticle('PHP6 is Going to Rock!','I just cannot wait for it.');
    	
    	/* Edit an article */
		$this->clickAndWait('link=PHP6 is Going to Rock!');
    	$this->type('ArticleTitle', 'Ruby on Rails Rocks!');
		$this->assertTextPresent('I just cannot wait for it.');
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('Something different here.')",'null');
    	$this->clickAndWait("//input[@value='Save']");
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully saved');
		$this->assertTextPresent('Ruby on Rails Rocks!');
		$this->clickAndWait('link=Ruby on Rails Rocks!');
		$this->assertTextPresent('Something different here.');
    	
    	/* Delete an article */
    	$this->click("//input[@value='Delete']");
		$this->clickAndWait('gclmsPopupDialogOkButton');
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully deleted');
		$this->assertTextNotPresent('Ruby on Rails Rocks!');
		$this->assertTextNotPresent('PHP6');
		
		/* Basic panel functionality */
		$this->open('/boyce-college/systematic-theology/articles/panel');
		$this->assertTextPresent('Test Article 1');
		$this->assertTextPresent('Test Article 2');
		$this->assertTextPresent('Test Article 3');
		$this->clickAndWait('link=Test Article 1');
		$this->assertTextPresent('<h1>Test Article 1</h1>');
		$this->assertTextPresent('<h1>Test Content 1</h1>');
		$this->clickAndWait('link=Back to Articles');
		$this->clickAndWait('link=Test Article 2');
		$this->assertTextPresent('<h1>Test Article 2</h1>');
		$this->assertTextPresent('<h1>Test Content 2</h1>');
		$this->clickAndWait('link=Back to Articles');
    }
	
	function addArticle($title,$content) {
		$this->clickAndWait('gclmsAdd');
		$this->type('ArticleTitle', $title);
		$this->verifyEval("selenium.browserbot.getCurrentWindow().tinyMCE.setContent('" . $content . "')",'null');
    	$this->clickAndWait("//input[@value='Save']");
    	$this->assertBadTextNotPresent();
		$this->assertTextPresent('successfully added');
	}
}