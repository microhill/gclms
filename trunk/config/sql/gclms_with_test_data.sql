/*
MySQL Data Transfer
Source Host: localhost
Source Database: gclms
Target Host: localhost
Target Database: gclms
Date: 3/16/2008 10:22:18 PM
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
INSERT INTO `answers` VALUES ('47dc72e4-3534-4afc-92f5-14b0ab4a69cb', '47dc72e4-34fc-48d7-b945-14b0ab4a69cb', 'Red', 'Yuck', '', null, '0', '2008-03-15 19:07:48', '2008-03-16 02:38:35');
INSERT INTO `answers` VALUES ('47dcd5bb-f604-496a-86de-14b0ab4a69cb', '47dc72e4-34fc-48d7-b945-14b0ab4a69cb', 'Green', 'OK', null, null, '1', '2008-03-16 02:09:31', '2008-03-16 02:38:35');
INSERT INTO `answers` VALUES ('47dcd5bb-40fc-427e-9c58-14b0ab4a69cb', '47dc72e4-34fc-48d7-b945-14b0ab4a69cb', 'Brown', 'Good', null, null, '0', '2008-03-16 02:09:31', '2008-03-16 02:38:35');
INSERT INTO `answers` VALUES ('47dcdc8b-e9e0-4c0e-8c91-14b0ab4a69cb', '47dc72e4-34fc-48d7-b945-14b0ab4a69cb', 'asdfafwe', null, null, null, '0', '2008-03-16 02:38:35', '2008-03-16 02:38:35');
INSERT INTO `answers` VALUES ('47dd716a-238c-47c4-8506-14b0ab4a69cb', '47dd716a-5d90-4465-98b2-14b0ab4a69cb', 'Independence Day', null, null, null, '0', '2008-03-16 13:13:46', '2008-03-16 13:13:46');
INSERT INTO `answers` VALUES ('47dd716a-7888-4fdf-8612-14b0ab4a69cb', '47dd716a-5d90-4465-98b2-14b0ab4a69cb', 'Great Depression', null, null, null, '0', '2008-03-16 13:13:46', '2008-03-16 13:13:46');
INSERT INTO `answers` VALUES ('47dd716a-2998-4936-b8a6-14b0ab4a69cb', '47dd716a-5d90-4465-98b2-14b0ab4a69cb', '9/11', null, null, null, '0', '2008-03-16 13:13:46', '2008-03-16 13:13:46');
INSERT INTO `articles` VALUES ('21', '92', 'Test', '<p>test</p>', '2008-03-08 01:17:40', '2008-03-08 01:17:40');
INSERT INTO `articles` VALUES ('47d71d43-c908-477b-a008-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'Test Article', '<p>yadda yadda</p>', '2008-03-11 18:01:07', '2008-03-11 18:01:07');
INSERT INTO `articles` VALUES ('47d75f98-cbe0-4649-b7e9-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'Test 123', '<p>234123412</p>', '2008-03-11 22:44:08', '2008-03-14 14:50:02');
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
INSERT INTO `groups` VALUES ('103', 'BEE World', 'bee-world', '', null, null, 'http://www.beeworld.org/', '', '', '', '', '', '', null, 'Some very descriptive text here.', '1', '2008-02-19 20:35:24', '2008-03-11 13:28:06', '0');
INSERT INTO `groups` VALUES ('104', 'Covenant Theological Seminary', 'covenant-theological-seminary', '', null, null, 'http://www.letu.edu/', '8675309', '9 Westlake Ave', 'APO 320', 'St. Louis', 'MO', '80132', null, 'Some very descriptive text here.', '1', '2008-02-19 20:35:37', '2008-02-19 20:35:37', '0');
INSERT INTO `nodes` VALUES ('47d6e489-a6b0-45b0-ba33-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Forward', '0', null, '2', '2008-03-11 13:59:05', '2008-03-12 14:41:23');
INSERT INTO `nodes` VALUES ('47d6c673-9418-42be-941f-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Unit One: Introduction and Theology Proper', '0', null, '3', '2008-03-11 11:50:43', '2008-03-12 14:41:27');
INSERT INTO `nodes` VALUES ('47d6c679-6760-4465-b049-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Unit Two: Bibliology', '0', null, '4', '2008-03-11 11:50:49', '2008-03-12 14:41:27');
INSERT INTO `nodes` VALUES ('47d6c680-b8f4-4a8c-9568-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Unit Three: God\'s Highest Creations: Angels and Man', '0', null, '5', '2008-03-11 11:50:56', '2008-03-12 14:41:27');
INSERT INTO `nodes` VALUES ('47d6c686-152c-4c8f-8a14-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Unit Four', '0', null, '6', '2008-03-11 11:51:02', '2008-03-12 14:44:01');
INSERT INTO `nodes` VALUES ('47d84030-ef0c-4fcd-a79b-01a4ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Topic 3: The Knowledge of God', '0', null, '3', '2008-03-12 14:42:24', '2008-03-12 14:48:00');
INSERT INTO `nodes` VALUES ('47d6c68e-9208-4a82-9e79-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '0', 'Lesson 1: Foundations of Theology', '0', null, '1', '2008-03-11 11:51:10', '2008-03-12 14:41:33');
INSERT INTO `nodes` VALUES ('47d6cb24-5c78-48f6-9dcb-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c69e-8378-4503-ba25-09acab4a69cb', '0', 'Topic 1: The Essence of God', '0', null, '0', '2008-03-11 12:10:44', '2008-03-11 12:10:44');
INSERT INTO `nodes` VALUES ('47d6c69e-8378-4503-ba25-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '0', 'Lesson 2: The Nature of God', '0', null, '2', '2008-03-11 11:51:26', '2008-03-12 14:41:38');
INSERT INTO `nodes` VALUES ('47d6cba7-8770-42d9-a420-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c69e-8378-4503-ba25-09acab4a69cb', '0', 'Self Check', '0', null, '2', '2008-03-11 12:12:55', '2008-03-11 12:12:55');
INSERT INTO `nodes` VALUES ('47d6c6ab-735c-43e9-91e0-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '0', 'Lesson 3: The Names of God and the Trinity', '0', null, '3', '2008-03-11 11:51:39', '2008-03-12 14:41:38');
INSERT INTO `nodes` VALUES ('47d6cf12-6a10-4c93-bcf4-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c6ab-735c-43e9-91e0-09acab4a69cb', '0', 'Topic 1: The Names of God', '0', null, '0', '2008-03-11 12:27:30', '2008-03-11 12:27:30');
INSERT INTO `nodes` VALUES ('47d6c6b8-49c0-4197-88b5-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '0', 'Unit One Exam', '0', null, '4', '2008-03-11 11:51:52', '2008-03-12 14:41:38');
INSERT INTO `nodes` VALUES ('47d6c99a-899c-4bb7-9c81-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c679-6760-4465-b049-09acab4a69cb', '0', 'Lesson 4: Special Revelation and Inspiration', '0', null, '0', '2008-03-11 12:04:10', '2008-03-11 12:04:10');
INSERT INTO `nodes` VALUES ('47d6c9a3-3b34-45ee-8533-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c99a-899c-4bb7-9c81-09acab4a69cb', '0', 'Lesson 4 Self Check: Doctrine 1', '0', null, '0', '2008-03-11 12:04:19', '2008-03-11 13:34:13');
INSERT INTO `nodes` VALUES ('47d6c9a8-06f0-46da-81ad-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c679-6760-4465-b049-09acab4a69cb', '0', 'Lesson 5: Canonicity', '0', null, '1', '2008-03-11 12:04:24', '2008-03-11 13:34:14');
INSERT INTO `nodes` VALUES ('47d6c9ac-1868-45f2-bb00-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c9a8-06f0-46da-81ad-09acab4a69cb', '0', 'Lesson 5: Canonicity Self Check', '0', null, '0', '2008-03-11 12:04:28', '2008-03-11 13:34:25');
INSERT INTO `nodes` VALUES ('47d6c9b0-67d8-47fa-9ec8-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c679-6760-4465-b049-09acab4a69cb', '0', 'Lesson 6: Authority and the Bible', '0', null, '2', '2008-03-11 12:04:32', '2008-03-11 13:34:21');
INSERT INTO `nodes` VALUES ('47d6c9b5-d78c-4884-ad78-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c9b0-67d8-47fa-9ec8-09acab4a69cb', '0', 'Lesson 6 Self Check: Doctrine 1', '0', null, '0', '2008-03-11 12:04:37', '2008-03-11 13:34:37');
INSERT INTO `nodes` VALUES ('47d6c9be-6f74-4cb1-bb67-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c679-6760-4465-b049-09acab4a69cb', '0', 'Unit Two Exam', '0', null, '3', '2008-03-11 12:04:46', '2008-03-11 13:34:37');
INSERT INTO `nodes` VALUES ('47d6c9c7-91f0-4ba8-b02b-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c680-b8f4-4a8c-9568-09acab4a69cb', '0', 'Lesson 7: Angels--Good and Bad', '0', null, '0', '2008-03-11 12:04:55', '2008-03-11 12:05:04');
INSERT INTO `nodes` VALUES ('47d6c9d6-e53c-4272-9bbe-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c9c7-91f0-4ba8-b02b-09acab4a69cb', '0', 'Lesson 7 Self Check', '0', null, '0', '2008-03-11 12:05:10', '2008-03-11 13:34:43');
INSERT INTO `nodes` VALUES ('47d6c9dc-688c-44f7-b8d5-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c680-b8f4-4a8c-9568-09acab4a69cb', '0', 'Lesson 8: Our Adversary the Devil', '0', null, '1', '2008-03-11 12:05:16', '2008-03-11 13:34:43');
INSERT INTO `nodes` VALUES ('47d6c9e0-e024-4982-87d5-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c9dc-688c-44f7-b8d5-09acab4a69cb', '0', 'Lesson 8 Self Check', '0', null, '0', '2008-03-11 12:05:20', '2008-03-11 13:34:46');
INSERT INTO `nodes` VALUES ('47d6c9e5-c53c-4540-b529-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c680-b8f4-4a8c-9568-09acab4a69cb', '0', 'Lesson 9: The Creation of Man', '0', null, '2', '2008-03-11 12:05:25', '2008-03-11 13:34:46');
INSERT INTO `nodes` VALUES ('47d6c9e9-4a7c-48ea-afc3-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c9e5-c53c-4540-b529-09acab4a69cb', '0', 'Lesson 9 Self Check', '0', null, '0', '2008-03-11 12:05:29', '2008-03-11 13:34:49');
INSERT INTO `nodes` VALUES ('47d6c9f1-12f0-4070-930d-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c680-b8f4-4a8c-9568-09acab4a69cb', '0', 'Unit Three Exam', '0', null, '3', '2008-03-11 12:05:37', '2008-03-11 13:42:29');
INSERT INTO `nodes` VALUES ('47d6ca00-537c-4cb1-8924-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6deea-e598-4d5e-8104-09acab4a69cb', '0', 'Lesson 10 Self Check: Doctrine 1', '0', null, '0', '2008-03-11 12:05:52', '2008-03-11 13:35:13');
INSERT INTO `nodes` VALUES ('47d6ca04-0af8-4ea8-b48d-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c686-152c-4c8f-8a14-09acab4a69cb', '0', 'Lesson 11: The Meaning of Sin', '0', null, '2', '2008-03-11 12:05:56', '2008-03-11 13:35:13');
INSERT INTO `nodes` VALUES ('47d6ca0a-2864-4c3e-922a-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca04-0af8-4ea8-b48d-09acab4a69cb', '0', 'Lesson 11 Self Check', '0', null, '0', '2008-03-11 12:06:02', '2008-03-11 13:34:56');
INSERT INTO `nodes` VALUES ('47d6ca46-68d0-4e01-904c-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Topic 1: Concepts in Theology', '0', null, '1', '2008-03-11 12:07:02', '2008-03-12 14:42:29');
INSERT INTO `nodes` VALUES ('47d6ca4a-0294-4651-8e5f-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Topic 2: Some Presuppositions', '0', null, '2', '2008-03-11 12:07:06', '2008-03-12 14:42:29');
INSERT INTO `nodes` VALUES ('47d6ca5f-65d0-4a58-9f3e-09acab4a69cb', '', '0', '0', 'Topic 3: The Knowledge of God', '0', null, '0', '2008-03-11 12:07:27', '2008-03-11 12:07:27');
INSERT INTO `nodes` VALUES ('47d6ca65-cb94-4a91-be88-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Topic 4: The Revelation of God', '0', null, '4', '2008-03-11 12:07:33', '2008-03-12 14:42:29');
INSERT INTO `nodes` VALUES ('47d6deea-e598-4d5e-8104-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c686-152c-4c8f-8a14-09acab4a69cb', '0', 'Lesson 10: The Facets and Fall of Man', '0', null, '1', '2008-03-11 13:35:06', '2008-03-11 13:35:41');
INSERT INTO `nodes` VALUES ('47d6ca80-4dec-4252-a87d-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d84030-ef0c-4fcd-a79b-01a4ab4a69cb', '0', 'Characteristics of the Knowledge of God', '0', null, '2', '2008-03-11 12:08:00', '2008-03-12 15:55:30');
INSERT INTO `nodes` VALUES ('47d6cab2-72bc-47b8-b08c-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Avenues of General Revelation', '0', null, '0', '2008-03-11 12:08:50', '2008-03-11 12:08:50');
INSERT INTO `nodes` VALUES ('47d6cab6-a838-4fd8-9084-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Cosmological Argument', '0', null, '1', '2008-03-11 12:08:54', '2008-03-11 12:08:54');
INSERT INTO `nodes` VALUES ('47d6cabb-cc60-4def-a7a4-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Teleological Argument', '0', null, '2', '2008-03-11 12:08:59', '2008-03-11 12:08:59');
INSERT INTO `nodes` VALUES ('47d6cac1-44b4-48e8-a10a-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Anthropological Argument-Man', '0', null, '3', '2008-03-11 12:09:05', '2008-03-11 12:09:05');
INSERT INTO `nodes` VALUES ('47d6cac7-880c-49a9-9e3b-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Ontological Argument', '0', null, '4', '2008-03-11 12:09:11', '2008-03-11 12:09:11');
INSERT INTO `nodes` VALUES ('47d6cacc-45ac-4fad-b96d-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Content of General Revelation', '0', null, '5', '2008-03-11 12:09:16', '2008-03-11 12:09:16');
INSERT INTO `nodes` VALUES ('47d6cae1-6ed0-4cd5-a405-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Value of General Revelation', '0', null, '6', '2008-03-11 12:09:37', '2008-03-11 12:09:37');
INSERT INTO `nodes` VALUES ('47d6cafe-4a98-4a38-a6c0-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Self Check', '0', null, '5', '2008-03-11 12:10:06', '2008-03-12 14:42:29');
INSERT INTO `nodes` VALUES ('47d6cb29-9e44-403e-97ce-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cb24-5c78-48f6-9dcb-09acab4a69cb', '0', 'God\'s Essence/nature', '0', null, '0', '2008-03-11 12:10:49', '2008-03-11 12:10:54');
INSERT INTO `nodes` VALUES ('47d6cb38-9898-4207-93b8-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cb24-5c78-48f6-9dcb-09acab4a69cb', '0', 'The Facets of God\'s Essence/nature', '0', null, '1', '2008-03-11 12:11:04', '2008-03-11 12:11:04');
INSERT INTO `nodes` VALUES ('47d6cb4d-193c-4824-86f3-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c69e-8378-4503-ba25-09acab4a69cb', '0', 'Topic 2: The Perfections of God', '0', null, '1', '2008-03-11 12:11:25', '2008-03-11 12:11:25');
INSERT INTO `nodes` VALUES ('47d6cb53-6540-4b67-8469-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cb4d-193c-4824-86f3-09acab4a69cb', '0', 'Characteristics of the Perfections/attributes of God', '0', null, '0', '2008-03-11 12:11:31', '2008-03-11 12:11:31');
INSERT INTO `nodes` VALUES ('47d6cb58-034c-47d4-9b50-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cb4d-193c-4824-86f3-09acab4a69cb', '0', 'Catalog of the Perfections/attributes', '0', null, '1', '2008-03-11 12:11:36', '2008-03-11 12:11:36');
INSERT INTO `nodes` VALUES ('47d6cb5c-316c-4c12-9875-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cb4d-193c-4824-86f3-09acab4a69cb', '0', 'Key Biblical Concepts', '0', null, '2', '2008-03-11 12:11:40', '2008-03-11 12:11:40');
INSERT INTO `nodes` VALUES ('47d6cf17-6174-40db-8e95-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c6ab-735c-43e9-91e0-09acab4a69cb', '0', 'Topic 2: The Trinity', '0', null, '1', '2008-03-11 12:27:35', '2008-03-11 12:27:35');
INSERT INTO `nodes` VALUES ('47d6cf53-c1d0-4dd1-89d9-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf17-6174-40db-8e95-09acab4a69cb', '0', 'Self Check', '0', null, '7', '2008-03-11 12:28:35', '2008-03-11 12:30:02');
INSERT INTO `nodes` VALUES ('47d6cf59-74f8-4f8e-98b3-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf12-6a10-4c93-bcf4-09acab4a69cb', '0', 'The Concept of a Name', '0', null, '0', '2008-03-11 12:28:41', '2008-03-11 12:28:41');
INSERT INTO `nodes` VALUES ('47d6cf5f-26cc-4791-8d7e-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf12-6a10-4c93-bcf4-09acab4a69cb', '0', 'Specific Names of God', '0', null, '1', '2008-03-11 12:28:47', '2008-03-11 12:28:47');
INSERT INTO `nodes` VALUES ('47d6cf67-cb24-4b5c-ba81-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf17-6174-40db-8e95-09acab4a69cb', '0', 'The Contribution of the Old Testament', '0', null, '0', '2008-03-11 12:28:55', '2008-03-11 12:28:55');
INSERT INTO `nodes` VALUES ('47d6cf70-52d4-412d-be5c-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf17-6174-40db-8e95-09acab4a69cb', '0', 'The Contribution of the New Testament', '0', null, '1', '2008-03-11 12:29:04', '2008-03-11 12:29:04');
INSERT INTO `nodes` VALUES ('47d6cf72-4638-4e13-8c8b-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf17-6174-40db-8e95-09acab4a69cb', '0', 'Theological Statement of the Doctrine of the Trinity', '0', null, '2', '2008-03-11 12:29:06', '2008-03-11 12:29:06');
INSERT INTO `nodes` VALUES ('47d6cf7a-9610-405d-b091-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf17-6174-40db-8e95-09acab4a69cb', '0', 'The Relationships of the Persons of the Godhead', '0', null, '3', '2008-03-11 12:29:14', '2008-03-11 12:29:14');
INSERT INTO `nodes` VALUES ('47d6cf83-1fc4-42e1-9f23-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf17-6174-40db-8e95-09acab4a69cb', '0', 'Illustrating the Trinity', '0', null, '4', '2008-03-11 12:29:23', '2008-03-11 12:29:23');
INSERT INTO `nodes` VALUES ('47d6cf87-2f1c-4b4d-9dc4-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf17-6174-40db-8e95-09acab4a69cb', '0', 'Errors Associated with the Doctrine of the Trinity', '0', null, '5', '2008-03-11 12:29:27', '2008-03-11 12:29:27');
INSERT INTO `nodes` VALUES ('47d6cf8d-9a0c-4425-903e-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6cf17-6174-40db-8e95-09acab4a69cb', '0', 'The Inscrutability of the Doctrine of the Trinity', '0', null, '6', '2008-03-11 12:29:33', '2008-03-11 12:29:33');
INSERT INTO `nodes` VALUES ('47d6d50f-c4d0-49ec-9c63-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Course Introduction', '0', null, '1', '2008-03-11 12:53:03', '2008-03-16 13:13:46');
INSERT INTO `nodes` VALUES ('47d6df4c-0918-468b-a5ae-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c686-152c-4c8f-8a14-09acab4a69cb', '0', 'Unit Four Exam', '0', null, '3', '2008-03-11 13:36:44', '2008-03-11 13:36:44');
INSERT INTO `nodes` VALUES ('47d84052-69cc-4acf-9c56-01a4ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d84030-ef0c-4fcd-a79b-01a4ab4a69cb', '0', 'The Possibility of the Knowledge of God', '0', null, '1', '2008-03-12 14:42:58', '2008-03-12 14:53:01');
INSERT INTO `nodes` VALUES ('a337b890-40b2-4e81-990b-2bfebc46efe7', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Test Page', '0', null, '7', '2008-03-13 10:07:01', '2008-03-14 16:09:59');
INSERT INTO `questions` VALUES ('47dc72e4-34fc-48d7-b945-14b0ab4a69cb', '47d6d50f-c4d0-49ec-9c63-09acab4a69cb', 'eafweawefawef', '1', '2', '', '0', 'Color', 'Taste', '', '2008-03-15 19:07:48', '2008-03-16 13:13:46');
INSERT INTO `questions` VALUES ('47dd716a-5d90-4465-98b2-14b0ab4a69cb', '47d6d50f-c4d0-49ec-9c63-09acab4a69cb', 'Put the following events in the correct order.', '3', '3', '', '1', '', '', '', '2008-03-16 13:13:46', '2008-03-16 13:13:46');
INSERT INTO `textareas` VALUES ('28', '224', '<blockquote>You are about to begin study of the Greatest Life Ever Lived! We are praying with you that this course will dramatically affect your life and ministry.</blockquote>\r\n<p>This course is part 1 of a 2 part course consisting of a total of 24 lessons.</p>\r\n<p><img src=\"/boyce-college/systematic-theology/files/lc0309_icon53_220.gif\" border=\"0\" width=\"220\" height=\"220\" /><img src=\"/boyce-college/systematic-theology/files/pg.gif\" border=\"0\" width=\"50\" height=\"50\" /><img src=\"/boyce-college/systematic-theology/files/pg.gif\" border=\"0\" width=\"50\" height=\"50\" /></p>', '2', '2008-02-27 09:59:22', '2008-03-10 14:55:52');
INSERT INTO `textareas` VALUES ('29', '228', '<p>asdfasdfa dasfasdfasd fasdfasdf</p>', '1', '2008-03-07 03:38:33', '2008-03-07 03:38:33');
INSERT INTO `textareas` VALUES ('47d5c560-9e98-4cd9-8a73-0814ab4a69cb', '47d5b3db-e848-47df-b9e9-0814ab4a69cb', '<p>You are about to begin an exciting and important study of the\r\nScriptures. We believe that your life will be significantly impacted as\r\nyou contemplate the knowledge of God in the following lessons.</p>\r\n<p>We have chosen <em>Basic Theology</em>, a book written by Dr. Charles\r\nC. Ryrie, as our text for this course. This book fairly presents\r\nalternative views of controversial doctrines and does it with a gentle\r\nand nonthreatening spirit. Also, we believe that you will find the way\r\nDr. Ryrie carefully outlines his many points and subpoints to be very\r\nhelpful to the preparation of Bible studies and sermons.</p>\r\n<p>If you look at the table of contents\r\nof Dr. Ryrie\'s book, you will note that he presents his topics in a\r\nnumber of categories. These categories are, for the most part, as first\r\norganized by John Calvin in his famous <em>Institutes of the Christian Religion</em>. In one form or another, most Protestant systematic theologies have followed them.</p>\r\n<p>Take a moment before going on to familiarize yourself with this\r\noverview by reviewing each of the topic categories in the chart below.</p>\r\n<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\"></embed>\r\n</object>\r\n</p>', '1', '2008-03-10 17:33:52', '2008-03-11 13:56:00');
INSERT INTO `textareas` VALUES ('47d5f477-d02c-4ad7-a405-0814ab4a69cb', '47d5b3e0-f454-4052-b543-0814ab4a69cb', '<p><img src=\"/boyce-college/asdf/files/john.jpg\" border=\"0\" width=\"300\" height=\"200\" /></p>', '1', '2008-03-10 20:54:47', '2008-03-10 20:54:47');
INSERT INTO `textareas` VALUES ('47d6d52e-4138-4dc2-9498-09acab4a69cb', '47d6d50f-c4d0-49ec-9c63-09acab4a69cb', '<h2>Description of the Course</h2>\r\n<p>This course offers an overview of the major teachings of the Bible concerning the person and work of God, the Word of God, history, angels, man, sin, and other subjects. Even though this is not a course on the evidences for the Christian faith, it will at times refer to historical and scientific evidence that supports the biblical view of the world and the truthfulness of the Scriptures. This course will also be giving special attention to some of the objections that have been raised against the central teachings of Christianity.</p>\r\n<p>The study of theology requires clear thinking, intellectual application, and a great deal of time and study. It is not an unimportant part of the Christian life. It is true that it can become purely intellectual and impractical, but this is essentially and practically not so.</p>\r\n<p>Doctrine is ultimately the most practical of all disciplines in the Christian life, for it is the basis for everything we do. Whenever a Christian prays, makes a righteous decision, goes to church, or does something loving or kind, he/she is making practical application of doctrine.</p>\r\n<p>Why does a Christian pray? The reason is that the Bible tells us that God wants fellowship with us through prayer and answers our prayers according to His will. Why does a Christian have peace and joy in the midst of trials and tragedies? The answer is that the believer has learned from the Bible that God is in control and has a purpose in these events and actions and that, even if the trial were to result in death, heaven and fellowship with the Lord await the Christian. Why does a Christian go to church? The Bible teaches us the importance of corporate worship. Why does a Christian seek to do something loving? The Bible teaches that God is love and that His children should emulate that characteristic.</p>\r\n<p>All these actions and attitudes are based on something learned from the Bible. In fact, this is a simple definition of doctrine or theology: what we learn and apply from the Bible. Therefore, it becomes intensely practical to know doctrine.</p>\r\n<p>As Christian leaders it is vitally important that we have a working knowledge of doctrine, or to put it more formally, of systematic theology. Many believers are struggling in their Christian lives because of a lack of clear theological teaching from the pulpit. With the knowledge gained in this course, you will be able to strengthen the faith of many as you grow in your knowledge of biblical theology.</p>\r\n<h2>Course Objectives</h2>\r\n<p>All of the Internet Biblical Seminary courses are based on the conviction that every Christian has a ministry. God has a purpose for your life and ministry. When you have completed this course you will be able to:</p>\r\n<ul>\r\n<li>Explain the major doctrines presented in this course</li>\r\n<li>Display greater submission to the authority and discipline of the Word of God in all matters pertaining to life and ministry</li>\r\n<li>Defend the Christian faith against several objections raised by critics</li>\r\n<li>Discern spiritual truths so that you may grow as a wise counselor to others</li>\r\n<li>Confront the teachings of many cults and explain from the Scriptures why they are in error</li>\r\n<li>Exhibit a sense of balance in understanding and applying scriptural truth</li>\r\n<li>Cite, from memory, book and chapter references which relate to the doctrines discussed in this course</li>\r\n<li>Prepare and teach this course to others in your own ministry setting</li>\r\n</ul>\r\n<h2>Course Organization</h2>\r\n<p>At any time during your online study, you can click the \"Course Outline\" button located in the top frame. This will cause the course outline to display in the left frame.</p>\r\n<h3>Units of Study</h3>\r\n<p>The lessons are grouped into four units:</p>\r\n<ul>\r\n<li>Unit 1: Introduction and Theology Proper \r\n<ul>\r\n<li>Lesson 1:Foundations of Theology</li>\r\n<li>Lesson 2: The Nature of God</li>\r\n<li>Lesson 3: The Names of God and the Trinity</li>\r\n</ul>\r\n</li>\r\n<li>Unit 2: Bibliology\r\n<ul>\r\n<li>Lesson 4: Special Revelation and Inspiration</li>\r\n<li>Lesson 5: Canonicity</li>\r\n<li>Lesson 6: Authority and the Bible</li>\r\n</ul>\r\n</li>\r\n<li>Unit 3: God\'s Highest Creations: Angels and Man\r\n<ul>\r\n<li>Lesson 7: Angels-Good and Bad</li>\r\n<li>Lesson 8: Our Adversary the Devil</li>\r\n<li>Lesson 9: The Creation of Man</li>\r\n</ul>\r\n</li>\r\n<li> Unit 4: Man, Sin, and the Christian Life\r\n<ul>\r\n<li>Lesson 10: The Facets and Fall of Man</li>\r\n<li>Lesson 11: The Meaning of Sin</li>\r\n<li>Lesson 12: Sin and the Individual Christian</li>\r\n</ul>\r\n</li>\r\n</ul>\r\n<p>As you plan your study schedule, decide the dates for when you want to finish each unit. You can then divide this time into study periods for each lesson.</p>\r\n<p>We suggest that you try to do a lesson a week or three lessons per month. You can do this if you study about one hour each day.</p>\r\n<h3>Lesson Organization</h3>\r\n<p>Please give careful attention to every part of the lesson:</p>\r\n<ul>\r\n<li>Title</li>\r\n<li>Lesson Outline</li>\r\n<li>Lesson Objectives</li>\r\n<li>Lesson Assignments</li>\r\n<li>Lesson Development</li>\r\n<li>Illustrations</li>\r\n</ul>\r\n<p>The title, outline, and objectives provide a preview of the lesson. Your mind will be more alert and receptive, and you will learn better because of this preview. The lesson assignments describe how and in what order to complete the lesson. The word study prepares you for special terms in the lesson. The lesson development follows the lesson outline. Its comments, suggestions, and questions all help you reach the lesson objectives. Be sure to check your answers with the ones given for the study questions. These will fix your attention once more on the main points of the lesson. This procedure is designed to make your learning more effective and long lasting. Make special note of the maps, charts, and other illustrations because they will help you to identify with a part of the early church, sharing its problems and letting the tremendous truths of these letters grip your heart. Also, you will find these illustrations useful in your preaching and teaching.</p>\r\n<h2>Textbooks for the Course</h2>\r\n<p>Your Bible is the main textbook for this course. To help you interpret and apply its teachings, you will use <em>Basic Theology</em> by Dr. Charles C. Ryrie with this course. You can click the link <a href=\"http://internetseminary.org/language/en/curriculum/courses/doctrine01/textbooks/Ryrie/ry0100.htm\" target=\"left\">Basic Theology</a> to read Ryrie\'s book whenever a link to <em>Basic Theology</em> is presented.</p>', '1', '2008-03-11 12:53:34', '2008-03-16 13:13:46');
INSERT INTO `textareas` VALUES ('47d6e46b-4cf4-454d-8fc4-09acab4a69cb', '47d5b3db-e848-47df-b9e9-0814ab4a69cb', '<p>You are about to begin an exciting and important study of the\r\nScriptures. We believe that your life will be significantly impacted as\r\nyou contemplate the knowledge of God in the following lessons.</p>\r\n<p>We have chosen <em>Basic Theology</em>, a book written by Dr. Charles\r\nC. Ryrie, as our text for this course. This book fairly presents\r\nalternative views of controversial doctrines and does it with a gentle\r\nand nonthreatening spirit. Also, we believe that you will find the way\r\nDr. Ryrie carefully outlines his many points and subpoints to be very\r\nhelpful to the preparation of Bible studies and sermons.</p>\r\n<p>If you look at the table of contents\r\nof Dr. Ryrie\'s book, you will note that he presents his topics in a\r\nnumber of categories. These categories are, for the most part, as first\r\norganized by John Calvin in his famous <em>Institutes of the Christian Religion</em>. In one form or another, most Protestant systematic theologies have followed them.</p>\r\n<p>Take a moment before going on to familiarize yourself with this\r\noverview by reviewing each of the topic categories in the chart below.</p>\r\n<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\"></embed>\r\n</object>\r\n</p>', '1', '2008-03-11 13:58:35', '2008-03-11 13:58:35');
INSERT INTO `textareas` VALUES ('47d6e4a8-936c-4325-890c-09acab4a69cb', '47d6e489-a6b0-45b0-ba33-09acab4a69cb', '<p>You are about to begin an exciting and important study of the\r\nScriptures. We believe that your life will be significantly impacted as\r\nyou contemplate the knowledge of God in the following lessons.</p>\r\n<p>We have chosen <em>Basic Theology</em>, a book written by Dr. Charles\r\nC. Ryrie, as our text for this course. This book fairly presents\r\nalternative views of controversial doctrines and does it with a gentle\r\nand nonthreatening spirit. Also, we believe that you will find the way\r\nDr. Ryrie carefully outlines his many points and subpoints to be very\r\nhelpful to the preparation of Bible studies and sermons.</p>\r\n<p>If you look at the table of contents\r\nof Dr. Ryrie\'s book, you will note that he presents his topics in a\r\nnumber of categories. These categories are, for the most part, as first\r\norganized by John Calvin in his famous <em>Institutes of the Christian Religion</em>. In one form or another, most Protestant systematic theologies have followed them.</p>\r\n<p>Take a moment before going on to familiarize yourself with this\r\noverview by reviewing each of the topic categories in the chart below.</p>\r\n<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\"></embed>\r\n</object>\r\n</p>', '1', '2008-03-11 13:59:36', '2008-03-11 13:59:36');
INSERT INTO `textareas` VALUES ('47d6e50e-6e80-406d-9d60-09acab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '<p>Although the word \"theology\" does not appear in the Bible, the\r\nconcept of theology and the formulation of theological information are\r\nvery much present. One must distinguish, however, between systematic\r\ntheology and the truths of Scripture. The Bible contains divine truth\r\nthat is timeless and unalterable, inviolable throughout all\r\ngenerations. Theology, on the other hand, needs to be freshly\r\nunderstood by each generation. As language and culture change, theology\r\nshould be refined (not redefined) to express the eternal, absolute\r\ntruths of the Scripture in terms that are relevant to the contemporary\r\nscene. As new problems and issues confront the church, theology must\r\nbring forth new emphases and clarifications. Theology must draw upon\r\nunchanging biblical truth to speak to the present situation and to\r\nprotect the purity of each generation\'s knowledge of God.</p>\r\n<p>One of the acknowledged dangers of studying theology is the risk\r\nthat whatever is learned will remain mere head knowledge. A student may\r\naccumulate an abundance of facts, but if they are left untranslated\r\ninto life, then they have virtually no value. Our desire is to lead you\r\ninto this wealth of information and at the same time guide you to apply\r\nthese wonderful truths in your daily walk with the Lord.</p>\r\n<p>The first unit of the course will orient you to the discipline of\r\nsystematic theology and the Person of God. What you learn in the first\r\nunit will be the foundation for the rest of the course. Enter this\r\nstudy with an expectant heart, seeking to know God in all His glory.\r\nBegin by reading the preface in the text, \"Who Should Read Theology\".</p>\r\n<h2>Unit Outline</h2>\r\n<ul>\r\n<li>Lesson 1: Foundations of Theology</li>\r\n<li>Lesson 2: The Nature of God</li>\r\n<li>Lesson 3: The Names of God and the Trinity</li>\r\n</ul>\r\n<h2>Unit Objectives</h2>\r\n<p>When you have completed this unit, you will be able to:</p>\r\n<ul>\r\n<li>Define systematic theology and compare it with other kinds of theological study</li>\r\n<li>Explain the presuppositions that underlie a study of systematic theology</li>\r\n<li>Discuss the four avenues through which God\'s general revelation is made known</li>\r\n<li>Defend the existence of God by using material covered in this unit on the general revelation of God</li>\r\n<li> Outline the four progressive steps in man\'s response to the revelation of God as presented in Rom 1:18-32</li>\r\n<li>Define and tell the difference between anthropopathisms and anthropomorphisms</li>\r\n<li>List and explain the perfections and names of God</li>\r\n<li>Discuss the theological basis for the doctrine of the Trinity</li>\r\n<li>List, define, and refute each of the five major errors associated historically with the doctrine of the Trinity</li>\r\n<li>Cite Scripture references for each of the key biblical concepts\r\nlisted at the end of each lesson and explain how each reference\r\nsupports the concept</li>\r\n</ul>', '1', '2008-03-11 14:01:18', '2008-03-11 14:01:18');
INSERT INTO `textareas` VALUES ('47d7205b-69e8-48a1-8cb7-08f8ab4a69cb', '47d6ca4a-0294-4651-8e5f-09acab4a69cb', '<p style=\"padding-left: 30px;\"><strong>Objective 2</strong> - When you have completed this topic, you will be able to name at least two of your presuppositions and explain how they affect the way your theology is formed and organized.</p>\r\n<p>An important point to realize in thinking about philosophy,\r\nreligion, life, and morals is that everyone, absolutely everyone, has\r\npresuppositions. Some have many; some have few. But everyone operates\r\non some kind of presuppositions. Do not ever let anyone accuse you of\r\nbeing biased or close-minded because you believe in God and the Bible\r\nas basic presuppositions. That person may have presuppositions against\r\nGod and the Bible and be as influenced by his presuppositions as you\r\nare by yours. Thus, the question ultimately becomes one of determining\r\nwhose presuppositions are the most likely to produce a philosophy or a\r\nlifestyle that is true and realistic.</p>\r\n<p>&nbsp;</p>\r\n<p>If you have not already read Ryrie, <a href=\"/bee-world/doctrine-1/books/chapter/47d7a390-091c-4da7-aa6f-01a4ab4a69cb\">chapter 2</a>, \"Some Presuppositions,\" please do so now.</p>\r\n<p>In order to answer questions 3-5 below, review the theological presuppositions outlined in the diagram below.</p>\r\n<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10101_b.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10101_b.swf\"></embed>\r\n</object>\r\n</p>', '1', '2008-03-11 18:14:19', '2008-03-12 14:36:22');
INSERT INTO `textareas` VALUES ('47d6ec6e-34e4-4a67-971f-09acab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10101_a.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10101_a.swf\"></embed>\r\n</object>\r\n</p>\r\n<h2>Lesson Objectives</h2>\r\n<p>When you have completed this lesson, you will be able to:</p>\r\n<ul>\r\n<li>Define theology and compare the three approaches to theology that are explained in Ryrie, chapter 1</li>\r\n<li>Name at least two of your presuppositions and explain how they affect the way your theology is formed and organized</li>\r\n<li>Define \"incomprehensibility\" and \"knowability\" in relation to the\r\nknowledge of God, supporting each one with a Scripture reference </li>\r\n<li>Name and describe four logical arguments which provide evidence for\r\nthe existence of God as He has revealed Himself in nature (the \"general\r\nrevelation\" of God)</li>\r\n</ul>\r\n<h2>Memory Verse</h2>\r\n<p>In this lesson you are to memorize Ps 90:2, relating to God\'s eternity. Be prepared to quote it from memory.</p>\r\n<h2>Reading Assignment</h2>\r\n<p>In this lesson your readings from Ryrie will be chapters 1, 2, 4, and 5. You may read them all at one time or as they are indicated.</p>', '1', '2008-03-11 14:32:46', '2008-03-11 14:32:46');
INSERT INTO `textareas` VALUES ('47d6ed49-c5c0-48d8-be34-09acab4a69cb', '47d6ca46-68d0-4e01-904c-09acab4a69cb', '<p>Objective 1 - When you have completed this topic, you will be able to define theology and compare the three approaches to theology that are explained in Ryrie, chapter 1.</p>\r\n<p>The word \"theology\" is a compound of two words, <em>theos</em>, meaning God, and <em>logos</em>,\r\nwhich relates to the idea of rational expression. This reflects the\r\ndefinition of Christian theology as the study of, and organized\r\nstatement about, the revelation of God. However, as this lesson will\r\nshow, there are various approaches to the subject of theology:\r\nhistorical, biblical, and systematic. It is important to understand\r\nthese different types of theology. This course is primarily a study of\r\nsystematic theology. How does this differ from the other two?</p>\r\n<p>Basic to a study in any area is an understanding of the terms and\r\nconcepts that will be used. If you have not already read Ryrie, chapter 1, \"Concepts and Definitions,\" please do so now.</p>', '1', '2008-03-11 14:36:25', '2008-03-12 01:27:54');
INSERT INTO `textareas` VALUES ('47d83ec6-6314-490e-b438-01a4ab4a69cb', '47d6ca4a-0294-4651-8e5f-09acab4a69cb', '<p>This completes our look at the introductory matters presented in our\r\ntext. But before beginning our study of theology itself, we want to\r\nstress that such study is more than an academic exercise. It is meant\r\nto affect our lives and the lives of those we touch.</p>\r\n<p>In your Life Notebook, describe how you think the study of theology can\r\nand should affect the development of Christian character.</p>\r\n<p>[Insert notebook icon]</p>', '6', '2008-03-12 14:36:22', '2008-03-12 14:36:22');
INSERT INTO `textareas` VALUES ('47d83ec6-f4f8-4262-b870-01a4ab4a69cb', '47d6ca4a-0294-4651-8e5f-09acab4a69cb', '<p>In summary, systematic theology is a crucial discipline for the\r\nChristian. Having revealed Himself to men, God invites them to\r\nunderstand all that they can about Him. To neglect that invitation or\r\nto ignore the challenge of theological study would be a tragedy. Let us\r\npursue the knowledge of God with vigor and wisdom.</p>', '8', '2008-03-12 14:36:22', '2008-03-12 14:36:22');
INSERT INTO `textareas` VALUES ('47d8415c-65b4-4377-84b1-01a4ab4a69cb', '47d84030-ef0c-4fcd-a79b-01a4ab4a69cb', '<p>Believing that the Bible (in the autograph, the original manuscripts\r\nof the Scriptures) is the inerrant and inspired record of God\'s\r\nrevelation, it is only logical for us to investigate what that record\r\nhas to say about the God whom we worship. God is the source of all\r\nthings, the cause of all things, the sustainer of all things. The more\r\nwe know about God, the more we can understand the meaning of our\r\nexistence.</p>\r\n<p>But how do we arrive at accurate knowledge of God? The only way that\r\ncan happen is if God chooses to reveal Himself. He has, of course,\r\nrevealed Himself in a general way through creation. As the psalmist\r\nsays, \"The heavens declare God\'s glory\" (Ps 19:1).  But for us to understand His love and purposes, we need special revelation. This revelation we call the Bible.</p>', '1', '2008-03-12 14:47:24', '2008-03-12 14:47:24');
INSERT INTO `textareas` VALUES ('47d84180-f278-43ac-aff3-01a4ab4a69cb', '47d84030-ef0c-4fcd-a79b-01a4ab4a69cb', '<p>Believing that the Bible (in the autograph, the original manuscripts\r\nof the Scriptures) is the inerrant and inspired record of God\'s\r\nrevelation, it is only logical for us to investigate what that record\r\nhas to say about the God whom we worship. God is the source of all\r\nthings, the cause of all things, the sustainer of all things. The more\r\nwe know about God, the more we can understand the meaning of our\r\nexistence.</p>\r\n<p>But how do we arrive at accurate knowledge of God? The only way that\r\ncan happen is if God chooses to reveal Himself. He has, of course,\r\nrevealed Himself in a general way through creation. As the psalmist\r\nsays, \"The heavens declare God\'s glory\" (Ps 19:1).  But for us to understand His love and purposes, we need special revelation. This revelation we call the Bible.</p>', '1', '2008-03-12 14:48:00', '2008-03-12 14:48:00');
INSERT INTO `textareas` VALUES ('47d84260-ba5c-4416-9657-01a4ab4a69cb', '47d84052-69cc-4acf-9c56-01a4ab4a69cb', '<p style=\"padding-left: 30px;\"><strong>Objective 3</strong> - When you have completed this topic, you will be able to define \"incomprehensibility\" and \"knowability\" in relation to the knowledge of God, supporting each one with a Scripture reference.</p>\r\n<h2>The Possibility of the Knowledge of God</h2>\r\n<p>If you have not already read Ryrie, <a href=\"/bee-world/doctrine-1/books/chapter/47d841e7-048c-44c5-80a2-01a4ab4a69cb\">chapter 4</a>,\r\n\"The Knowledge of God,\" please do so now. In chapter 4 Ryrie asks and\r\nanswers the question, Is it possible to know God? It is clear from the\r\ncountless religions in the history of the world that mankind in general\r\nwants to know, at least, if there is a God. Many sincerely want to know\r\nHim. Many means and methods have been used to try to achieve that\r\nknowledge.</p>\r\n<p>According to Ryrie, God can be known, but He cannot be known\r\ncompletely or exhaustively. He has revealed enough of Himself that we\r\ncan know all that we need to know about Him.</p>', '1', '2008-03-12 14:51:44', '2008-03-12 14:53:01');
INSERT INTO `textareas` VALUES ('47d84389-6090-4603-bf9e-01a4ab4a69cb', '47d6ca80-4dec-4252-a87d-09acab4a69cb', '<p>Ryrie deals with the characteristics of the knowledge of God in four\r\ncategories: their source, content, progressiveness, and purpose.</p>\r\n<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10101_c.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10101_c.swf\"></embed>\r\n</object>\r\n</p>', '1', '2008-03-12 14:56:41', '2008-03-12 15:55:30');
INSERT INTO `textareas` VALUES ('47d8d639-48f4-4f30-88f5-01a4ab4a69cb', '0d4c6099-5b31-4b89-a858-bc49e6f22b14', '<p>asdfsdf</p>', '1', '2008-03-13 01:22:33', '2008-03-13 01:22:33');
INSERT INTO `textareas` VALUES ('47d960a9-c964-4d34-b2e6-01a4ab4a69cb', 'a337b890-40b2-4e81-990b-2bfebc46efe7', '<p>sdfgdsf</p>', '1', '2008-03-13 11:13:13', '2008-03-14 16:09:59');
INSERT INTO `users` VALUES ('52', 'aaronshaf@gmail.com', '3a00070e691147f18e69201fc1431b0d39248af9', 'Aaron Shafovaloff', 'Aaron', 'Shafovaloff', 'abc', 'abc', 'Midvale', 'UT', '90210', '1', '0', null, '0', '1', '0000-00-00 00:00:00', '2008-02-19 20:39:50');
INSERT INTO `users` VALUES ('53', 'patty.thompson@fake_domain_name.org', null, 'patty.thompson', 'Patty', 'Thompson', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:36:38', '2008-02-19 20:36:38');
INSERT INTO `users` VALUES ('54', 'paul.walgren@fake_domain_name.org', null, 'paul.walgren', 'Paul', 'Walgren', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:36:52', '2008-02-19 20:36:52');
INSERT INTO `users` VALUES ('57', 'spamthisallyouwant@pysquared.com', 'f51917152d00e8f50f3bdde3674397b1e4825ffc', 'TestUserODD', 'John', 'Doe', '32325 CR 323', 'some 32 houses down', 'Killgore', 'TX', '75603', '1', '0', '47bba0d0-a538-4ba9-9cf1-08ccab4a69cb', '0', '0', '2008-02-19 20:38:56', '2008-02-19 20:38:56');
INSERT INTO `users` VALUES ('56', 'linus.torvalds@fake_domain_name.org', null, 'linus.torvalds', 'Linus', 'Torvalds', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:37:21', '2008-02-19 20:37:21');
