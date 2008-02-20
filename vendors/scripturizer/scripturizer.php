<?php
/*
Plugin Name: Scripturizer
Version: 1.55
Plugin URI: http://dev.wp-plugins.org/wiki/Scripturizer
Description: Changes Bible references to hyperlinks for Wordpress 1.5 and above. If you have a higher version of Wordpress you might want to upgrade the plugin.
Author: Dean Peters, ported by Glen Davis, updates by LaurenceO.com
Author URI: http://www.healyourchurchwebsite.com/
*/

// you can pick any translation supported by the Bible Gateway, as well as the NRSV, the NET, and the ESV
// should we add Blue Letter Bible and http://www.zhubert.com/greek as original language options somehow? ....
// http://www.blueletterbible.org/cgi-bin/tools/printer-friendly.pl?book=Gen&chapter=1&version=heb
// http://www.blueletterbible.org/cgi-bin/tools/printer-friendly.pl?book=Mat&chapter=1&version=grk
// the interface on zhubert.com is weird - the NT books are numbered instead of named
// we should also take a look at the New American Bible - http://www.nccbuscc.com/nab/bible/index.htm

$scripturizer_translations = array(
	'NIV'=>'New International Version',
	'KJV'=>'King James Version',
	'ESV'=>'English Standard Version',
	'NASB'=>'New American Standard Bible',
	'HCSB'=>'Holman Christian Standard Bible',
	'AMP'=>'Amplified Bible',
	'NLV'=>'New Life Version',
	'NLT'=>'New Living Translation',
	'CEV'=>'Contemporary English Version',
	'NKJV'=>'New King James Version',
	'KJ21'=>'21st Century King James Version',
	'ASV'=>'Authorized Standard Version',
	'YLT'=>"Young's Literal Translation",
	'Darby'=>'Darby Translation',
	'WYC'=>'Wycliffe New Testament',
	'NIV-UK'=>'New International Version (British Edition)',
	'MSG'=>'The Message',
	'NIRV'=>"New International Readers' Version",
	'NET'=>'New English Translation',
	'NRSV'=>'New Revised Standard Version',
	'NA26'=>'Nestle-Aland Greek Text 26th edition',
	'LXX'=>'Septaugint'
	);


function scripturize($text = '',$bible = NULL) {

	if (!isset($bible)) {
		$bible = get_option('scripturizer_default_translation');
	}
    // skip everything within a hyperlink, a <pre> block, a <code> block, or a tag
    // we skip inside tags because something like <img src="nicodemus.jpg" alt="John 3:16"> should not be messed with
	$anchor_regex = '<a\s+href.*?<\/a>';
	$pre_regex = '<pre>.*<\/pre>';
	$code_regex = '<code>.*<\/code>';
	$other_plugin_regex= '\[bible\].*\[\/bible\]'; // for the ESV Wordpress plugin (out of courtesy)
	$other_plugin_block_regex='\[bibleblock\].*\[\/bibleblock\]'; // ditto
	$tag_regex = '<(?:[^<>\s]*)(?:\s[^<>]*){0,1}>'; // $tag_regex='<[^>]+>';
	$split_regex = "/((?:$anchor_regex)|(?:$pre_regex)|(?:$code_regex)|(?:$other_plugin_regex)|(?:$other_plugin_block_regex)|(?:$tag_regex))/i";
// $split_regex = "/((?:$anchor_regex)|(?:$pre_regex)|(?:$code_regex)|(?:$tag_regex))/i";	
	$parsed_text = preg_split($split_regex,$text,-1,PREG_SPLIT_DELIM_CAPTURE);
	$linked_text = '';

  while (list($key,$value) = each($parsed_text)) {
      if (preg_match($split_regex,$value)) {
         $linked_text .= $value; // if it is an HTML element or within a link, just leave it as is
      } else {
        $linked_text .= scripturizeAddLinks($value,$bible); // if it's text, parse it for Bible references
      }
  }

  return $linked_text;
}


