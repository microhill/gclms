<?
/**
 * Contains a test case for selenium to install/setup gclms.
 *
 * @package    GCLMS
 * @subpackage SeleniumTests
 * @filesource
 */

/**
 * Install/Setup the GCLMS.
 *
 * @author     Aaron Shafovaloff
 * @version    1.0 Dec 15, 2007
 * @package    GCLMS
 * @subpackage SeleniumTests
 */
class InstallTest extends SeleniumTestCase {
    var $title = 'Install';

	function setUp() {
		/*
		$db = ConnectionManager::getDataSource('default');
		$tables = $db->query('show tables;');
		foreach($tables as $table) {
			//$db->query('drop table ' . $table['TABLE_NAMES']['Tables_in_gclms'] . ';');
		}
		*/
		
		unlink(CONFIGS.'installed.txt');
		unlink(CONFIGS.'database.php');
		unlink(CONFIGS.'options.php');
	}

    function execute() {
        $this->open('/');
        $this->type('DatabaseHost', 'localhost');
        $this->type('DatabaseUsername', 'root');
		$this->type('DatabaseDatabase', 'gclms');
		$this->clickAndWait("//input[@value='Next']");
		$this->assertBadTextNotPresent();
		
		$this->type('SiteName', 'Internet Biblical Seminary');		
		$this->type('SiteDomain', 'http://lms/');
		$this->clickAndWait("//input[@value='Next']");
		$this->assertBadTextNotPresent();
		
		$this->type('UserUsername', 'aaronshaf');
		$this->type('UserPassword', 'test');
		$this->type('UserFirstName', 'Aaron');
		$this->type('UserLastName', 'Shafovaloff');
		$this->type('UserEmail', 'aaronshaf@gmail.com');
		$this->clickAndWait("//input[@value='Next']");
		$this->assertBadTextNotPresent();
    }

}