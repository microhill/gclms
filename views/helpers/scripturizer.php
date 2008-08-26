<?
class ScripturizerHelper extends AppHelper {	
	var $translations = array(
		'KJV'=>'King James Version',
		'ESV'=>'English Standard Version'
		);

	function linkify($text) {		
		if (!isset($bible)) {
			$bible = 'KJV';
		}
		
	    // skip everything within a hyperlink, a <pre> block, a <code> block, or a tag
	    // we skip inside tags because something like <img src="nicodemus.jpg" alt="John 3:16"> should not be messed with
		$anchor_regex = '<a\s+href.*?<\/a>';
		$pre_regex = '<pre>.*<\/pre>';
		$code_regex = '<code>.*<\/code>';
		$tag_regex = '<(?:[^<>\s]*)(?:\s[^<>]*){0,1}>'; // $tag_regex='<[^>]+>';
		$split_regex = "/((?:$anchor_regex)|(?:$pre_regex)|(?:$code_regex)|(?:$tag_regex))/i";
		$parsed_text = preg_split($split_regex,$text,-1,PREG_SPLIT_DELIM_CAPTURE);
		$linked_text = '';
	
		while (list($key,$value) = each($parsed_text)) {
			if (preg_match($split_regex,$value)) {
		    	$linked_text .= $value; // if it is an HTML element or within a link, just leave it as is
			} else {
				 $linked_text .= $this->addLinks($value,$bible); // if it's text, parse it for Bible references
			}
		}
		
		return $linked_text;
	}
	
	function addLinks($text = '',$bible = NULL) {
		if (!isset($bible)) {
			$bible=get_option('scripturizer_default_translation');
		}

	    $volume_regex = '1|2|3|I|II|III|1st|2nd|3rd|First|Second|Third';
	
	    $book_regex  = 'Genesis|Exodus|Leviticus|Numbers|Deuteronomy|Joshua|Judges|Ruth|Samuel|Kings|Chronicles|Ezra|Nehemiah|Esther'
				. '|Job|Psalms?|Proverbs?|Ecclesiastes|Songs? of Solomon|Song of Songs|Isaiah|Jeremiah|Lamentations|Ezekiel|Daniel|Hosea|Joel|Amos|Obadiah|Jonah|Micah|Nahum|Habakkuk|Zephaniah|Haggai|Zechariah|Malachi'
				. '|Mat+hew|Mark|Luke|John|Acts?|Acts of the Apostles|Romans|Corinthians|Galatians|Ephesians|Phil+ippians|Colossians|Thessalonians|Timothy|Titus|Philemon|Hebrews|James|Peter|Jude|Revelations?';
	
	    $abbrev_regex  = 'G(e?n?)|Ex|Exo|Lev|Num|Nmb|Deut?|Josh?|Judg?|Jdg|Rut|Sam|Ki?n|Chr(?:on?)?|Ezr|Neh|Est'
				. '|Jb|Psa?|Pr(?:ov?)?|Eccl?|Song?|Isa|Jer|Lam|Eze|Dan|Hos|Joe|Amo|Oba|Jon|Mic|Nah|Hab|Zeph?|Hag|Zech?|Mal'
				. '|Mat+|Mr?k|Lu?k|Jh?n|Jo|Act|Rom|Cor|Gal|Eph|Col|Phil?|The?|Thess?|Tim|Tit|Phile|Heb|Ja?m|Pe?t|Ju?d|Rev';
	
	    $book_regex = '(?:'.$book_regex.')|(?:'.$abbrev_regex.')\.?';
	
	    $verse_regex = "\d{1,3}(?::\d{1,3})?(?:\s?(?:[-&,]\s?\d+))*";
	
		$translation_regex = implode('|',array_keys($this->translations)); // makes it look like 'NIV|KJV|ESV' etc
	
		// note that this will be executed as PHP code after substitution thanks to the /e at the end!
	    $passage_regex = '/(?:('.$volume_regex.')\s)?('.$book_regex.')\s('.$verse_regex.')(?:\s?[,-]?\s?((?:'.$translation_regex.')|\s?\((?:'.$translation_regex.')\)))?/e';
	
	    $replacement_regex = "ScripturizerHelper::scripturizeLinkReference('\\0','\\1','\\2','\\3','\\4','$bible')";

	    $text = preg_replace($passage_regex,$replacement_regex,$text);

	    return $text;
	}
	
	function scripturizeLinkReference($reference='',$volume='',$book='',$verse='',$translation='',$user_translation='') {
		//catch an obscure bug where a sentence like "The 3 of us went downtown" triggers a link to 1 Thess 3
		if (!strcmp(strtolower($book),"the") && $volume=='' ) {
			return $reference;
		}
	
	   if(!$translation) {
	         if (!$user_translation) {
	             $translation = 'KJV';
	         } else {
	             $translation = $user_translation;
	         }
	   } else {
	       $translation = trim($translation,' ()'); // strip out any parentheses that might have made it this far
	   }
	
	   // if necessary, just choose part of the verse reference to pass to the web interfaces
	   // they wouldn't know what to do with John 5:1-2, 5, 10-13 so I just give them John 5:1-2
	   // this doesn't work quite right with something like 1:5,6 - it gets chopped to 1:5 instead of converted to 1:5-6
		if ($verse) {
			$verse = strtok($verse,',& ');
		}
		
		//return sprintf('<a href="/%s/%s/bible_kjv/lookup/book:%s/chapter:%d#%d" link:type="bible">%s</a>',$this->params['group'],$this->params['course'],$book,$chapter,$verses,$reference);
		return sprintf('<a href="http://www.bibleapi.net/%s/%s/%s?css=%s">%s</a>','en','asv',$reference,Configure::read('App.domain') . 'css/bible.css',$reference);
	}
	
	function scripturizeNETBook($book='') {
	// need this function because NET Bible needs rigid input
	// it's not perfect, so someone who intends to link to the NET Bible must be cautious with their syntax
	// Jn 5:1 won't work, for example (must be 'joh' or 'john').
	    $book = strtolower(trim($book));
	    if (!$book) return '';
	
	    $book = preg_replace('/\s+/', '', $book); //strip whitespace
	
	    switch ($book) {
	           case 'judges':
	                $book = 'jdg';
	                break;
	           case 'songofsongs':
	           case 'songofsolomon':
	           case 'song':
	                $book = 'sos';
	                break;
	           case 'philemon':
	                 $book = 'phm';
	                 break;
	           default:
	                   $book = substr($book,0,3);
	    }
	    return $book;
	}
}