function getEsvText($volume, $book, $verse) {
    //Get passage text from ESV web site
    $esvPassage = htmlentities(urlencode(trim("$volume $book $verse")));
    $esvUrl = "http://www.gnpcb.org/esv/share/get/?key=". get_option('scripturizer_esv_key') ."&passage=$esvPassage&". get_option('scripturizer_esv_query_options');
    $esvCh = curl_init($esvUrl);
    curl_setopt($esvCh, CURLOPT_RETURNTRANSFER, 1);
    $esvResponse = curl_exec($esvCh);
    curl_close($esvCh);

// Get rid of triple and double line breaks since WP turns them into <p>'s and thereby kills our <span>
//    $esvResponse = str_replace("\n\n\n", "\n", $esvResponse);
    $esvResponse = str_replace("\n\n", "\n", $esvResponse);

    // Build the show/hide link
    $esvSpanId = 'scripturizer' .mt_rand(); //prefix the rand number with "id" to pass XHTML validation
    $output_dynamic = " <a href=\"javascript://\" onclick=\"showhide('"
        . $esvSpanId
        . "');\">[+/-]</a><span id=\""
        . $esvSpanId
        . "\" style=\""
        . get_option('scripturizer_xml_css')
        . "\">"
        . $esvResponse
        . "<br /><a href=\"http://www.esv.org/\"><img src=\"http://www.esv.org/assets/buttons/small.7.png\" alt=\"This text is from the ESV Bible. Visit www.esv.org to learn about the ESV.\" title=\"Visit www.esv.org to learn about the ESV Bible\" width=\"80\" height=\"21\" /></a>"
        . "</span>";
        

    // I don't know why, but I ran into bugs when switching between dynamic and static modes based on how WP parsed the '' in the onclick action.
    // So, for now, I decided to have two different outputs. The static mode escapes the ' by using a double ''.
    // The dynamic output does not need to escape the ' -- (go figure!)
    $output_static = " <a href=\"javascript://\" onclick=\"showhide(''"
        . $esvSpanId
        . "'');\">[+/-]</a><span id=\""
        . $esvSpanId
        . "\" style=\""
        . get_option('scripturizer_xml_css')
        . "\">"
        . $esvResponse
        . "<br /><a href=\"http://www.esv.org/\"><img src=\"http://www.esv.org/assets/buttons/small.7.png\" alt=\"This text is from the ESV Bible. Visit www.esv.org to learn about the ESV.\" title=\"Visit www.esv.org to learn about the ESV Bible\" width=\"80\" height=\"21\" /></a>"
        . "</span>";

    if (get_option('scripturizer_dynamic_substitution')) {
        return $output_dynamic;
    } else {
        return $output_static;
    }
}
function scripturizeAddLinks($text = '',$bible = NULL) {
global $scripturizer_translations;

	if (!isset($bible)) {
		$bible=get_option('scripturizer_default_translation');
	}
	
    $volume_regex = '1|2|3|I|II|III|1st|2nd|3rd|First|Second|Third';

    $book_regex  = 'Genesis|Exodus|Leviticus|Numbers|Deuteronomy|Joshua|Judges|Ruth|Samuel|Kings|Chronicles|Ezra|Nehemiah|Esther';
    $book_regex .= '|Job|Psalms?|Proverbs?|Ecclesiastes|Songs? of Solomon|Song of Songs|Isaiah|Jeremiah|Lamentations|Ezekiel|Daniel|Hosea|Joel|Amos|Obadiah|Jonah|Micah|Nahum|Habakkuk|Zephaniah|Haggai|Zechariah|Malachi';
    $book_regex .= '|Mat+hew|Mark|Luke|John|Acts?|Acts of the Apostles|Romans|Corinthians|Galatians|Ephesians|Phil+ippians|Colossians|Thessalonians|Timothy|Titus|Philemon|Hebrews|James|Peter|Jude|Revelations?';

	// I split these into two different variables from Dean's original Perl code because I want to be able to have an optional period at the end of just the abbreviations

    $abbrev_regex  = 'Gen|Ex|Exo|Lev|Num|Nmb|Deut?|Josh?|Judg?|Jdg|Rut|Sam|Ki?n|Chr(?:on?)?|Ezr|Neh|Est';
    $abbrev_regex .= '|Jb|Psa?|Pr(?:ov?)?|Eccl?|Song?|Isa|Jer|Lam|Eze|Dan|Hos|Joe|Amo|Oba|Jon|Mic|Nah|Hab|Zeph?|Hag|Zech?|Mal';
    $abbrev_regex .= '|Mat+|Mr?k|Lu?k|Jh?n|Jo|Act|Rom|Cor|Gal|Eph|Col|Phil?|The?|Thess?|Tim|Tit|Phile|Heb|Ja?m|Pe?t|Ju?d|Rev';

    $book_regex='(?:'.$book_regex.')|(?:'.$abbrev_regex.')\.?';

    $verse_regex="\d{1,3}(?::\d{1,3})?(?:\s?(?:[-&,]\s?\d+))*";

$scripturizer_translations = array(
	'NIV'=>'New International Version',
	'KJV'=>'King James Version',
	'ESV'=>'English Standard Version',
	'NASB'=>'New American Standard Bible',
	'HCSB'=>'Holman Christian Standard Bible',
	'AMP'=>'Amplified Bible',
	'NLV'=>'New Life Version',
	'NLT'=>'New Living Translation',
	'CEV'=>'Contemporary English Version',
	'NKJV'=>'New King James Version',
	'KJ21'=>'21st Century King James Version',
	'ASV'=>'Authorized Standard Version',
	'YLT'=>"Young's Literal Translation",
	'Darby'=>'Darby Translation',
	'WYC'=>'Wycliffe New Testament',
	'NIV-UK'=>'New International Version (British Edition)',
	'MSG'=>'The Message',
	'NIRV'=>"New International Readers' Version",
	'NET'=>'New English Translation',
	'NRSV'=>'New Revised Standard Version',
	'NA26'=>'Nestle-Aland Greek Text 26th edition',
	'LXX'=>'Septaugint'
	);


	// non Bible Gateway translations are all together at the end to make it easier to maintain the list
	$translation_regex = implode('|',array_keys($scripturizer_translations)); // makes it look like 'NIV|KJV|ESV' etc

	// note that this will be executed as PHP code after substitution thanks to the /e at the end!
    $passage_regex = '/(?:('.$volume_regex.')\s)?('.$book_regex.')\s('.$verse_regex.')(?:\s?[,-]?\s?((?:'.$translation_regex.')|\s?\((?:'.$translation_regex.')\)))?/e';

    $replacement_regex = "scripturizeLinkReference('\\0','\\1','\\2','\\3','\\4','$bible')";

    $text=preg_replace($passage_regex,$replacement_regex,$text);

    return $text;
}

