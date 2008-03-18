/*
MySQL Data Transfer
Source Host: localhost
Source Database: gclms
Target Host: localhost
Target Database: gclms
Date: 3/18/2008 5:32:59 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for announcements
-- ----------------------------
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` char(36) NOT NULL,
  `facilitated_class_id` char(36) NOT NULL,
  `title` varchar(255) default NULL,
  `post_date` date NOT NULL,
  `content` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`facilitated_class_id`,`title`,`post_date`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for answers
-- ----------------------------
DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` char(36) NOT NULL,
  `question_id` char(36) NOT NULL,
  `text1` varchar(255) default NULL,
  `text2` varchar(255) default NULL,
  `text3` text,
  `order` int(3) default NULL,
  `correct` tinyint(1) unsigned NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for articles
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for books
-- ----------------------------
DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` char(36) NOT NULL,
  `course_id` char(36) default NULL,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for chapters
-- ----------------------------
DROP TABLE IF EXISTS `chapters`;
CREATE TABLE `chapters` (
  `id` char(36) NOT NULL,
  `book_id` char(36) default NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `order` int(3) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for chat_messages
-- ----------------------------
DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages` (
  `id` char(36) NOT NULL,
  `facilitated_class_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `content` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=456 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for chat_participants
-- ----------------------------
DROP TABLE IF EXISTS `chat_participants`;
CREATE TABLE `chat_participants` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `facilitated_class_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=482 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_completions
-- ----------------------------
DROP TABLE IF EXISTS `class_completions`;
CREATE TABLE `class_completions` (
  `facilitated_class_id` char(36) NOT NULL default '0',
  `user_id` char(36) NOT NULL default '0',
  `date` date NOT NULL,
  `grade` int(5) unsigned default NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`facilitated_class_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_enrollees
-- ----------------------------
DROP TABLE IF EXISTS `class_enrollees`;
CREATE TABLE `class_enrollees` (
  `id` char(36) NOT NULL,
  `facilitated_class_id` char(36) NOT NULL default '0',
  `user_id` char(36) NOT NULL default '0',
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`facilitated_class_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_facilitators
-- ----------------------------
DROP TABLE IF EXISTS `class_facilitators`;
CREATE TABLE `class_facilitators` (
  `id` char(36) NOT NULL,
  `facilitated_class_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for courses
-- ----------------------------
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` char(36) NOT NULL,
  `group_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `web_path` varchar(255) NOT NULL,
  `description` text,
  `css` text,
  `language` varchar(6) NOT NULL default 'en',
  `redistribution_allowed` tinyint(1) NOT NULL default '0',
  `commercial_use_allowed` tinyint(1) NOT NULL default '0',
  `derivative_works_allowed` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deprecated` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`web_path`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dictionary_terms
-- ----------------------------
DROP TABLE IF EXISTS `dictionary_terms`;
CREATE TABLE `dictionary_terms` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `term` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for facilitated_classes
-- ----------------------------
DROP TABLE IF EXISTS `facilitated_classes`;
CREATE TABLE `facilitated_classes` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `type` int(1) unsigned NOT NULL default '1',
  `alias` varchar(255) NOT NULL,
  `enrollment_deadline` date default NULL,
  `beginning` date default NULL,
  `end` date default NULL,
  `capacity` int(11) unsigned default NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deprecated` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for forum_posts
-- ----------------------------
DROP TABLE IF EXISTS `forum_posts`;
CREATE TABLE `forum_posts` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `forum_id` char(36) NOT NULL,
  `parent_post_id` char(36) NOT NULL,
  `title` varchar(255) default NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `forum_id` (`forum_id`,`parent_post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for forums
-- ----------------------------
DROP TABLE IF EXISTS `forums`;
CREATE TABLE `forums` (
  `id` char(36) NOT NULL,
  `facilitated_class_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) default NULL,
  `order` int(3) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for group_administrators
-- ----------------------------
DROP TABLE IF EXISTS `group_administrators`;
CREATE TABLE `group_administrators` (
  `id` char(36) NOT NULL,
  `group_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_admin` (`group_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for group_facilitators
-- ----------------------------
DROP TABLE IF EXISTS `group_facilitators`;
CREATE TABLE `group_facilitators` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `group_id` char(36) NOT NULL,
  `approved` tinyint(1) unsigned NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_facilitator` (`user_id`,`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `web_path` varchar(255) NOT NULL,
  `css` text,
  `logo` varchar(255) default NULL,
  `logo_updated` datetime default NULL,
  `external_web_address` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `address_1` varchar(255) default NULL,
  `address_2` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(255) default NULL,
  `postal_code` varchar(255) default NULL,
  `country_id` varchar(255) default NULL,
  `description` text,
  `approved` int(255) unsigned NOT NULL default '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deprecated` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for nodes
-- ----------------------------
DROP TABLE IF EXISTS `nodes`;
CREATE TABLE `nodes` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `parent_node_id` char(36) NOT NULL default '0',
  `grade_recorded` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `type` int(1) unsigned NOT NULL default '0',
  `audio_file` varchar(255) default NULL,
  `order` int(4) unsigned NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `course_id` (`course_id`,`parent_node_id`)
) ENGINE=MyISAM AUTO_INCREMENT=256 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for notebooks
-- ----------------------------
DROP TABLE IF EXISTS `notebooks`;
CREATE TABLE `notebooks` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `content` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`course_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for questions
-- ----------------------------
DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` char(36) NOT NULL,
  `node_id` char(36) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `type` int(2) unsigned NOT NULL default '1',
  `order` int(3) unsigned NOT NULL default '1',
  `text_answer` varchar(255) default NULL,
  `true_false_answer` tinyint(1) unsigned default NULL,
  `left_column_header` varchar(255) default NULL,
  `right_column_header` varchar(255) default NULL,
  `explanation` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for registration_codes
-- ----------------------------
DROP TABLE IF EXISTS `registration_codes`;
CREATE TABLE `registration_codes` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for textareas
-- ----------------------------
DROP TABLE IF EXISTS `textareas`;
CREATE TABLE `textareas` (
  `id` char(36) NOT NULL,
  `node_id` char(36) NOT NULL,
  `content` text,
  `order` int(3) unsigned NOT NULL default '9999',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) default NULL,
  `alias` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address_1` varchar(255) default NULL,
  `address_2` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(255) default NULL,
  `postal_code` varchar(255) default NULL,
  `mailing_list` tinyint(1) unsigned NOT NULL default '1',
  `autoplay_audio` tinyint(1) unsigned NOT NULL default '0',
  `verification_code` varchar(255) default NULL,
  `verified` tinyint(1) unsigned NOT NULL default '0',
  `super_administrator` tinyint(1) unsigned NOT NULL default '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UniqueUsername` (`alias`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `books` VALUES ('47d71bd0-a17c-4bf3-af88-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '<em>Basic Theology</em>, by Charlies Ryrie', '2008-03-11 17:54:56', '2008-03-12 01:07:12');
INSERT INTO `books` VALUES ('47d77f95-3b4c-40f2-a525-08f8ab4a69cb', null, 'Basic Theology', '2008-03-12 01:00:37', '2008-03-12 01:00:37');
INSERT INTO `books` VALUES ('47d77fd9-9268-46cc-a231-08f8ab4a69cb', null, 'asdf', '2008-03-12 01:01:45', '2008-03-12 01:01:45');
INSERT INTO `chapters` VALUES ('47d71be2-5c0c-40d9-976a-08f8ab4a69cb', '47d71bd0-a17c-4bf3-af88-08f8ab4a69cb', 'Test Chapter 1', null, '1', '2008-03-11 17:55:14', '2008-03-12 12:50:39');
INSERT INTO `chapters` VALUES ('47d7a355-a240-4169-a881-01a4ab4a69cb', null, 'asefse', null, '1', '2008-03-12 03:33:09', '2008-03-12 03:33:09');
INSERT INTO `chapters` VALUES ('47d7a390-091c-4da7-aa6f-01a4ab4a69cb', '47d71bd0-a17c-4bf3-af88-08f8ab4a69cb', 'Chapter 2: Some Presuppositions', '<h3>I. The Basic One</h3>\r\n<p>Consciously or unconsciously everyone operates on the basis of some\r\npresuppositions. The atheist who says there is no God has to believe\r\nthat basic presupposition. And believing it, he then views the world,\r\nmankind, and the future in entirely different ways than the theist. The\r\nagnostic not only affirms we cannot know God, but he must believe that\r\nas basic to his entire outlook on the world and life. If we can know\r\nabout the true God then his whole system is smashed. The theist\r\nbelieves there is a God. He mounts confirmatory evidence to support\r\nthat belief, but basically he believes.</p>\r\n<p>The trinitarian believes God is Triunity. That is a belief gleaned\r\nfrom the Bible. Therefore, he also believes the Bible to be true.</p>\r\n<p>This stands as the watershed presupposition. If the Bible is not\r\ntrue, then trinitarianism is untrue and Jesus Christ is not who He\r\nclaimed to be. We learn nothing about the Trinity or Christ from nature\r\nor from the human mind. And we cannot be certain that what we learn\r\nfrom the Bible about the Triune God is accurate unless we believe that\r\nour source itself is accurate. Thus the belief in the truthfulness of\r\nthe Bible is the basic presupposition. This will be fully discussed\r\nunder inspiration and inerrancy.</p>\r\n<p></p>\r\n<h3>II. The Interpretive Ones</h3>\r\n<p>If our source material is so crucial, then we must be concerned how\r\nwe approach and use it. Accurate theology rests on sound exegesis.\r\nExegetical studies must be made before theological systematization,\r\njust as bricks have to be made before a building can be built.</p>\r\n<p></p>\r\n<h4>A. The Necessity of Normal, Plain Interpretation</h4>\r\n<p>Though a more thorough discussion of hermeneutics will appear in\r\nsection III, we need to state here the importance of normal\r\ninterpretation as the basis for proper exegesis. In giving us the\r\nrevelation of Himself, God desired to communicate, not obscure, the\r\ntruth. So we approach the interpretation of the Bible presupposing the\r\nuse of normal canons of interpretation. Remember that when symbols,\r\nparables, types, etc. are used they depend on an underlying literal\r\nsense for their very existence, and their interpretation must always be\r\ncontrolled by the concept that God communicates in a normal, plain, or\r\nliteral manner. Ignoring this will result in the same kind of confused\r\nexegesis that characterized the patristic and medieval interpreters.</p>\r\n<p></p>\r\n<h4>B. The Priority of the New Testament</h4>\r\n<p>All Scripture is inspired and profitable, but the New Testament has\r\ngreater priority as the source of doctrine. Old Testament revelation\r\nwas preparatory and partial, but New Testament revelation is climactic\r\nand complete. The doctrine of the Trinity, for instance, while allowed\r\nfor in the Old Testament, was not revealed until the New Testament. Or,\r\nthink how much difference exists between what is taught in the Old and\r\nNew Testaments concerning atonement, justification, and resurrection.\r\nTo say this is not to minimize what is taught in the Old Testament or\r\nto imply that it is any less inspired, but it is to say that in the\r\nprogressive unfolding of God\'s revelation the Old Testament occupies a\r\nprior place chronologically and thus a preparatory and incomplete place\r\ntheologically. Old Testament theology has its place, but it is\r\nincomplete without the contribution of New Testament truth.</p>\r\n<p></p>\r\n<h4>C. The Legitimacy of Proof Texts</h4>\r\n<p>Liberals and Barthians have often criticized conservatives for\r\nusing proof texts to substantiate their conclusions. Why do they\r\ncomplain? Simply because citing proof texts will lead to conservative,\r\nnot liberal, conclusions. They charge it with being an illegitimate,\r\nunscholarly methodology, but it is no more illegitimate than footnotes\r\nare in a scholarly work!</p>\r\n<p>To be sure, proof texts must be used properly, just as footnotes\r\nmust be. They must actually be used to mean what they say; they must\r\nnot be used out of context; they must not be used in part when the\r\nwhole might change the meaning; and Old Testament proof texts\r\nparticularly must not be forced to include truth that was only revealed\r\nlater in the New Testament.</p>\r\n<p></p>\r\n<p></p>\r\n<p></p>\r\n<h3>III. The Systematizing Ones</h3>\r\n<p></p>\r\n<h4>A. The Necessity of a System</h4>\r\n<p>The difference between exegesis and theology is the system used.\r\nExegesis analyzes; theology correlates those analyses. Exegesis relates\r\nthe meanings of texts; theology interrelates those meanings. The\r\nexegete strives to present the meaning of truth; the theologian, the\r\nsystem of truth. Theology\'s goal, whether biblical or systematic\r\ntheology, is the systematization of the teachings under consideration.</p>\r\n<p></p>\r\n<h4>B. The Limitations of a Theological System</h4>\r\n<p>In a word, the limitations of a theological system must coincide\r\nwith the limitations of biblical revelation. In an effort to present a\r\ncomplete system, theologians are often tempted to fill in the gaps in\r\nthe biblical evidence with logic or implications that may not be\r\nwarranted.</p>\r\n<p>Logic and implications do have their appropriate place. God\'s\r\nrevelation is orderly and rational, so logic has a proper place in the\r\nscientific investigation of that revelation. When words are put\r\ntogether in sentences, those sentences take on implications that the\r\ntheologian must try to understand.</p>\r\n<p>However, when logic is used to create truth, as it were, then the\r\ntheologian will be guilty of pushing his system beyond the limitations\r\nof biblical truth. Sometimes this is motivated by the desire to answer\r\nquestions that the Scripture does not answer. In such cases (and there\r\nare a number of crucial ones in the Bible) the best answer is silence,\r\nnot clever logic, or almost invisible implications, or wishful\r\nsentimentality. Examples of particularly tempting areas include\r\nsovereignty and responsibility, the extent of the Atonement, and the\r\nsalvation of infants who die.</p>\r\n<p></p>\r\n<h3>Iv. The Personal Ones</h3>\r\n<p>One should also be able to presuppose certain matters about the student of theology.</p>\r\n<p></p>\r\n<h4>A. He Must Believe</h4>\r\n<p>Of course unbelievers can write and study theology, but a believer\r\nhas a dimension and perspective on the truth of God that no unbeliever\r\ncan have. The deep things of God are taught by the Spirit, whom an\r\nunbeliever does not have (1 Cor. 2:10-16).</p>\r\n<p>Believers need to have faith also, for some areas of God\'s revelation will not be fully understood by our finite minds.</p>\r\n<p></p>\r\n<h4>B. He Must Think</h4>\r\n<p>Ultimately the believer must try to think theologically. This\r\ninvolves thinking exegetically (to understand the precise meaning),\r\nthinking systematically (in order to correlate facts thoroughly),\r\nthinking critically (to evaluate the priority of the related evidence),\r\nand thinking synthetically (to combine and present the teaching as a\r\nwhole).</p>\r\n<p>Theology and exegesis should always interact. Exegesis does not\r\nprovide all the answers; when there can legitimately be more than one\r\nexegetical option, theology will decide which to prefer. Some passages,\r\nfor example, could seem to teach eternal security or not; one\'s\r\ntheological system will make the decision. On the other hand, no\r\ntheological system should be so hardened that it is not open to change\r\nor refinement from the insights of exegesis.</p>\r\n<p></p>\r\n<h4>C. He Must Depend</h4>\r\n<p>Intellect alone does not make a theologian. If we believe in the\r\nreality of the teaching ministry of the Holy Spirit, then certainly\r\nthis must be a factor in studying theology (John 16:12-15).\r\nThe content of the Spirit\'s curriculum encompasses all the truth,\r\nfocusing especially on the revelation of Christ Himself which is, of\r\ncourse, found in the Scriptures. To experience this will require a\r\nconscious attitude of dependence on the Spirit, which will be reflected\r\nin humility of mind and a diligent study of what the Spirit has taught\r\nothers throughout history. Inductive Bible study is a beneficial way to\r\nstudy, but to do it only is to ignore the results of the work of\r\nothers, and to do it always can be an inefficient repetition of what\r\nothers have already done.</p>\r\n<p></p>\r\n<h4>D. He Must Worship</h4>\r\n<p>Studying theology is no mere academic exercise, though it is that.\r\nIt is an experience that changes, convicts, broadens, challenges, and\r\nultimately leads to a deep reverence for God. Worship means to\r\nrecognize the worth of the object worshiped. How can any mortal put his\r\nmind to the study of God and fail to increase his recognition of His\r\nworth?</p>', '2', '2008-03-12 03:34:08', '2008-03-12 12:51:25');
INSERT INTO `chapters` VALUES ('47d841e7-048c-44c5-80a2-01a4ab4a69cb', '47d71bd0-a17c-4bf3-af88-08f8ab4a69cb', 'Chapter 4: The Knowledge of God', '<h3>I. The Possibility of the Knowledge of God</h3>\r\n<p>Unquestionably the knowledge of God is desirable; the religious yearnings of mankind testify to that. But is it possible?</p>\r\n<p>The Scriptures attest to two facts: the incomprehensibility of God\r\nand the knowability of God. To say that He is incomprehensible is to\r\nassert that the mind cannot grasp the knowledge of Him. To say that He\r\nis knowable is to claim that He can be known. Both are true, though\r\nneither in an absolute sense. To say that God is incomprehensible is to\r\nassert that man cannot know everything about Him. To say that He is\r\nknowable is not to assert that man can know everything about Him.</p>\r\n<p>Both truths are affirmed in the Scriptures: His incomprehensibility in verses like Job 11:7 and Isaiah 40:18, and His knowability in verses like John 14:7; John 17:3; and 1 John 5:20.</p>\r\n<p></p>\r\n<h3>II. Characteristics of the Knowledge of God</h3>\r\n<p>The knowledge of God may be characterized in relation to its source, its content, its progressiveness, and its purposes.</p>\r\n<p></p>\r\n<h4>A. Its Source</h4>\r\n<p>God Himself is the Source of our knowledge of Him. To be sure, all\r\ntruth is God\'s truth. But that clich&eacute; should be more carefully stated\r\nand used than it generally is. Only true truth comes from God, for\r\nsince sin entered the stream of history man has created that which he\r\ncalls truth but which is not. Furthermore, he has perverted, blunted,\r\ndiluted, and corrupted that which was originally true truth that did\r\ncome from God. For us today the only infallible canon for determining\r\ntrue truth is the written Word of God. Nature, though it does reveal\r\nsome things about God, is limited and can be misread by mankind. The\r\nhuman mind, though often brilliant in what it can achieve, suffers\r\nlimitations and darkening. Human experiences, even religious ones, lack\r\nreliability as sources of the true knowledge of God unless they conform\r\nto the Word of God.</p>\r\n<p>Certainly the knowledge of what is true religion must come from\r\nGod. In a past dispensation Judaism was revealed as God\'s true\r\nreligion. Today Judaism is not the true religion; only Christianity is.\r\nAnd the true knowledge of Christianity has been revealed through Christ\r\nand the apostles. One of the purposes of our Lord\'s incarnation was to\r\nreveal God (John 1:18; John 14:7).\r\nThe promise of the coming of the Spirit after the ascension of Christ\r\nincluded further revelation concerning Him and the Father (John 16:13-15; Acts 1:8). The Holy Spirit opens the Scriptures for the believer so that he can know God more fully.</p>\r\n<p></p>\r\n<h4>B. Its Content</h4>\r\n<p>A full knowledge of God is both factual and personal. To know facts\r\nabout a person without knowing the person is limiting; to know a person\r\nwithout knowing facts about that one is shallow. God has revealed many\r\nfacts about Himself, all of which are important in making our personal\r\nrelationship with Him close, intelligent, and useful. Had He only\r\nrevealed facts without making it possible to know Him personally, such\r\nfactual knowledge would have little, certainly not eternal, usefulness.\r\nJust as with human relationships, a divine-human relationship cannot\r\nbegin without knowledge of some minimal truths about the Person; then\r\nthe personal relationship generates the desire to know more facts,\r\nwhich in turn deepens the relationship, and so on. This kind of cycle\r\nought to be the experience of every student of theology; a knowledge\r\nabout God should deepen our relationship with Him, which in turn\r\nincreases our desire to know more about Him.</p>\r\n<p></p>\r\n<h4>C. Its Progressiveness</h4>\r\n<p>The knowledge of God and His works was revealed progressively\r\nthroughout history. The most obvious proof is to compare incomplete\r\nJewish theology with the fuller revelation of Christian theology in\r\nrespect, for example, to such doctrines as the Trinity, Christology,\r\nthe Holy Spirit, Resurrection, and eschatology. To trace that\r\nprogressiveness is the task of biblical theology.</p>\r\n<p></p>\r\n<h4>D. Its Purposes</h4>\r\n<p>1. To lead people to the possession of eternal life (John 17:3; 1 Tim. 2:4).</p>\r\n<p>2. To foster Christian growth (2 Pet. 3:18), with doctrinal knowledge (John 7:17; Rom. 6:9, 16; Eph. 1:18) and with a discerning lifestyle (Phil. 1:9-10; 2 Pet. 1:5).</p>\r\n<p>3. To warn of judgment to come (Hos. 4:6; Heb. 10:26-27).</p>\r\n<p>4. To generate true worship of God (Rom. 11:33-36).</p>\r\n<p></p>\r\n<h3>III. Prerequisites to the Knowledge of God</h3>\r\n<h4>A. God Initiated His Self-Revelation</h4>\r\n<p>The knowledge of God differs from all other knowledge in that man\r\ncan have this knowledge only as far as God reveals it. If God did not\r\ninitiate the revelation of Himself, there would be no way for man to\r\nknow Him. Therefore, a human being must put himself under God who is\r\nthe object of his knowledge. In other scholarly endeavors, the human\r\nbeing often places himself above the object of his investigation, but\r\nnot so in the study of God.</p>\r\n<p></p>\r\n<h4>B. God Gave Language for Communication</h4>\r\n<p>Certainly an essential part of God\'s revelation is a provision of\r\nmeans for communicating that revelation. Also the record of the\r\npersonal revelation of God in Christ necessitates some means of\r\nrecording and communicating that revelation. For this purpose God gave\r\nlanguage. He devised it and gave it to the first man and woman in order\r\nthat He might communicate His instructions to them (Gen. 1:28-30) and that they might communicate with Him (John 3:8-13).\r\nIt also seemed to have a part in their subduing the unfallen creation\r\nand giving names to the animals. Even after the division of the one\r\noriginal language into many at Babel, languages served as the means of\r\ncommunication on all levels. We can certainly believe that the\r\nomniscient God made provision for languages that were sufficient to\r\ncommunicate His self-revelation to man.</p>\r\n<p></p>\r\n<h4>C. He Created Man in His Image</h4>\r\n<p>When God created man in His image and likeness He made him, like\r\nHimself, a rational being with intelligence. To be sure, human\r\nintelligence is not the same as divine intelligence, but it is a real\r\nintelligence, not fictitious. Therefore, humans have the ability to\r\nunderstand the meaning of words and the logic of sentences and\r\nparagraphs. Sin has removed the guarantee that human understanding is\r\nalways reliable, but it does not eradicate a human being\'s ability to\r\nunderstand.</p>\r\n<p></p>\r\n<h4>D. He Gave the Holy Spirit</h4>\r\n<p>To believers God has given His Holy Spirit to reveal the things of God (John 16:13-15; 1 Cor. 2:10). This does not make the believer infallible, but it can give him the ability to distinguish truth from error (1 John 2:27).</p>\r\n<p>These works of God make it possible for us to know and obey the many commands in Scripture to know Him (Rom. 6:16; 1 Cor. 3:16; \r\n5:6; \r\n6:19; James 4:4).</p>', '3', '2008-03-12 14:49:43', '2008-03-12 14:50:20');
INSERT INTO `courses` VALUES ('47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '103', 'Doctrine 1', 'doctrine-1', '<p>This course offers an overview of the major teachings of the Bible\r\nconcerning the person and work of God, the Word of God, history,\r\nangels, man, sin, and other subjects. Even though this is not a course\r\non the evidences for the Christian faith, it will at times refer to\r\nhistorical and scientific evidence that supports the biblical view of\r\nthe world and the truthfulness of the Scriptures. This course will also\r\nbe giving special attention to some of the objections that have been\r\nraised against the central teachings of Christianity.</p>\r\n<p>The study of theology requires clear thinking, intellectual\r\napplication, and a great deal of time and study. It is not an\r\nunimportant part of the Christian life. It is true that it can become\r\npurely intellectual and impractical, but this is essentially and\r\npractically not so.</p>\r\n<p>Doctrine is ultimately the most practical of all disciplines in the\r\nChristian life, for it is the basis for everything we do. Whenever a\r\nChristian prays, makes a righteous decision, goes to church, or does\r\nsomething loving or kind, he/she is making practical application of\r\ndoctrine.</p>', '', 'en', '0', '0', '0', '2008-03-10 15:46:53', '2008-03-11 13:42:00', '0');
INSERT INTO `dictionary_terms` VALUES ('47d71d6b-3044-4576-b73e-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'TestTerm', '<p>yadda yadda yadda</p>', '2008-03-11 18:01:47', '2008-03-11 18:01:47');
INSERT INTO `dictionary_terms` VALUES ('47d74467-cd80-49dc-9dc3-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'asdf', '<p>asdfasd</p>', '2008-03-11 20:48:07', '2008-03-11 20:48:07');
INSERT INTO `group_administrators` VALUES ('40', '103', '52', '2008-02-26 13:11:47', '2008-02-26 13:11:47');
INSERT INTO `groups` VALUES ('103', 'BEE World', 'bee-world', '.TestClass {\r\nbackground-color: red;\r\n}', null, null, 'http://www.beeworld.org/', '', '', '', '', '', '', null, '<p>Some very descriptive text here.</p>', '1', '2008-02-19 20:35:24', '2008-03-17 11:12:17', '0');
INSERT INTO `groups` VALUES ('104', 'Covenant Theological Seminary', 'covenant-theological-seminary', '', null, null, 'http://www.letu.edu/', '8675309', '9 Westlake Ave', 'APO 320', 'St. Louis', 'MO', '80132', null, 'Some very descriptive text here.', '1', '2008-02-19 20:35:37', '2008-02-19 20:35:37', '0');
INSERT INTO `nodes` VALUES ('a7e4777c-588a-4703-871c-a181910ab9bf', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', '1', '0', null, '0', '2008-03-18 15:11:59', '2008-03-18 15:11:59');
INSERT INTO `nodes` VALUES ('a613b3fc-bdfe-46a5-bdba-8281997829ae', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'a7e4777c-588a-4703-871c-a181910ab9bf', '0', '2', '0', null, '0', '2008-03-18 15:12:00', '2008-03-18 15:12:05');
INSERT INTO `nodes` VALUES ('00d12c68-b9e8-4dcf-a57d-4edc3b4a32f9', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'a613b3fc-bdfe-46a5-bdba-8281997829ae', '0', '3', '0', null, '0', '2008-03-18 15:12:01', '2008-03-18 15:21:42');
INSERT INTO `textareas` VALUES ('47e02b18-df7c-4464-86a7-0ac0ab4a69cb', '51966c0d-2865-43c2-951b-dd92f034cb33', '<p>jkljlk</p>', '1', '2008-03-18 14:50:32', '2008-03-18 14:50:32');
INSERT INTO `users` VALUES ('52', 'aaronshaf@gmail.com', '3a00070e691147f18e69201fc1431b0d39248af9', 'Aaron Shafovaloff', 'Aaron', 'Shafovaloff', 'abc', 'abc', 'Midvale', 'UT', '90210', '1', '0', null, '0', '1', '0000-00-00 00:00:00', '2008-02-19 20:39:50');
INSERT INTO `users` VALUES ('53', 'patty.thompson@fake_domain_name.org', null, 'patty.thompson', 'Patty', 'Thompson', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:36:38', '2008-02-19 20:36:38');
INSERT INTO `users` VALUES ('54', 'paul.walgren@fake_domain_name.org', null, 'paul.walgren', 'Paul', 'Walgren', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:36:52', '2008-02-19 20:36:52');
INSERT INTO `users` VALUES ('57', 'spamthisallyouwant@pysquared.com', 'f51917152d00e8f50f3bdde3674397b1e4825ffc', 'TestUserODD', 'John', 'Doe', '32325 CR 323', 'some 32 houses down', 'Killgore', 'TX', '75603', '1', '0', '47bba0d0-a538-4ba9-9cf1-08ccab4a69cb', '0', '0', '2008-02-19 20:38:56', '2008-02-19 20:38:56');
INSERT INTO `users` VALUES ('56', 'linus.torvalds@fake_domain_name.org', null, 'linus.torvalds', 'Linus', 'Torvalds', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:37:21', '2008-02-19 20:37:21');
