/*
MySQL Data Transfer
Source Host: localhost
Source Database: gclms
Target Host: localhost
Target Database: gclms
Date: 5/10/2008 5:19:07 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for announcements
-- ----------------------------
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` char(36) NOT NULL,
  `virtual_class_id` char(36) NOT NULL,
  `title` varchar(255) default NULL,
  `post_date` date NOT NULL,
  `content` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`virtual_class_id`,`title`,`post_date`)
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
  `virtual_class_id` char(36) NOT NULL,
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
  `virtual_class_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=482 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_completions
-- ----------------------------
DROP TABLE IF EXISTS `class_completions`;
CREATE TABLE `class_completions` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL default '0',
  `course_id` char(36) NOT NULL,
  `virtual_class_id` char(36) NOT NULL default '0',
  `date` date NOT NULL,
  `grade` int(5) unsigned default NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_enrollees
-- ----------------------------
DROP TABLE IF EXISTS `class_enrollees`;
CREATE TABLE `class_enrollees` (
  `id` char(36) NOT NULL,
  `virtual_class_id` char(36) NOT NULL default '0',
  `user_id` char(36) NOT NULL default '0',
  `completion_deadline` date default NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`virtual_class_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_facilitators
-- ----------------------------
DROP TABLE IF EXISTS `class_facilitators`;
CREATE TABLE `class_facilitators` (
  `id` char(36) NOT NULL,
  `virtual_class_id` char(36) NOT NULL,
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
  `independent_study_allowed` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deprecated` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`web_path`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for facilitated_classes
-- ----------------------------
DROP TABLE IF EXISTS `facilitated_classes`;
CREATE TABLE `facilitated_classes` (
  `id` char(36) NOT NULL,
  `virtual_class_id` char(36) NOT NULL,
  `type` int(1) unsigned NOT NULL default '1',
  `enrollment_deadline` date default NULL,
  `beginning` date default NULL,
  `end` date default NULL,
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
  `virtual_class_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) default NULL,
  `order` int(3) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for glossary_terms
-- ----------------------------
DROP TABLE IF EXISTS `glossary_terms`;
CREATE TABLE `glossary_terms` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `term` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

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
-- Table structure for notebook_entries
-- ----------------------------
DROP TABLE IF EXISTS `notebook_entries`;
CREATE TABLE `notebook_entries` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `title` varchar(255) default NULL,
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
  `title` text,
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
-- Table structure for virtual_classes
-- ----------------------------
DROP TABLE IF EXISTS `virtual_classes`;
CREATE TABLE `virtual_classes` (
  `id` char(36) NOT NULL,
  `group_id` char(36) default NULL,
  `course_id` char(36) NOT NULL,
  `alias` varchar(255) default NULL,
  `facilitated` tinyint(4) NOT NULL default '1',
  `enrollment_deadline` date default NULL,
  `start` date default NULL,
  `end` date default NULL,
  `time_limit_years` int(2) default NULL,
  `time_limit_months` int(11) default NULL,
  `time_limit_days` int(11) default NULL,
  `capacity` int(11) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `answers` VALUES ('47fda809-3de8-450f-ae81-0b68ab4a69cb', '47fda809-a928-4a66-bce0-0b68ab4a69cb', 'asetaset', 'asetasetas', null, null, '0', '2008-04-09 23:39:21', '2008-04-09 23:39:21');
INSERT INTO `answers` VALUES ('47fda809-3f44-4a6d-9db5-0b68ab4a69cb', '47fda809-a928-4a66-bce0-0b68ab4a69cb', 'asetaet', 'asetataset', null, null, '0', '2008-04-09 23:39:21', '2008-04-09 23:39:21');
INSERT INTO `answers` VALUES ('47fda809-06f4-42f8-842f-0b68ab4a69cb', '47fda809-a928-4a66-bce0-0b68ab4a69cb', 'gregerger', 'gergergregegerger', null, null, '0', '2008-04-09 23:39:21', '2008-04-09 23:39:21');
INSERT INTO `answers` VALUES ('47fdbb15-06cc-4c8f-ad03-0b68ab4a69cb', '47fdbb15-f698-48a2-887e-0b68ab4a69cb', 'Blue', null, null, null, '1', '2008-04-10 01:00:37', '2008-04-10 01:00:37');
INSERT INTO `answers` VALUES ('47fdbb15-26f0-4a5f-845c-0b68ab4a69cb', '47fdbb15-f698-48a2-887e-0b68ab4a69cb', 'Green', null, null, null, '0', '2008-04-10 01:00:37', '2008-04-10 01:00:37');
INSERT INTO `answers` VALUES ('47fdbb15-2450-4f84-b621-0b68ab4a69cb', '47fdbb15-f698-48a2-887e-0b68ab4a69cb', 'Red', null, null, null, '0', '2008-04-10 01:00:37', '2008-04-10 01:00:37');
INSERT INTO `answers` VALUES ('47fdbb15-2c6c-4d9b-a28b-0b68ab4a69cb', '47fdbb15-4924-443a-8ecd-0b68ab4a69cb', 'awefawefawefawefawef', 'awefawefawefawef', null, null, '0', '2008-04-10 01:00:37', '2008-04-10 01:00:37');
INSERT INTO `answers` VALUES ('47fdbb15-5460-4b02-8ca3-0b68ab4a69cb', '47fdbb15-4924-443a-8ecd-0b68ab4a69cb', 'awefawefawefawe', 'aewfawef', null, null, '0', '2008-04-10 01:00:37', '2008-04-10 01:00:37');
INSERT INTO `answers` VALUES ('47fdbb4d-75b8-4189-b17a-15e0ab4a69cb', '47fdbb4d-1890-4499-8d79-15e0ab4a69cb', 'Blue', null, null, null, '1', '2008-04-10 01:01:33', '2008-04-10 01:01:33');
INSERT INTO `answers` VALUES ('47fdbb4d-8da8-47c5-823b-15e0ab4a69cb', '47fdbb4d-1890-4499-8d79-15e0ab4a69cb', 'Green', null, null, null, '0', '2008-04-10 01:01:33', '2008-04-10 01:01:33');
INSERT INTO `answers` VALUES ('47fdbb4d-7e88-4c8d-98ff-15e0ab4a69cb', '47fdbb4d-1890-4499-8d79-15e0ab4a69cb', 'Red', null, null, null, '0', '2008-04-10 01:01:33', '2008-04-10 01:01:33');
INSERT INTO `answers` VALUES ('47fdbb4d-8514-4450-ab3a-15e0ab4a69cb', '47fdbb4d-954c-4150-aa21-15e0ab4a69cb', 'awefawefawefawefawef', 'awefawefawefawef', null, null, '0', '2008-04-10 01:01:33', '2008-04-10 01:01:33'), ('47fdbb4d-97f0-434c-99bf-15e0ab4a69cb', '47fdbb4d-954c-4150-aa21-15e0ab4a69cb', 'awefawefawefawe', 'aewfawef', null, null, '0', '2008-04-10 01:01:33', '2008-04-10 01:01:33');
INSERT INTO `courses` VALUES ('48175357-c2e0-4bb8-9b14-1804ab4a69cb', '47fb6906-c718-46c9-bc5d-1650ab4a69cb', 'Ù…Ù‚Ø¯Ù‘ÙŽÙ…Ø© Ù„Ù„Ù…Ø³Ø§Ù‚: Ø¯Ø±Ø§Ø³Ø© Ø§Ù„ÙƒØªØ§Ø¨ Ø§Ù„Ù…Ù‚Ø¯Ø³', 'Ù…Ù‚Ø¯Ù‘ÙŽÙ…Ø©-Ù„Ù„Ù…Ø³Ø§Ù‚-Ø¯Ø±Ø§Ø³Ø©-Ø§Ù„ÙƒØªØ§Ø¨-Ø§Ù„Ù…Ù‚Ø¯Ø³', '<p>Ù…Ù‚Ø¯Ù‘ÙŽÙ…Ø© Ù„Ù„Ù…Ø³Ø§Ù‚: Ø¯Ø±Ø§Ø³Ø© Ø§Ù„ÙƒØªØ§Ø¨ Ø§Ù„Ù…Ù‚Ø¯Ø³</p>', '', 'ar', '0', '0', '0', '0', '0', '2008-04-29 10:56:55', '2008-04-29 10:56:55', '0'), ('481771d6-d2f0-4900-8c07-1804ab4a69cb', '47fb6906-c718-46c9-bc5d-1650ab4a69cb', 'test2', 'test2', '<p>test</p>', 'blockquote {\r\n    FONT-WEIGHT: normal;\r\n    FONT-SIZE: 14px;\r\n    FONT-STYLE: normal;\r\n    FONT-VARIANT: normal;\r\n}\r\n\r\nh1 {\r\n    FONT: bold 18px Verdana, Arial, Helvetica, sans-serif;\r\n    COLOR: #006699;\r\n}\r\n\r\nh2 {\r\n    FONT-WEIGHT: bold;\r\n    FONT-SIZE: 16px;\r\n    COLOR: #006699;\r\n    FONT-STYLE: normal;\r\n    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;\r\n    FONT-VARIANT: normal;\r\n}\r\n\r\nh3 {\r\n    FONT-WEIGHT: bold;\r\n    FONT-SIZE: 14px;\r\n    COLOR: #006699;\r\n    FONT-STYLE: normal;\r\n    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;\r\n    FONT-VARIANT: normal;\r\n}\r\n\r\nh4 {\r\n    FONT-WEIGHT: normal;\r\n    FONT-SIZE: 14px;\r\n    COLOR: #006699;\r\n    FONT-STYLE: normal;\r\n    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;\r\n    FONT-VARIANT: normal;\r\n}\r\n\r\nh5 {\r\n    FONT-WEIGHT: bold;\r\n    FONT-SIZE: 14px;\r\n    COLOR: #006699;\r\n    FONT-STYLE: normal;\r\n    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;\r\n    FONT-VARIANT: normal;\r\n}\r\n\r\nh1 a { FONT-WEIGHT: bold; FONT-SIZE: 14px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; FONT-VARIANT: normal ; text-align: center; }\r\nh2 a { FONT-WEIGHT: normal; FONT-SIZE: 14px; FONT-STYLE: italic; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; FONT-VARIANT: normal ; text-align: center; }\r\nh3 a { FONT-WEIGHT: bold; FONT-SIZE: 12px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; FONT-VARIANT: normal ; text-align: left; }\r\n\r\np.leftmargin1 {\r\n    MARGIN-TOP: 0px;\r\n    MARGIN-BOTTOM: 0px;\r\n    MARGIN-LEFT: 5%;\r\n}\r\n\r\np.leftmargin2\r\n{\r\n    MARGIN-TOP: 0px;\r\n    MARGIN-BOTTOM: 0px;\r\n    MARGIN-LEFT: 10%;\r\n}\r\n\r\np.leftmargin3\r\n{\r\n    MARGIN-TOP: 0px;\r\n    MARGIN-BOTTOM: 0px;\r\n    MARGIN-LEFT: 15%;\r\n}\r\n\r\n.objective {\r\n    padding: 6px;\r\n    margin-left: 0;\r\n    border: 1px solid #C1C1C1;\r\n    padding-left: 32px;\r\n    background-repeat: no-repeat;\r\n    background-position: 6px 6px;\r\n    background-image: url(/bee-world/life-of-christ/files/objective-icon.png);\r\n    background-color: #EEEEEE;\r\n}', 'en', '0', '0', '0', '0', '0', '2008-04-29 13:07:02', '2008-05-05 12:53:35', '0');
INSERT INTO `group_administrators` VALUES ('47fb690d-21f4-4c38-b855-1650ab4a69cb', '47fb6906-c718-46c9-bc5d-1650ab4a69cb', '47fb68f7-8f60-4750-a0f7-1650ab4a69cb', '2008-04-08 06:46:05', '2008-04-08 06:46:05');
INSERT INTO `groups` VALUES ('47fb6906-c718-46c9-bc5d-1650ab4a69cb', 'test', 'test', null, null, '', '', '', '', '', '', '', null, 'test', '1', '2008-04-08 06:45:58', '2008-04-08 06:45:58', '0');
INSERT INTO `nodes` VALUES ('dbebbbc8-9b77-41ee-8c80-d716bebeabc4', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '0', '0', 'Course Introduction', '0', null, '1', '2008-04-10 00:56:59', '2008-04-10 01:05:44'), ('40261a05-99c3-4bd8-8d81-7edcb711d772', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '0', '0', 'Unit 1', '0', null, '2', '2008-04-10 00:57:02', '2008-04-10 01:02:56'), ('879cab90-a971-441d-8111-74d4543f76ee', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '0', '0', 'Unit 2', '0', null, '3', '2008-04-10 00:57:04', '2008-04-10 01:02:56'), ('feef76b7-4d16-4599-894a-a2951e97f156', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '0', '0', 'Unit 3', '0', null, '3', '2008-04-10 00:57:06', '2008-04-30 17:31:06'), ('d43e350a-0b88-4e67-9231-3e00a4716739', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '0', '0', 'Unit 4', '0', null, '4', '2008-04-10 00:57:10', '2008-04-30 17:31:06'), ('f8bfe367-3b14-4e58-ae8f-70799563f906', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '40261a05-99c3-4bd8-8d81-7edcb711d772', '0', 'Lesson 1', '0', null, '0', '2008-04-10 00:57:16', '2008-04-10 00:57:16'), ('3a1cc308-dc07-4ee9-ae5b-b6e69bd3ec0a', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '40261a05-99c3-4bd8-8d81-7edcb711d772', '0', 'Lesson 2', '0', null, '1', '2008-04-10 00:57:18', '2008-04-10 00:57:18'), ('74749d59-645c-40e5-a448-02c71352081e', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '40261a05-99c3-4bd8-8d81-7edcb711d772', '0', 'Lesson 3', '0', null, '2', '2008-04-10 00:57:21', '2008-04-10 00:57:21'), ('7f91525a-a390-4590-a3cf-d5881039a10e', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', 'f8bfe367-3b14-4e58-ae8f-70799563f906', '0', 'Topic A', '0', null, '0', '2008-04-10 00:57:25', '2008-04-10 00:57:25'), ('9b880161-54c5-4e9b-b406-9fbc5ed07e80', '47fb6fea-cd2c-4976-b67a-1650ab4a69cb', '7f91525a-a390-4590-a3cf-d5881039a10e', '0', 'Creation in the Book of Genesis', '0', null, '0', '2008-04-10 00:57:39', '2008-04-10 01:01:33'), ('13ad0c98-0c1b-4500-aeb5-9c1e3c29d16b', '47ffa5e3-8f54-451c-937e-15e0ab4a69cb', '0', '0', 'å’Œéµå®ˆçŒ¶å¤ªæ•™', '0', null, '0', '2008-04-11 11:59:35', '2008-04-11 12:00:09'), ('9cc1936a-7835-46bf-a591-15774755b856', '47ffa5e3-8f54-451c-937e-15e0ab4a69cb', '0', '0', 'å’Œéµå®ˆçŒ¶å¤ªæ•™', '0', null, '1', '2008-04-11 11:59:41', '2008-04-11 11:59:41'), ('15980449-f720-485c-96e0-51639358b79a', '47ffa5e3-8f54-451c-937e-15e0ab4a69cb', '0', '0', 'å’Œéµå®ˆçŒ¶å¤ªæ•™', '0', null, '2', '2008-04-11 11:59:43', '2008-04-11 11:59:43'), ('fc2bb236-c08a-4e0e-8c4c-5aa0a5290994', '48003e32-2668-436d-890d-111cab4a69cb', '0', '0', 'test', '0', null, '0', '2008-04-22 17:00:12', '2008-04-22 17:00:12'), ('167f2de6-b6b1-485d-9710-0c607c74abcd', '481771d6-d2f0-4900-8c07-1804ab4a69cb', 'b649d6bf-3839-420b-af72-d8b52653c74c', '0', 'test', '0', '', '1', '2008-04-30 17:17:54', '2008-05-09 13:10:30'), ('62187c82-8e90-401f-aee9-96c82e4e0515', '481771d6-d2f0-4900-8c07-1804ab4a69cb', '0', '0', 'test', '0', null, '2', '2008-04-30 11:23:29', '2008-04-30 17:30:57'), ('b649d6bf-3839-420b-af72-d8b52653c74c', '481771d6-d2f0-4900-8c07-1804ab4a69cb', '0', '0', 'awfwef', '0', '', '1', '2008-04-29 13:45:24', '2008-05-02 15:17:34'), ('f710d610-75f6-4808-abdc-e0f17c43fd09', '481771d6-d2f0-4900-8c07-1804ab4a69cb', 'b649d6bf-3839-420b-af72-d8b52653c74c', '0', 'awefawef', '0', null, '2', '2008-04-29 13:45:29', '2008-04-30 17:17:59'), ('48177dcf-2188-46c8-9150-1804ab4a69cb', '', '0', '0', '', '0', null, '0', '2008-04-29 13:58:07', '2008-04-29 13:58:07'), ('48177e63-8be4-4391-a405-1804ab4a69cb', '', '0', '0', 'test', '0', '', '0', '2008-04-29 14:00:35', '2008-04-29 14:00:35'), ('8d663469-66d2-4988-b7a6-e7c2f037f495', '481771d6-d2f0-4900-8c07-1804ab4a69cb', '62187c82-8e90-401f-aee9-96c82e4e0515', '0', 'test', '0', null, '0', '2008-04-30 17:31:03', '2008-04-30 17:31:06'), ('4f03742f-80f0-4932-a056-2a5e12830fe5', '481771d6-d2f0-4900-8c07-1804ab4a69cb', '0', '0', 'awefawefawefawe', '0', null, '3', '2008-05-06 10:57:52', '2008-05-06 10:57:52'), ('51836037-33a6-429b-b0dc-f312aa0999de', '481771d6-d2f0-4900-8c07-1804ab4a69cb', '4f03742f-80f0-4932-a056-2a5e12830fe5', '0', 'awefawefawefawefawef', '0', null, '1', '2008-05-06 10:57:55', '2008-05-06 10:57:55'), ('34c68700-1294-4008-b086-20f07450006d', '481771d6-d2f0-4900-8c07-1804ab4a69cb', '0', '0', 'awefawefawefawefawef', '0', null, '4', '2008-05-06 10:57:59', '2008-05-06 10:57:59'), ('c1eaa643-758b-473b-b36e-10283ec1f728', '481771d6-d2f0-4900-8c07-1804ab4a69cb', '34c68700-1294-4008-b086-20f07450006d', '0', 'awegwaegawegaweg', '0', null, '1', '2008-05-06 10:58:04', '2008-05-06 10:58:04');
INSERT INTO `questions` VALUES ('47fda809-a928-4a66-bce0-0b68ab4a69cb', 'b2d3b287-3054-41b0-95a0-1ef8fc0b082c', 'test', '2', '2', '', '1', 'atsetasets', 'asetasetaset', null, '2008-04-09 23:39:21', '2008-04-09 23:39:21'), ('47fdbb4d-ab94-4fb7-8f7f-15e0ab4a69cb', '9b880161-54c5-4e9b-b406-9fbc5ed07e80', 'Jody loves Ryrie', '1', '4', '', '1', '', '', '<p>Jody is from DTS.</p>', '2008-04-10 01:01:33', '2008-04-10 01:01:33'), ('47fdbb4d-954c-4150-aa21-15e0ab4a69cb', '9b880161-54c5-4e9b-b406-9fbc5ed07e80', 'awefaw efawefawe faewf aw', '2', '3', '', '1', 'awefawef', 'eafwwefawef', '', '2008-04-10 01:01:33', '2008-04-10 01:01:33'), ('47fdbb4d-1890-4499-8d79-15e0ab4a69cb', '9b880161-54c5-4e9b-b406-9fbc5ed07e80', 'What color is the sky?', '0', '2', '', '1', '', '', null, '2008-04-10 01:01:33', '2008-04-10 01:01:33'), ('47fdbb4d-0970-4117-a5d7-15e0ab4a69cb', '9b880161-54c5-4e9b-b406-9fbc5ed07e80', null, '1', '6', null, null, null, null, null, '2008-04-10 01:01:33', '2008-04-10 01:01:33');
INSERT INTO `textareas` VALUES ('47fda809-4f28-48c1-b7cb-0b68ab4a69cb', 'b2d3b287-3054-41b0-95a0-1ef8fc0b082c', '<p>aesfasefwefawefawefwef</p>', '1', '2008-04-09 23:39:21', '2008-04-09 23:39:21'), ('47fdbb4d-2fe4-44f5-b84c-15e0ab4a69cb', '9b880161-54c5-4e9b-b406-9fbc5ed07e80', '<p>veaewfwefawefawefawef</p>', '5', '2008-04-10 01:01:33', '2008-04-10 01:01:33'), ('47fdbb4d-1470-4810-a578-15e0ab4a69cb', '9b880161-54c5-4e9b-b406-9fbc5ed07e80', '', '1', '2008-04-10 01:01:33', '2008-04-10 01:01:33'), ('47fdbc48-d904-4c1f-85fb-15e0ab4a69cb', 'dbebbbc8-9b77-41ee-8c80-d716bebeabc4', '<p>I love John 1:1-3</p>', '1', '2008-04-10 01:05:44', '2008-04-10 01:05:44'), ('47ffa729-1ca4-4d3f-b4dd-15e0ab4a69cb', '13ad0c98-0c1b-4500-aeb5-9c1e3c29d16b', '<p>æ’’æ‹‰é è¡¨æ©å…¸ï¼›å¤ç”²é è¡¨å¾‹æ³•ã€‚åªæœ‰ä»¥æ’’ï¼Œæ†‘è‘—æ‡‰è¨±è€Œç”Ÿçš„æ‰æ˜¯äºžä¼¯æ‹‰ç½•çš„å¾Œè£”ï¼Œå¾—è’™æ‡‰è¨±çš„ç¦å’Œæ‰¿å—ç”¢æ¥­ã€‚(4:21-31)</p>\r\n<p>æ•…æ­¤ï¼Œäººæ˜¯é è‘—è–éˆè€Œå¾—å¾Œå—£çš„èº«ä»½(3:3, 14; 4:6, 29; 5:5, 25; 6:8)ï¼Œæ—¢é è‘—è–éˆå¾—ç”Ÿï¼Œå°±è¦é è‘—è–éˆè¡Œäº‹(5:25)ã€‚ä¸Ÿæ£„é‚£äº›é æƒ…æ…¾è€Œç”Ÿçš„ç½ª(5:19-21)ï¼Œçµå‡ºè–éˆçš„æžœå­(5:22-23)</p>', '1', '2008-04-11 12:00:09', '2008-04-11 12:00:09'), ('48177e63-4520-40e9-b526-1804ab4a69cb', '48177e63-8be4-4391-a405-1804ab4a69cb', '', '1', '2008-04-29 14:00:35', '2008-04-29 14:00:35'), ('48177e6c-21a0-41fd-ae91-1804ab4a69cb', 'b5e4f0aa-e1ba-4160-b492-669e57b29c44', '<p>test</p>', '1', '2008-04-29 14:04:19', '2008-04-29 14:04:19'), ('481b84ee-c490-4876-ad97-1804ab4a69cb', 'b649d6bf-3839-420b-af72-d8b52653c74c', '<p>Genesis 1:1</p>\r\n<p>Gen 1:1</p>\r\n<p>Ge 1:1</p>\r\n<p>Gn 1:1</p>', '1', '2008-05-02 15:17:34', '2008-05-02 15:17:34'), ('4824a181-365c-4471-8158-08b8ab4a69cb', '167f2de6-b6b1-485d-9710-0c607c74abcd', '<p><a href=\"../view/167f2de6-b6b1-485d-9710-0c607c74abcd\">awefawefawef</a></p>\r\n<p>aw</p>\r\n<p>ef</p>\r\n<p>awe</p>\r\n<p><img src=\"../../files/2463393936_b903659a74.jpg\" border=\"0\" width=\"500\" height=\"375\" /></p>\r\n<p>fwe</p>', '1', '2008-05-09 13:10:30', '2008-05-09 13:10:30');
INSERT INTO `users` VALUES ('47fb68f7-8f60-4750-a0f7-1650ab4a69cb', 'aaronshaf@gmail.com', '3a00070e691147f18e69201fc1431b0d39248af9', 'Aaron Shafovaloff', 'Aaron', 'Shafovaloff', null, null, null, null, null, '1', '0', null, '0', '1', '2008-04-08 06:45:43', '2008-04-08 06:45:43');
INSERT INTO `virtual_classes` VALUES ('481a1abb-f5c0-4d0b-a233-1804ab4a69cb', '47fb6906-c718-46c9-bc5d-1650ab4a69cb', '481771d6-d2f0-4900-8c07-1804ab4a69cb', 'test2', '1', '2008-04-04', '2008-01-01', '2008-12-10', null, null, null, '0', '2008-05-01 13:32:11', '2008-05-01 21:27:25'), ('481a1f9a-9308-47d8-93e7-1804ab4a69cb', '47fb6906-c718-46c9-bc5d-1650ab4a69cb', '48175357-c2e0-4bb8-9b14-1804ab4a69cb', 'waefawefw', '0', '2008-01-01', '2008-01-01', '2008-01-01', null, null, null, '0', '2008-05-01 13:52:58', '2008-05-01 14:38:32');
