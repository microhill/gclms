/*
MySQL Data Transfer
Source Host: localhost
Source Database: gclms
Target Host: localhost
Target Database: gclms
Date: 3/11/2008 9:25:03 PM
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
  `text` text,
  `correct` int(1) unsigned NOT NULL default '0',
  `explanation` text,
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
-- Table structure for chapters
-- ----------------------------
DROP TABLE IF EXISTS `chapters`;
CREATE TABLE `chapters` (
  `id` char(36) NOT NULL,
  `textbook_id` char(36) default NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `order` int(11) unsigned NOT NULL,
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
  `content` varchar(255) NOT NULL,
  `facilitated_class_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
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
  `grade` smallint(5) unsigned default NULL,
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
  `redistribution_allowed` int(1) NOT NULL default '0',
  `commercial_use_allowed` int(1) NOT NULL default '0',
  `derivative_works_allowed` int(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deprecated` int(1) unsigned NOT NULL default '0',
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
  `deprecated` int(1) unsigned NOT NULL default '0',
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
  `approved` int(1) unsigned NOT NULL default '0',
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
  `deprecated` int(1) unsigned NOT NULL default '0',
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
  `grade_recorded` int(1) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `type` int(1) unsigned NOT NULL default '0',
  `audio_file` varchar(255) default NULL,
  `order` int(11) unsigned NOT NULL default '0',
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
  `type` int(1) unsigned NOT NULL default '1',
  `order` int(3) unsigned NOT NULL default '1',
  `fill_in_the_blank_answer` varchar(255) default NULL,
  `true_false_answer` int(1) unsigned default NULL,
  `left_column_header` varchar(255) default NULL,
  `right_column_header` varchar(255) default NULL,
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
  `order` int(11) unsigned NOT NULL default '9999',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for textbooks
-- ----------------------------
DROP TABLE IF EXISTS `textbooks`;
CREATE TABLE `textbooks` (
  `id` char(36) NOT NULL,
  `course_id` char(36) default NULL,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

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
  `mailing_list` int(1) unsigned NOT NULL default '1',
  `autoplay_audio` int(1) unsigned NOT NULL default '0',
  `verification_code` varchar(255) default NULL,
  `verified` int(1) unsigned NOT NULL default '0',
  `super_administrator` int(1) unsigned NOT NULL default '0',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deprecated` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UniqueUsername` (`alias`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `answers` VALUES ('47d5a058-3a50-4473-85d6-0814ab4a69cb', '47d5a058-ff84-4bba-8d56-0814ab4a69cb', 'astse', '0', 'tasetset', '2008-03-10 14:55:52', '2008-03-10 14:55:52');
INSERT INTO `answers` VALUES ('47d5c560-48c8-44e8-baf6-0814ab4a69cb', '47d5c560-cd20-42ae-990b-0814ab4a69cb', 'waefef', '0', '', '2008-03-10 17:33:52', '2008-03-10 17:33:52');
INSERT INTO `answers` VALUES ('47d5c560-21dc-42f1-95d0-0814ab4a69cb', '47d5c560-cd20-42ae-990b-0814ab4a69cb', 'waefwef', '1', '', '2008-03-10 17:33:52', '2008-03-10 17:33:52');
INSERT INTO `answers` VALUES ('47d5c560-95dc-4e42-9fd3-0814ab4a69cb', '47d5c560-cd20-42ae-990b-0814ab4a69cb', 'fwefawef', '0', '', '2008-03-10 17:33:52', '2008-03-10 17:33:52');
INSERT INTO `answers` VALUES ('47d6ed49-51d4-4e43-a980-09acab4a69cb', '47d6ed49-d4f0-4bd3-8f7e-09acab4a69cb', 'Historical Theology ', '0', 'Organizes the progressive revelation of God\'s truth throughout the Bible', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `answers` VALUES ('47d6ed49-d49c-4461-b88f-09acab4a69cb', '47d6ed49-d4f0-4bd3-8f7e-09acab4a69cb', 'Biblical Theology', '0', 'Correlates the data from all of the Bible and organizes it into the major topics of biblical teaching ', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `answers` VALUES ('47d6ed49-3b60-40da-9722-09acab4a69cb', '47d6ed49-d4f0-4bd3-8f7e-09acab4a69cb', 'Systematic Theology ', '0', 'Focuses on what those who studied the Bible thought about its teaching ', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `answers` VALUES ('47d6ed49-21dc-4143-b78c-09acab4a69cb', '47d6ed49-8b9c-437e-ac55-09acab4a69cb', 'Presented in systematic form', '1', '', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `answers` VALUES ('47d6ed49-da40-4986-b1cf-09acab4a69cb', '47d6ed49-8b9c-437e-ac55-09acab4a69cb', 'Pays attention to history in which God\'s revelation came', '1', '', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `answers` VALUES ('47d6ed49-9238-41a5-ac1c-09acab4a69cb', '47d6ed49-8b9c-437e-ac55-09acab4a69cb', 'Studies revelation in a progressive sequence', '1', '', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `answers` VALUES ('47d6ed49-e00c-4a3d-8fc2-09acab4a69cb', '47d6ed49-8b9c-437e-ac55-09acab4a69cb', 'Correlates all the data of biblical revelation into topics', '0', '', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `answers` VALUES ('47d6ed49-5ccc-4596-bea6-09acab4a69cb', '47d6ed49-8b9c-437e-ac55-09acab4a69cb', 'Finds its source material in the Bible', '1', '', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `answers` VALUES ('47d6ed49-ea98-4c10-9d74-09acab4a69cb', '47d6ed49-8b9c-437e-ac55-09acab4a69cb', 'Traces the thinking of great theologians', '0', '', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `articles` VALUES ('21', '92', 'Test', '<p>test</p>', '2008-03-08 01:17:40', '2008-03-08 01:17:40');
INSERT INTO `articles` VALUES ('47d71d43-c908-477b-a008-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'Test Article', '<p>yadda yadda</p>', '2008-03-11 18:01:07', '2008-03-11 18:01:07');
INSERT INTO `chapters` VALUES ('47d71be2-5c0c-40d9-976a-08f8ab4a69cb', '47d71bd0-a17c-4bf3-af88-08f8ab4a69cb', 'Test Chapter 1', null, '1', '2008-03-11 17:55:14', '2008-03-11 17:55:14');
INSERT INTO `chapters` VALUES ('47d71be8-6640-4b64-b051-08f8ab4a69cb', '47d71bd0-a17c-4bf3-af88-08f8ab4a69cb', 'Test Chapter 2', null, '2', '2008-03-11 17:55:20', '2008-03-11 17:55:20');
INSERT INTO `courses` VALUES ('47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '103', 'Doctrine 1', 'doctrine-1', '<p>This course offers an overview of the major teachings of the Bible\r\nconcerning the person and work of God, the Word of God, history,\r\nangels, man, sin, and other subjects. Even though this is not a course\r\non the evidences for the Christian faith, it will at times refer to\r\nhistorical and scientific evidence that supports the biblical view of\r\nthe world and the truthfulness of the Scriptures. This course will also\r\nbe giving special attention to some of the objections that have been\r\nraised against the central teachings of Christianity.</p>\r\n<p>The study of theology requires clear thinking, intellectual\r\napplication, and a great deal of time and study. It is not an\r\nunimportant part of the Christian life. It is true that it can become\r\npurely intellectual and impractical, but this is essentially and\r\npractically not so.</p>\r\n<p>Doctrine is ultimately the most practical of all disciplines in the\r\nChristian life, for it is the basis for everything we do. Whenever a\r\nChristian prays, makes a righteous decision, goes to church, or does\r\nsomething loving or kind, he/she is making practical application of\r\ndoctrine.</p>', '', 'en', '0', '0', '0', '2008-03-10 15:46:53', '2008-03-11 13:42:00', '0');
INSERT INTO `dictionary_terms` VALUES ('47d71d6b-3044-4576-b73e-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'TestTerm', '<p>yadda yadda yadda</p>', '2008-03-11 18:01:47', '2008-03-11 18:01:47');
INSERT INTO `dictionary_terms` VALUES ('47d74467-cd80-49dc-9dc3-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'asdf', '<p>asdfasd</p>', '2008-03-11 20:48:07', '2008-03-11 20:48:07');
INSERT INTO `group_administrators` VALUES ('40', '103', '52', '2008-02-26 13:11:47', '2008-02-26 13:11:47');
INSERT INTO `groups` VALUES ('103', 'BEE World', 'bee-world', '', null, null, 'http://www.beeworld.org/', '', '', '', '', '', '', null, 'Some very descriptive text here.', '1', '2008-02-19 20:35:24', '2008-03-11 13:28:06', '0');
INSERT INTO `groups` VALUES ('104', 'Covenant Theological Seminary', 'covenant-theological-seminary', '', null, null, 'http://www.letu.edu/', '8675309', '9 Westlake Ave', 'APO 320', 'St. Louis', 'MO', '80132', null, 'Some very descriptive text here.', '1', '2008-02-19 20:35:37', '2008-02-19 20:35:37', '0');
INSERT INTO `nodes` VALUES ('47d6e489-a6b0-45b0-ba33-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Forward', '0', null, '2', '2008-03-11 13:59:05', '2008-03-11 13:59:36');
INSERT INTO `nodes` VALUES ('47d6c673-9418-42be-941f-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Unit One: Introduction and Theology Proper', '0', null, '3', '2008-03-11 11:50:43', '2008-03-11 14:01:18');
INSERT INTO `nodes` VALUES ('47d6c679-6760-4465-b049-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Unit Two: Bibliology', '0', null, '4', '2008-03-11 11:50:49', '2008-03-11 13:59:11');
INSERT INTO `nodes` VALUES ('47d6c680-b8f4-4a8c-9568-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Unit Three: God\'s Highest Creations: Angels and Man', '0', null, '5', '2008-03-11 11:50:56', '2008-03-11 13:59:11');
INSERT INTO `nodes` VALUES ('47d6c686-152c-4c8f-8a14-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Unit Three: God\'s Highest Creations: Angels and Man', '0', null, '6', '2008-03-11 11:51:02', '2008-03-11 13:59:11');
INSERT INTO `nodes` VALUES ('47d6c68e-9208-4a82-9e79-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '0', 'Lesson 1: Foundations of Theology', '0', null, '1', '2008-03-11 11:51:10', '2008-03-11 14:32:46');
INSERT INTO `nodes` VALUES ('47d6cb24-5c78-48f6-9dcb-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c69e-8378-4503-ba25-09acab4a69cb', '0', 'Topic 1: The Essence of God', '0', null, '0', '2008-03-11 12:10:44', '2008-03-11 12:10:44');
INSERT INTO `nodes` VALUES ('47d6c69e-8378-4503-ba25-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '0', 'Lesson 2: The Nature of God', '0', null, '3', '2008-03-11 11:51:26', '2008-03-11 11:53:08');
INSERT INTO `nodes` VALUES ('47d6cba7-8770-42d9-a420-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c69e-8378-4503-ba25-09acab4a69cb', '0', 'Self Check', '0', null, '2', '2008-03-11 12:12:55', '2008-03-11 12:12:55');
INSERT INTO `nodes` VALUES ('47d6c6ab-735c-43e9-91e0-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '0', 'Lesson 3: The Names of God and the Trinity', '0', null, '5', '2008-03-11 11:51:39', '2008-03-11 11:53:08');
INSERT INTO `nodes` VALUES ('47d6cf12-6a10-4c93-bcf4-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c6ab-735c-43e9-91e0-09acab4a69cb', '0', 'Topic 1: The Names of God', '0', null, '0', '2008-03-11 12:27:30', '2008-03-11 12:27:30');
INSERT INTO `nodes` VALUES ('47d6c6b8-49c0-4197-88b5-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '0', 'Unit One Exam', '0', null, '7', '2008-03-11 11:51:52', '2008-03-11 11:53:08');
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
INSERT INTO `nodes` VALUES ('47d6ca46-68d0-4e01-904c-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Topic 1: Concepts in Theology', '0', null, '0', '2008-03-11 12:07:02', '2008-03-11 14:36:25');
INSERT INTO `nodes` VALUES ('47d6ca4a-0294-4651-8e5f-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Topic 2: Some Presuppositions', '0', null, '1', '2008-03-11 12:07:06', '2008-03-11 18:14:19');
INSERT INTO `nodes` VALUES ('47d6ca5f-65d0-4a58-9f3e-09acab4a69cb', '', '0', '0', 'Topic 3: The Knowledge of God', '0', null, '0', '2008-03-11 12:07:27', '2008-03-11 12:07:27');
INSERT INTO `nodes` VALUES ('47d6ca65-cb94-4a91-be88-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Topic 4: The Revelation of God', '0', null, '2', '2008-03-11 12:07:33', '2008-03-11 12:07:33');
INSERT INTO `nodes` VALUES ('47d6deea-e598-4d5e-8104-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c686-152c-4c8f-8a14-09acab4a69cb', '0', 'Lesson 10: The Facets and Fall of Man', '0', null, '1', '2008-03-11 13:35:06', '2008-03-11 13:35:41');
INSERT INTO `nodes` VALUES ('47d6ca80-4dec-4252-a87d-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Characteristics of the Knowledge of God', '0', null, '7', '2008-03-11 12:08:00', '2008-03-11 13:59:11');
INSERT INTO `nodes` VALUES ('47d6cab2-72bc-47b8-b08c-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Avenues of General Revelation', '0', null, '0', '2008-03-11 12:08:50', '2008-03-11 12:08:50');
INSERT INTO `nodes` VALUES ('47d6cab6-a838-4fd8-9084-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Cosmological Argument', '0', null, '1', '2008-03-11 12:08:54', '2008-03-11 12:08:54');
INSERT INTO `nodes` VALUES ('47d6cabb-cc60-4def-a7a4-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Teleological Argument', '0', null, '2', '2008-03-11 12:08:59', '2008-03-11 12:08:59');
INSERT INTO `nodes` VALUES ('47d6cac1-44b4-48e8-a10a-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Anthropological Argument-Man', '0', null, '3', '2008-03-11 12:09:05', '2008-03-11 12:09:05');
INSERT INTO `nodes` VALUES ('47d6cac7-880c-49a9-9e3b-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Ontological Argument', '0', null, '4', '2008-03-11 12:09:11', '2008-03-11 12:09:11');
INSERT INTO `nodes` VALUES ('47d6cacc-45ac-4fad-b96d-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Content of General Revelation', '0', null, '5', '2008-03-11 12:09:16', '2008-03-11 12:09:16');
INSERT INTO `nodes` VALUES ('47d6cae1-6ed0-4cd5-a405-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6ca65-cb94-4a91-be88-09acab4a69cb', '0', 'Value of General Revelation', '0', null, '6', '2008-03-11 12:09:37', '2008-03-11 12:09:37');
INSERT INTO `nodes` VALUES ('47d6cafe-4a98-4a38-a6c0-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '0', 'Self Check', '0', null, '3', '2008-03-11 12:10:06', '2008-03-11 12:10:13');
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
INSERT INTO `nodes` VALUES ('47d6d50f-c4d0-49ec-9c63-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '0', '0', 'Course Introduction', '0', null, '1', '2008-03-11 12:53:03', '2008-03-11 17:40:41');
INSERT INTO `nodes` VALUES ('47d6df4c-0918-468b-a5ae-09acab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', '47d6c686-152c-4c8f-8a14-09acab4a69cb', '0', 'Unit Four Exam', '0', null, '3', '2008-03-11 13:36:44', '2008-03-11 13:36:44');
INSERT INTO `questions` VALUES ('47d5a058-ff84-4bba-8d56-0814ab4a69cb', '224', 'test', '0', '1', '', '1', '', '', '2008-03-10 14:55:52', '2008-03-10 14:55:52');
INSERT INTO `questions` VALUES ('47d5c560-38c8-48af-8d1f-0814ab4a69cb', '47d5b3db-e848-47df-b9e9-0814ab4a69cb', '1', '2', '1', 'awef', '1', '', '', '2008-03-10 17:33:52', '2008-03-10 17:33:52');
INSERT INTO `questions` VALUES ('47d5c560-a628-4d4c-a650-0814ab4a69cb', '47d5b3db-e848-47df-b9e9-0814ab4a69cb', '2', '1', '2', '', '1', '', '', '2008-03-10 17:33:52', '2008-03-10 17:33:52');
INSERT INTO `questions` VALUES ('47d5c560-cd20-42ae-990b-0814ab4a69cb', '47d5b3db-e848-47df-b9e9-0814ab4a69cb', '3', '0', '3', '', '1', '', '', '2008-03-10 17:33:52', '2008-03-10 17:33:52');
INSERT INTO `questions` VALUES ('47d6ed49-d4f0-4bd3-8f7e-09acab4a69cb', '47d6ca46-68d0-4e01-904c-09acab4a69cb', 'Match the type of theology with the correct definition. ', '3', '2', '', '1', 'Type of Theology', 'Definition', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `questions` VALUES ('47d6ed49-8b9c-437e-ac55-09acab4a69cb', '47d6ca46-68d0-4e01-904c-09acab4a69cb', 'Which items in the list below, according to Ryrie, are characteristics of biblical theology?', '0', '3', '', '1', '', '', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `textareas` VALUES ('28', '224', '<blockquote>You are about to begin study of the Greatest Life Ever Lived! We are praying with you that this course will dramatically affect your life and ministry.</blockquote>\r\n<p>This course is part 1 of a 2 part course consisting of a total of 24 lessons.</p>\r\n<p><img src=\"/boyce-college/systematic-theology/files/lc0309_icon53_220.gif\" border=\"0\" width=\"220\" height=\"220\" /><img src=\"/boyce-college/systematic-theology/files/pg.gif\" border=\"0\" width=\"50\" height=\"50\" /><img src=\"/boyce-college/systematic-theology/files/pg.gif\" border=\"0\" width=\"50\" height=\"50\" /></p>', '2', '2008-02-27 09:59:22', '2008-03-10 14:55:52');
INSERT INTO `textareas` VALUES ('29', '228', '<p>asdfasdfa dasfasdfasd fasdfasdf</p>', '1', '2008-03-07 03:38:33', '2008-03-07 03:38:33');
INSERT INTO `textareas` VALUES ('47d5c560-9e98-4cd9-8a73-0814ab4a69cb', '47d5b3db-e848-47df-b9e9-0814ab4a69cb', '<p>You are about to begin an exciting and important study of the\r\nScriptures. We believe that your life will be significantly impacted as\r\nyou contemplate the knowledge of God in the following lessons.</p>\r\n<p>We have chosen <em>Basic Theology</em>, a book written by Dr. Charles\r\nC. Ryrie, as our text for this course. This book fairly presents\r\nalternative views of controversial doctrines and does it with a gentle\r\nand nonthreatening spirit. Also, we believe that you will find the way\r\nDr. Ryrie carefully outlines his many points and subpoints to be very\r\nhelpful to the preparation of Bible studies and sermons.</p>\r\n<p>If you look at the table of contents\r\nof Dr. Ryrie\'s book, you will note that he presents his topics in a\r\nnumber of categories. These categories are, for the most part, as first\r\norganized by John Calvin in his famous <em>Institutes of the Christian Religion</em>. In one form or another, most Protestant systematic theologies have followed them.</p>\r\n<p>Take a moment before going on to familiarize yourself with this\r\noverview by reviewing each of the topic categories in the chart below.</p>\r\n<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\"></embed>\r\n</object>\r\n</p>', '1', '2008-03-10 17:33:52', '2008-03-11 13:56:00');
INSERT INTO `textareas` VALUES ('47d5f477-d02c-4ad7-a405-0814ab4a69cb', '47d5b3e0-f454-4052-b543-0814ab4a69cb', '<p><img src=\"/boyce-college/asdf/files/john.jpg\" border=\"0\" width=\"300\" height=\"200\" /></p>', '1', '2008-03-10 20:54:47', '2008-03-10 20:54:47');
INSERT INTO `textareas` VALUES ('47d6d52e-4138-4dc2-9498-09acab4a69cb', '47d6d50f-c4d0-49ec-9c63-09acab4a69cb', '<h2>Description of the Course</h2>\r\n<p>This course offers an overview of the major teachings of the Bible concerning the person and work of God, the Word of God, history, angels, man, sin, and other subjects. Even though this is not a course on the evidences for the Christian faith, it will at times refer to historical and scientific evidence that supports the biblical view of the world and the truthfulness of the Scriptures. This course will also be giving special attention to some of the objections that have been raised against the central teachings of Christianity.</p>\r\n<p>The study of theology requires clear thinking, intellectual application, and a great deal of time and study. It is not an unimportant part of the Christian life. It is true that it can become purely intellectual and impractical, but this is essentially and practically not so.</p>\r\n<p>Doctrine is ultimately the most practical of all disciplines in the Christian life, for it is the basis for everything we do. Whenever a Christian prays, makes a righteous decision, goes to church, or does something loving or kind, he/she is making practical application of doctrine.</p>\r\n<p>Why does a Christian pray? The reason is that the Bible tells us that God wants fellowship with us through prayer and answers our prayers according to His will. Why does a Christian have peace and joy in the midst of trials and tragedies? The answer is that the believer has learned from the Bible that God is in control and has a purpose in these events and actions and that, even if the trial were to result in death, heaven and fellowship with the Lord await the Christian. Why does a Christian go to church? The Bible teaches us the importance of corporate worship. Why does a Christian seek to do something loving? The Bible teaches that God is love and that His children should emulate that characteristic.</p>\r\n<p>All these actions and attitudes are based on something learned from the Bible. In fact, this is a simple definition of doctrine or theology: what we learn and apply from the Bible. Therefore, it becomes intensely practical to know doctrine.</p>\r\n<p>As Christian leaders it is vitally important that we have a working knowledge of doctrine, or to put it more formally, of systematic theology. Many believers are struggling in their Christian lives because of a lack of clear theological teaching from the pulpit. With the knowledge gained in this course, you will be able to strengthen the faith of many as you grow in your knowledge of biblical theology.</p>\r\n<h2>Course Objectives</h2>\r\n<p>All of the Internet Biblical Seminary courses are based on the conviction that every Christian has a ministry. God has a purpose for your life and ministry. When you have completed this course you will be able to:</p>\r\n<ul>\r\n<li>Explain the major doctrines presented in this course</li>\r\n<li>Display greater submission to the authority and discipline of the Word of God in all matters pertaining to life and ministry</li>\r\n<li>Defend the Christian faith against several objections raised by critics</li>\r\n<li>Discern spiritual truths so that you may grow as a wise counselor to others</li>\r\n<li>Confront the teachings of many cults and explain from the Scriptures why they are in error</li>\r\n<li>Exhibit a sense of balance in understanding and applying scriptural truth</li>\r\n<li>Cite, from memory, book and chapter references which relate to the doctrines discussed in this course</li>\r\n<li>Prepare and teach this course to others in your own ministry setting</li>\r\n</ul>\r\n<h2>Course Organization</h2>\r\n<p>At any time during your online study, you can click the \"Course Outline\" button located in the top frame. This will cause the course outline to display in the left frame.</p>\r\n<h3>Units of Study</h3>\r\n<p>The lessons are grouped into four units:</p>\r\n<ul>\r\n<li>Unit 1: Introduction and Theology Proper \r\n<ul>\r\n<li>Lesson 1:Foundations of Theology</li>\r\n<li>Lesson 2: The Nature of God</li>\r\n<li>Lesson 3: The Names of God and the Trinity</li>\r\n</ul>\r\n</li>\r\n<li>Unit 2: Bibliology\r\n<ul>\r\n<li>Lesson 4: Special Revelation and Inspiration</li>\r\n<li>Lesson 5: Canonicity</li>\r\n<li>Lesson 6: Authority and the Bible</li>\r\n</ul>\r\n</li>\r\n<li>Unit 3: God\'s Highest Creations: Angels and Man\r\n<ul>\r\n<li>Lesson 7: Angels-Good and Bad</li>\r\n<li>Lesson 8: Our Adversary the Devil</li>\r\n<li>Lesson 9: The Creation of Man</li>\r\n</ul>\r\n</li>\r\n<li>&nbsp;Unit 4: Man, Sin, and the Christian Life\r\n<ul>\r\n<li>Lesson 10: The Facets and Fall of Man</li>\r\n<li>Lesson 11: The Meaning of Sin</li>\r\n<li>Lesson 12: Sin and the Individual Christian</li>\r\n</ul>\r\n</li>\r\n</ul>\r\n<p>As you plan your study schedule, decide the dates for when you want to finish each unit. You can then divide this time into study periods for each lesson.</p>\r\n<p>We suggest that you try to do a lesson a week or three lessons per month. You can do this if you study about one hour each day.</p>\r\n<h3>Lesson Organization</h3>\r\n<p>Please give careful attention to every part of the lesson:</p>\r\n<ul>\r\n<li>Title</li>\r\n<li>Lesson Outline</li>\r\n<li>Lesson Objectives</li>\r\n<li>Lesson Assignments</li>\r\n<li>Lesson Development</li>\r\n<li>Illustrations</li>\r\n</ul>\r\n<p>The title, outline, and objectives provide a preview of the lesson. Your mind will be more alert and receptive, and you will learn better because of this preview. The lesson assignments describe how and in what order to complete the lesson. The word study prepares you for special terms in the lesson. The lesson development follows the lesson outline. Its comments, suggestions, and questions all help you reach the lesson objectives. Be sure to check your answers with the ones given for the study questions. These will fix your attention once more on the main points of the lesson. This procedure is designed to make your learning more effective and long lasting. Make special note of the maps, charts, and other illustrations because they will help you to identify with a part of the early church, sharing its problems and letting the tremendous truths of these letters grip your heart. Also, you will find these illustrations useful in your preaching and teaching.</p>\r\n<h2>Textbooks for the Course</h2>\r\n<p>Your Bible is the main textbook for this course. To help you interpret and apply its teachings, you will use <em>Basic Theology</em> by Dr. Charles C. Ryrie with this course. You can click the link <a href=\"http://internetseminary.org/language/en/curriculum/courses/doctrine01/textbooks/Ryrie/ry0100.htm\" target=\"left\">Basic Theology</a> to read Ryrie\'s book whenever a link to <em>Basic Theology</em> is presented.</p>', '1', '2008-03-11 12:53:34', '2008-03-11 17:40:41');
INSERT INTO `textareas` VALUES ('47d6e46b-4cf4-454d-8fc4-09acab4a69cb', '47d5b3db-e848-47df-b9e9-0814ab4a69cb', '<p>You are about to begin an exciting and important study of the\r\nScriptures. We believe that your life will be significantly impacted as\r\nyou contemplate the knowledge of God in the following lessons.</p>\r\n<p>We have chosen <em>Basic Theology</em>, a book written by Dr. Charles\r\nC. Ryrie, as our text for this course. This book fairly presents\r\nalternative views of controversial doctrines and does it with a gentle\r\nand nonthreatening spirit. Also, we believe that you will find the way\r\nDr. Ryrie carefully outlines his many points and subpoints to be very\r\nhelpful to the preparation of Bible studies and sermons.</p>\r\n<p>If you look at the table of contents\r\nof Dr. Ryrie\'s book, you will note that he presents his topics in a\r\nnumber of categories. These categories are, for the most part, as first\r\norganized by John Calvin in his famous <em>Institutes of the Christian Religion</em>. In one form or another, most Protestant systematic theologies have followed them.</p>\r\n<p>Take a moment before going on to familiarize yourself with this\r\noverview by reviewing each of the topic categories in the chart below.</p>\r\n<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\"></embed>\r\n</object>\r\n</p>', '1', '2008-03-11 13:58:35', '2008-03-11 13:58:35');
INSERT INTO `textareas` VALUES ('47d6e4a8-936c-4325-890c-09acab4a69cb', '47d6e489-a6b0-45b0-ba33-09acab4a69cb', '<p>You are about to begin an exciting and important study of the\r\nScriptures. We believe that your life will be significantly impacted as\r\nyou contemplate the knowledge of God in the following lessons.</p>\r\n<p>We have chosen <em>Basic Theology</em>, a book written by Dr. Charles\r\nC. Ryrie, as our text for this course. This book fairly presents\r\nalternative views of controversial doctrines and does it with a gentle\r\nand nonthreatening spirit. Also, we believe that you will find the way\r\nDr. Ryrie carefully outlines his many points and subpoints to be very\r\nhelpful to the preparation of Bible studies and sermons.</p>\r\n<p>If you look at the table of contents\r\nof Dr. Ryrie\'s book, you will note that he presents his topics in a\r\nnumber of categories. These categories are, for the most part, as first\r\norganized by John Calvin in his famous <em>Institutes of the Christian Religion</em>. In one form or another, most Protestant systematic theologies have followed them.</p>\r\n<p>Take a moment before going on to familiarize yourself with this\r\noverview by reviewing each of the topic categories in the chart below.</p>\r\n<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10000_a-foreword.swf\"></embed>\r\n</object>\r\n</p>', '1', '2008-03-11 13:59:36', '2008-03-11 13:59:36');
INSERT INTO `textareas` VALUES ('47d6e50e-6e80-406d-9d60-09acab4a69cb', '47d6c673-9418-42be-941f-09acab4a69cb', '<p>Although the word \"theology\" does not appear in the Bible, the\r\nconcept of theology and the formulation of theological information are\r\nvery much present. One must distinguish, however, between systematic\r\ntheology and the truths of Scripture. The Bible contains divine truth\r\nthat is timeless and unalterable, inviolable throughout all\r\ngenerations. Theology, on the other hand, needs to be freshly\r\nunderstood by each generation. As language and culture change, theology\r\nshould be refined (not redefined) to express the eternal, absolute\r\ntruths of the Scripture in terms that are relevant to the contemporary\r\nscene. As new problems and issues confront the church, theology must\r\nbring forth new emphases and clarifications. Theology must draw upon\r\nunchanging biblical truth to speak to the present situation and to\r\nprotect the purity of each generation\'s knowledge of God.</p>\r\n<p>One of the acknowledged dangers of studying theology is the risk\r\nthat whatever is learned will remain mere head knowledge. A student may\r\naccumulate an abundance of facts, but if they are left untranslated\r\ninto life, then they have virtually no value. Our desire is to lead you\r\ninto this wealth of information and at the same time guide you to apply\r\nthese wonderful truths in your daily walk with the Lord.</p>\r\n<p>The first unit of the course will orient you to the discipline of\r\nsystematic theology and the Person of God. What you learn in the first\r\nunit will be the foundation for the rest of the course. Enter this\r\nstudy with an expectant heart, seeking to know God in all His glory.\r\nBegin by reading the preface in the text, \"Who Should Read Theology\".</p>\r\n<h2>Unit Outline</h2>\r\n<ul>\r\n<li>Lesson 1: Foundations of Theology</li>\r\n<li>Lesson 2: The Nature of God</li>\r\n<li>Lesson 3: The Names of God and the Trinity</li>\r\n</ul>\r\n<h2>Unit Objectives</h2>\r\n<p>When you have completed this unit, you will be able to:</p>\r\n<ul>\r\n<li>Define systematic theology and compare it with other kinds of theological study</li>\r\n<li>Explain the presuppositions that underlie a study of systematic theology</li>\r\n<li>Discuss the four avenues through which God\'s general revelation is made known</li>\r\n<li>Defend the existence of God by using material covered in this unit on the general revelation of God</li>\r\n<li> Outline the four progressive steps in man\'s response to the revelation of God as presented in Rom 1:18-32</li>\r\n<li>Define and tell the difference between anthropopathisms and anthropomorphisms</li>\r\n<li>List and explain the perfections and names of God</li>\r\n<li>Discuss the theological basis for the doctrine of the Trinity</li>\r\n<li>List, define, and refute each of the five major errors associated historically with the doctrine of the Trinity</li>\r\n<li>Cite Scripture references for each of the key biblical concepts\r\nlisted at the end of each lesson and explain how each reference\r\nsupports the concept</li>\r\n</ul>', '1', '2008-03-11 14:01:18', '2008-03-11 14:01:18');
INSERT INTO `textareas` VALUES ('47d7205b-69e8-48a1-8cb7-08f8ab4a69cb', '47d6ca4a-0294-4651-8e5f-09acab4a69cb', '<p>yadda yadda TestTerm yadda</p>', '1', '2008-03-11 18:14:19', '2008-03-11 18:14:19');
INSERT INTO `textareas` VALUES ('47d6ec6e-34e4-4a67-971f-09acab4a69cb', '47d6c68e-9208-4a82-9e79-09acab4a69cb', '<p style=\"text-align: center;\">\r\n<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"450\" height=\"300\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\">\r\n<param name=\"src\" value=\"/bee-world/doctrine-1/files/d10101_a.swf\" /><embed type=\"application/x-shockwave-flash\" width=\"450\" height=\"300\" src=\"/bee-world/doctrine-1/files/d10101_a.swf\"></embed>\r\n</object>\r\n</p>\r\n<h2>Lesson Objectives</h2>\r\n<p>When you have completed this lesson, you will be able to:</p>\r\n<ul>\r\n<li>Define theology and compare the three approaches to theology that are explained in Ryrie, chapter 1</li>\r\n<li>Name at least two of your presuppositions and explain how they affect the way your theology is formed and organized</li>\r\n<li>Define \"incomprehensibility\" and \"knowability\" in relation to the\r\nknowledge of God, supporting each one with a Scripture reference </li>\r\n<li>Name and describe four logical arguments which provide evidence for\r\nthe existence of God as He has revealed Himself in nature (the \"general\r\nrevelation\" of God)</li>\r\n</ul>\r\n<h2>Memory Verse</h2>\r\n<p>In this lesson you are to memorize Ps 90:2, relating to God\'s eternity. Be prepared to quote it from memory.</p>\r\n<h2>Reading Assignment</h2>\r\n<p>In this lesson your readings from Ryrie will be chapters 1, 2, 4, and 5. You may read them all at one time or as they are indicated.</p>', '1', '2008-03-11 14:32:46', '2008-03-11 14:32:46');
INSERT INTO `textareas` VALUES ('47d6ed49-c5c0-48d8-be34-09acab4a69cb', '47d6ca46-68d0-4e01-904c-09acab4a69cb', '<p>Objective 1 - When you have completed this topic, you will be able to define theology and compare the three approaches to theology that are explained in Ryrie, chapter 1.</p>\r\n<p>The word \"theology\" is a compound of two words, <em>theos</em>, meaning God, and <em>logos</em>,\r\nwhich relates to the idea of rational expression. This reflects the\r\ndefinition of Christian theology as the study of, and organized\r\nstatement about, the revelation of God. However, as this lesson will\r\nshow, there are various approaches to the subject of theology:\r\nhistorical, biblical, and systematic. It is important to understand\r\nthese different types of theology. This course is primarily a study of\r\nsystematic theology. How does this differ from the other two?</p>\r\n<p>Basic to a study in any area is an understanding of the terms and\r\nconcepts that will be used. If you have not already read Ryrie, chapter 1, \"Concepts and Definitions,\" please do so now.</p>', '1', '2008-03-11 14:36:25', '2008-03-11 14:36:25');
INSERT INTO `textbooks` VALUES ('47d71bd0-a17c-4bf3-af88-08f8ab4a69cb', '47d5ac4d-ea3c-4973-b9d7-0814ab4a69cb', 'Test 1', '2008-03-11 17:54:56', '2008-03-11 17:54:56');
INSERT INTO `users` VALUES ('52', 'aaronshaf@gmail.com', '3a00070e691147f18e69201fc1431b0d39248af9', 'Aaron Shafovaloff', 'Aaron', 'Shafovaloff', 'abc', 'abc', 'Midvale', 'UT', '90210', '1', '0', null, '0', '1', '0000-00-00 00:00:00', '2008-02-19 20:39:50', '0');
INSERT INTO `users` VALUES ('53', 'patty.thompson@fake_domain_name.org', null, 'patty.thompson', 'Patty', 'Thompson', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:36:38', '2008-02-19 20:36:38', '0');
INSERT INTO `users` VALUES ('54', 'paul.walgren@fake_domain_name.org', null, 'paul.walgren', 'Paul', 'Walgren', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:36:52', '2008-02-19 20:36:52', '0');
INSERT INTO `users` VALUES ('57', 'spamthisallyouwant@pysquared.com', 'f51917152d00e8f50f3bdde3674397b1e4825ffc', 'TestUserODD', 'John', 'Doe', '32325 CR 323', 'some 32 houses down', 'Killgore', 'TX', '75603', '1', '0', '47bba0d0-a538-4ba9-9cf1-08ccab4a69cb', '0', '0', '2008-02-19 20:38:56', '2008-02-19 20:38:56', '0');
INSERT INTO `users` VALUES ('56', 'linus.torvalds@fake_domain_name.org', null, 'linus.torvalds', 'Linus', 'Torvalds', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:37:21', '2008-02-19 20:37:21', '0');
