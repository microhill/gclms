<?
class MyTestSuite extends SeleniumTestSuite {
    var $title = 'Test Cases';

    /** Should probably give these cases better descriptive names */
    function execute() {
		//if(Configure::read('debug') === 0) {
		//	die("Debug needs to be on to run these tests. Edit /config/options.php to turn it on.");
		//}
			
		$this->addTestCase('Install', 'cases/InstallTest');
        $this->addTestCase('Groups (create, rename, delete, edit)', 'cases/GroupsTest');
        $this->addTestCase('Users (create, rename, delete, edit)', 'cases/UsersTest');
        $this->addTestCase('Group administrators (create, rename, delete, edit)', 'cases/GroupAdministratorsTest');
        $this->addTestCase('Courses', 'cases/CoursesTest');
		$this->addTestCase('Register as Student', 'cases/RegisterTest');
		$this->addTestCase('Edit profile', 'cases/EditProfileTest');
		$this->addTestCase('Units and lessons (create, rename, delete, edit)', 'cases/UnitsAndLessonsTest');
		$this->addTestCase('Topics and pages (create, rename, delete, edit)', 'cases/TopicsAndPagesTest');
		$this->addTestCase('Register Your Group', 'cases/RegisterGroupTest');
		$this->addTestCase('Edit Articles', 'cases/EditArticlesTest');
		$this->addTestCase('Edit Dictionary', 'cases/EditDictionaryTest');
		$this->addTestCase('Edit Books', 'cases/EditBooksTest');
		$this->addTestCase('Chapters', 'cases/ChaptersTest');
		$this->addTestCase('Classroom', 'cases/ClassroomTest');
		$this->addTestCase('Facilitated Classes', 'cases/FacilitatedClassTest');
		$this->addTestCase('Facilitators', 'cases/FacilitatorsTest');	
    }
}