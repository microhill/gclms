<?
class BibleKjvController extends BibleKjvAppController {
	var $uses = array('BibleKjv.BibleVerseKjv');
	var $oldTestamentBooks = array(
		'Genesis' => 50,
		'Exodus' => 40,
		'Leviticus' => 27,
		'Numbers' => 36,
		'Deuteronomy' => 34,
		'Joshua' => 24,
		'Judges' => 21,	
		'Ruth' => 4,
		'1 Samuel' => 31,
		'2 Samuel' => 24,
		'1 Kings' => 22,
		'2 Kings' => 25,
		'1 Chronicles' => 29,
		'2 Chronicles' => 36,
		'Ezra' => 10,
		'Nehemiah' => 13,
		'Esther' => 10,	
		'Job' => 42,	
		'Psalms' => 150,
		'Proverbs' => 31,
		'Ecclesiastes' => 12,
		'Song of Solomon' => 8,
		'Isaiah' => 66,
		'Jeremiah' => 52,
		'Lamentations' => 5,
		'Ezekiel' => 48,
		'Daniel' => 14,
		'Hosea' => 14,
		'Joel' => 4,
		'Amos' => 9,
		'Obadiah' => 1,
		'Jonah' => 4,	
		'Micah' => 7,
		'Nahum' => 3,
		'Habakkuk' => 3,
		'Zephaniah' => 3,
		'Haggai' => 2,
		'Zechariah' => 14,
		'Malachi' => 3
	);
	var $newTestamentBooks = array(
		'Matthew' => 28,
		'Mark' => 16,
		'Luke' => 24,
		'John' => 21,
		'Acts' => 28,
		'Romans' => 16,
		'1 Corinthians' => 16,
		'2 Corinthians' => 13,
		'Galatians' => 6,
		'Ephesians' => 6,
		'Philippians' => 4,
		'Colossians' => 4,
		'1 Thessalonians' => 5,
		'2 Thessalonians' => 3,
		'1 Timothy' => 6,
		'2 Timothy' => 4,
		'Titus' => 3,
		'Philemon' => 1,
		'Hebrews' => 13,
		'James' => 5,
		'1 Peter' => 5,
		'2 Peter' => 3,
		'1 John' => 5,
		'2 John' => 1,
		'3 John' => 1,
		'Jude' => 1,
		'Revelation' => 22
	);

	function books() {
		$this->set('old_testament_books',$this->oldTestamentBooks);
		$this->set('new_testament_books',$this->newTestamentBooks);
				
		$this->render('books','classroom_panel');
	}

	function lookup() {
		ClassRegistry::init('BibleKjv.BibleVerseKjv');
		$this->BibleVerseKjv =& new BibleVerseKjv();

		$chapter = $this->passedArgs['chapter'];
		$bookNumber = 1;
		
		foreach($this->oldTestamentBooks as $bookName => $chapterCount) {
			if($bookName == $this->passedArgs['book']) {
				$book = $bookNumber;
				continue;
			}
			$bookNumber++;
		}
		
		if(empty($book)) {
			foreach($this->newTestamentBooks as $bookName => $chapterCount) {
				if($bookName == $this->passedArgs['book']) {
					$book = $bookNumber;
					continue;
				}
				$bookNumber++;
			}
		}
		
		$verses = $this->BibleVerseKjv->findAllByBook(array(
			'BibleVerseKjv.book' => $book,
			'BibleVerseKjv.chapter' => $chapter
		),array('verse','text'),'BibleVerseKjv.verse ASC');
		
		$verses = Set::extract($verses, '{n}.BibleVerseKjv.text');
		$this->set(compact('verses'));

		$this->set('books',am($this->oldTestamentBooks,$this->newTestamentBooks));
		$this->set('book',$this->passedArgs['book']);
		$this->set('chapter',$this->passedArgs['chapter']);

		$this->css_for_layout[] = 'bible';
		
		$this->render('chapter','classroom_panel');
	}
}