function scripturizeLinkReference($reference='',$volume='',$book='',$verse='',$translation='',$user_translation='') {
    if ($volume) {
       $volume = str_replace('III','3',$volume);
	   $volume = str_replace('Third','3',$volume);   
       $volume = str_replace('II','2',$volume);
	   $volume = str_replace('Second','2',$volume);      
       $volume = str_replace('I','1',$volume);
	   $volume = str_replace('First','1',$volume);      
       $volume = $volume{0}; // will remove st,nd,and rd (presupposes regex is correct)
    }
	
	//catch an obscure bug where a sentence like "The 3 of us went downtown" triggers a link to 1 Thess 3
	if (!strcmp(strtolower($book),"the") && $volume=='' ) {
		return $reference;
	}

   if(!$translation) {
         if (!$user_translation) {
             $translation = get_option('scripturizer_default_translation');
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

   switch ($translation) {
        case 'ESV':
        // note: the ESV could actually support a mouseover reference
        // we could pull it directly from their site and include it in the $title text
        // http://www.gnpcb.org/esv/share/services/api/ for more info
             $link = 'http://www.gnpcb.org/esv/search/?go=Go&amp;q=';
             $title = 'English Standard Version Bible';
             $link = sprintf('<a href="%s%s" title="%s">%s</a>',$link,htmlentities(urlencode(trim("$volume $book $verse"))),$title,trim($reference));
        # Insert Show/Hide link and include ESV verse text
        if (get_option('scripturizer_xml_show_hide')) {
            $link .= getEsvText($volume, $book, $verse);
        }
             break;
        case 'NET':
		// example URL http://www.bible.org/netbible2/index.php?book=gen&chapter=1&verse=1&submit=Lookup+Verse
             $link = 'http://www.bible.org/netbible2/index.php';
             $title = 'New English Translation';
             $chapter = trim(strtok($verse,':'));
             $verses = trim(strtok('-,'));
             $book = scripturizeNETBook($volume.' '.$book);
             $link = sprintf('<a href="%s?book=%s&amp;chapter=%s&amp;verse=%s&amp;submit=Lookup+Verse" title="%s">%s</a>',$link,htmlentities(urlencode($book)),$chapter,$verses,$title,trim($reference));
             break;
        case 'ESVmobile':
		// example URL http://www.bible.org/netbible2/index.php?book=gen&chapter=1&verse=1&submit=Lookup+Verse
             $link = 'http://www.gnpcb.org/esv/mobile/';
             $title = 'English Standard Translation';
             $chapter = trim(strtok($verse,':'));
             $verses = trim(strtok('-,'));
             $book = $volume.' '.$book;
             $link = sprintf('<a target="sidebarContent" href="http://www.gnpcb.org/esv/mobile/?q=%s+%s:%s" title="%s">%s</a>',htmlentities(urlencode($book)),$chapter,$verses,$title,trim($reference));
             break;
	case 'NRSV':
	// example URL http://bible.oremus.org/?passage=John+1%3A1&vnum=yes&version=nrsv
	// there is a new interface being developed at http://bible.oremus.org/bible.cgi
             $link = 'http://bible.oremus.org/';
             $title = 'New Revised Standard Version';
			 $options ='&amp;vnum=yes&amp;version=nrsv';
             $link = sprintf('<a href="%s?passage=%s%s" title="%s">%s</a>',$link,htmlentities(urlencode(trim("$volume $book $verse"))),$options,$title,trim($reference));
             break;
	case 'NA26':
	case 'LXX':
	// example URL http://www.zhubert.com/bible?book=Matthew&chapter=2&verse=3
	// there's also an XML interface to this content - could do a trick like I propose with the ESV
             $link = 'http://www.zhubert.com/bible';
             $title = 'original language at zhubert.com';
			$chapter=zhubertize_chapter($verse);
			$verse=zhubertize_verse($verse);
			$book=zhubertize_book($volume.' '.$book); 
             $link = sprintf('<a href="%s?book=%s&amp;chapter=%d&amp;verse=%d" title="%s">%s</a>',$link,htmlentities(urlencode(trim($book))),$chapter,$verse,$title,trim($reference));
             break;
        default:
		// Bible Gateway has a ton of translations, so just make it the default instead of checking for each one
		// $translation_regex takes care of ensuring that only valid translations make it this far, anyway
		// api at http://biblegateway.com/usage/linking/
             $link = "http://biblegateway.com/bible?version=$translation&amp;passage=";
             $title = 'Bible Gateway';
             $link = sprintf('<a href="%s%s" title="%s">%s</a>',$link,htmlentities(urlencode(trim("$volume $book $verse"))),$title,trim($reference));
             break;
    }
		
return $link;
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

function zhubertize_chapter($reference="") {
	$chapter=strtok($reference,':');
	return $chapter;
}

function zhubertize_verse($reference="") {
	$chapter=strtok($reference,':');
	$verse=strtok(' ,-;');
	if (!$verse) {
		$verse=1;
	}
	return $verse;
}

function zhubertize_book($rawbook) {
	// ultimately I need to restore all abbreviations to the full book.
	// perhaps take the first three letters and expand?
	$book = strtolower(trim($rawbook));
    $book = preg_replace('/\s+/', '', $book); //strip whitespace
	$book= substr($book,0,3);
	switch ($book) {
		case 'gen':
			$book='Genesis';
			break;
		case 'exo':
		case 'ex':
			$book='Exodus';
			break;
		case 'lev':
		case 'lv':
			$book='Leviticus';
			break;
		case 'num':
			$book='Numbers';
			break;
		case 'deu':
		case 'dt':
			$book='Deuteronomy';
			break;
		case 'jos':
			$book='Joshua';
			break;
		case 'jud':
		case 'jd': 
			// could be either Judges or Jude
			// abbreviations for Judges should always have a g in them
			$judges=strpos($rawbook,'g');
			if ($judges===FALSE) {
				$book='Jude';
			} else {
				$book='Judges';
			}
			break;
		case 'rut':
		case 'rth':
			$book='Ruth';
			break;
		case '1sa':
			$book='1 Samuel';
			break;
		case '2sa':
			$book='2 Samuel';
			break;
		case '1ki':
			$book='1 Kings';
			break;
		case '2ki':
			$book='2 Kings';
			break;
		case '1ch':
			$book='1 Chronicles';
			break;
		case '2ch':
			$book='2 Chronicles';
			break;
		case 'ezr':
		case 'ez':
			$book='Ezra';
			break;
		case 'neh':
		case 'nh':
			$book='Nehemiah';
			break;
		case 'est':
			$book='Esther';
			break;
		case 'job':
		case 'jb':
			$book='Job';
			break;
		case 'psa':
		case 'ps':
			$book='Psalms';
			break;
		case 'pro':
		case 'pr':
			$book='Proverbs';
			break;
		case 'ecc':
			$book='Qoheleth';
			break;
		case 'son':
		case 'sos':
			$book='Canticle of Canticles';
			break;
		case 'isa':
		case 'is':
			$book='Isaiah';
			break;
		case 'jer':
			$book='Jeremiah';
			break;
		case 'eze':
		case 'ez':
			$book='Ezekiel';
			break;
		case 'dan':
		case 'dn':
			$book='Daniel';
			break;
		case 'hos':
			$book='Hosea';
			break;
		case 'joe':
			$book='Joel';
			break;
		case 'amo':
		case 'am':
			$book='Amos';
			break;
		case 'oba':
		case 'ob':
			$book='Obadiah';
			break;
		case 'jon':
			$book='Jonah';
			break;
		case 'mic':
			$book='Micah';
			break;
		case 'nah':
			$book='Nahum';
			break;
		case 'hab':
			$book='Habakkuk';
			break;
		case 'zep':
			$book='Zephaniah';
			break;
		case 'hag':
			$book='Haggai';
			break;
		case 'zec':
			$book='Zechariah';
			break;
		case 'mal':
			$book='Malachi';
			break;
		case 'mat':
		case 'mt':
			$book='Matthew';
			break;
		case 'mar':
		case 'mk':
			$book='Mark';
			break;
		case 'luk':
		case 'lk':
			$book='Luke';
			break;
		case 'joh':
		case 'jn':
			$book='John';
			break;
		case 'act':
			$book='Acts';
			break;
		case 'rom':
		case 'rm':
			$book='Romans';
			break;
		case '1co':
			$book='1 Corinthians';
			break;
		case '2co':
			$book='2 Corinthians';
			break;
		case 'gal':
			$book='Galatians';
			break;
		case 'eph':
			$book='Ephesians';
			break;
		case 'phi':
			$book='Philippians';
			break;
		case 'col':
			$book='Colossians';
			break;
		case '1th':
			$book='1 Thessalonians';
			break;
		case '2th':
			$book='2 Thessalonians';
			break;
		case '1ti':
			$book='1 Timothy';
			break;
		case '2ti':
			$book='2 Timothy';
			break;
		case 'tit':
		case 'ti':
			$book='Titus';
			break;
		case 'phi':
			$book='Philemon';
			break;
		case 'heb':
			$book='Hebrews';
			break;
		case 'jam':
			$book='James';
			break;
		case '1pe':
			$book='1 Peter';
			break;
		case '2pe':
			$book='2 Peter';
			break;
		case '1jo':
			$book='1 John';
			break;
		case '2jo':
			$book='2 John';
			break;
		case '3jo':
			$book='3 John';
			break;
		// jude is handled up by judges
		case 'rev':
			$book='Revelation';
			break;
		default:
			$book=$rawbook;
	}
	return $book;
}

function scripturizePost($post_ID) {
    global $wpdb;
    global $tableposts;

    if (!isset($tableposts)) {
        // detect variable change between versions - see http://wiki.wordpress.org/1.3/TableVariables
        $tableposts=$wpdb->posts;
    }

    $postdata=$wpdb->get_row("SELECT * FROM $tableposts WHERE ID = '$post_ID'");

    $content = scripturize($postdata->post_content);

    $wpdb->query("UPDATE $tableposts SET post_content = '$content' WHERE ID = '$post_ID'");
    
    return $post_ID;
}

function scripturizeComment($comment_ID) {
    global $wpdb;
    global $tablecomments;

    if (!isset($tablecomments)) {
        // detect variable change between versions - see http://wiki.wordpress.org/1.3/TableVariables
        $tablecomments=$wpdb->comments;
    }

    $postdata=$wpdb->get_row("SELECT * FROM $tablecomments WHERE ID = '$comment_ID'");

    $content = scripturize($postdata->comment_content);

    $wpdb->query("UPDATE $tablecomments SET comment_content = '$content' WHERE ID = '$comment_ID'");
    
    return $comment_ID;
}

if (! function_exists('esvShowHideHeader')) {

    function esvShowHideHeader() {

        $content = "
            <script language=\"javascript\" type=\"text/javascript\">
            <!-- I modified this script: http://lists.evolt.org/archive/Week-of-Mon-20020624/116151.html to get the following
            var state = 'none';

            function showhide(layer_ref) {

            if (state == 'block') {
            state = 'none';
            }
            else {
            state = 'block';
            }
            if (document.all) { //IS IE 4 or 5 (or 6 beta)
            eval( \"document.all.\" + layer_ref + \".style.display = state\");
            }
            if (document.layers) { //IS NETSCAPE 4 or below
            document.layers[layer_ref].display = state;
            }
            if (document.getElementById && !document.all) {
            maxwell_smart = document.getElementById(layer_ref);
            maxwell_smart.style.display = state;
            }
            }
            //-->
            </script>";
    echo $content;
    }
}