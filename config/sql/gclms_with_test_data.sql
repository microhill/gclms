/*
MySQL Data Transfer
Source Host: localhost
Source Database: gclms
Target Host: localhost
Target Database: gclms
Date: 3/6/2008 1:16:42 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for announcements
-- ----------------------------
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `facilitated_class_id` int(11) NOT NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `question_id` int(11) unsigned NOT NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `course_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for chapters
-- ----------------------------
DROP TABLE IF EXISTS `chapters`;
CREATE TABLE `chapters` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `textbook_id` int(11) unsigned default NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `content` varchar(255) NOT NULL,
  `facilitated_class_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=456 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for chat_participants
-- ----------------------------
DROP TABLE IF EXISTS `chat_participants`;
CREATE TABLE `chat_participants` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `facilitated_class_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=482 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_completions
-- ----------------------------
DROP TABLE IF EXISTS `class_completions`;
CREATE TABLE `class_completions` (
  `facilitated_class_id` int(11) unsigned NOT NULL default '0',
  `user_id` int(11) unsigned NOT NULL default '0',
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `facilitated_class_id` int(11) unsigned NOT NULL default '0',
  `user_id` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique` (`facilitated_class_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for class_facilitators
-- ----------------------------
DROP TABLE IF EXISTS `class_facilitators`;
CREATE TABLE `class_facilitators` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `facilitated_class_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for courses
-- ----------------------------
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `group_id` int(11) unsigned NOT NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `course_id` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `description` text,
  `lesson_item_order` int(11) unsigned default NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for facilitated_classes
-- ----------------------------
DROP TABLE IF EXISTS `facilitated_classes`;
CREATE TABLE `facilitated_classes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `course_id` int(11) unsigned NOT NULL,
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
  `id` char(32) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `forum_id` int(11) unsigned NOT NULL,
  `parent_post_id` int(11) unsigned NOT NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `facilitated_class_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) default NULL,
  `order` int(3) NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for grades
-- ----------------------------
DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `facilitated_class_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned default NULL,
  `user_id` int(11) NOT NULL,
  `grade` int(11) unsigned NOT NULL default '0',
  `maximum_possible` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for group_administrators
-- ----------------------------
DROP TABLE IF EXISTS `group_administrators`;
CREATE TABLE `group_administrators` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `course_id` int(11) unsigned NOT NULL,
  `parent_node_id` int(11) unsigned NOT NULL default '0',
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `course_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `node_id` int(11) unsigned NOT NULL default '0',
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `node_id` int(11) unsigned NOT NULL,
  `content` text,
  `order` int(11) unsigned NOT NULL default '9999',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for textbooks
-- ----------------------------
DROP TABLE IF EXISTS `textbooks`;
CREATE TABLE `textbooks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `course_id` int(11) unsigned default NULL,
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
  `id` int(11) NOT NULL auto_increment,
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
INSERT INTO `courses` VALUES ('92', '103', 'test', 'test', 'test', '', 'en', '0', '0', '0', '2008-02-26 13:17:18', '2008-02-26 13:17:18', '0');
INSERT INTO `group_administrators` VALUES ('40', '103', '52', '2008-02-26 13:11:47', '2008-02-26 13:11:47');
INSERT INTO `groups` VALUES ('103', 'Boyce College', 'boyce-college', '', null, null, 'http://www.letu.edu/', '8675309', '9 Westlake Ave', 'APO 320', 'Louisville', 'KY', '80132', null, 'Some very descriptive text here.', '1', '2008-02-19 20:35:24', '2008-02-19 20:35:24', '0');
INSERT INTO `groups` VALUES ('104', 'Covenant Theological Seminary', 'covenant-theological-seminary', '', null, null, 'http://www.letu.edu/', '8675309', '9 Westlake Ave', 'APO 320', 'St. Louis', 'MO', '80132', null, 'Some very descriptive text here.', '1', '2008-02-19 20:35:37', '2008-02-19 20:35:37', '0');
INSERT INTO `nodes` VALUES ('248', '92', '232', '0', 'asdfasdfsadf', '0', null, '9', '2008-02-27 17:39:50', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('246', '92', '232', '0', 'asdfasdfsadf', '0', null, '7', '2008-02-27 17:39:47', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('247', '92', '232', '0', 'asdfasdasdf', '0', null, '8', '2008-02-27 17:39:49', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('245', '92', '232', '0', 'afsdfasdf', '0', null, '6', '2008-02-27 17:39:46', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('241', '92', '232', '0', 'asdfsfsad', '0', null, '2', '2008-02-27 17:39:42', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('242', '92', '232', '0', 'asdfasdf', '0', null, '3', '2008-02-27 17:39:43', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('167', '0', '0', '0', '', '0', null, '1', '2008-02-26 15:16:28', '2008-02-26 15:16:28');
INSERT INTO `nodes` VALUES ('168', '0', '0', '0', '', '0', null, '3', '2008-02-26 15:16:28', '2008-02-28 12:28:57');
INSERT INTO `nodes` VALUES ('243', '92', '232', '0', 'fasdfsadf', '0', null, '4', '2008-02-27 17:39:44', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('244', '92', '232', '0', 'asdfasdf', '0', null, '5', '2008-02-27 17:39:45', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('227', '92', '233', '0', 'Using This Course', '0', null, '1', '2008-02-27 09:56:03', '2008-02-28 12:28:39');
INSERT INTO `nodes` VALUES ('228', '92', '0', '0', 'Unit One: His Preparation and Early Years', '0', null, '3', '2008-02-27 09:56:13', '2008-02-28 23:50:35');
INSERT INTO `nodes` VALUES ('229', '92', '228', '0', 'Lesson 1: Preparation for the Birth', '0', null, '1', '2008-02-27 09:56:35', '2008-02-27 10:02:05');
INSERT INTO `nodes` VALUES ('230', '92', '229', '0', 'Topic 1: Christ\'s Titles-Jesus, Christ, Son of God', '0', null, '1', '2008-02-27 09:56:42', '2008-02-27 20:03:16');
INSERT INTO `nodes` VALUES ('231', '92', '228', '0', 'Topic 2: Christ\'s (The Word) Manifestation in the Flesh', '0', null, '3', '2008-02-27 09:56:59', '2008-02-28 08:24:56');
INSERT INTO `nodes` VALUES ('232', '92', '228', '0', 'Topic 3: Christ\'s Lineage', '0', null, '2', '2008-02-27 09:57:18', '2008-02-28 08:24:56');
INSERT INTO `nodes` VALUES ('233', '92', '0', '0', 'Topic 4: The Historical Accuracy of the Record', '1', null, '4', '2008-02-27 09:57:26', '2008-02-28 23:50:35');
INSERT INTO `nodes` VALUES ('234', '92', '229', '0', 'Topic 5: An Answered Prayer', '0', null, '2', '2008-02-27 09:57:35', '2008-02-28 08:24:56');
INSERT INTO `nodes` VALUES ('238', '92', '167', '0', 'awfwe', '0', null, '1', '2008-02-27 15:13:14', '2008-02-27 15:13:17');
INSERT INTO `nodes` VALUES ('239', '92', '233', '0', 'fsdfsdf', '0', null, '2', '2008-02-27 17:21:32', '2008-02-28 12:28:39');
INSERT INTO `nodes` VALUES ('240', '92', '232', '0', 'tetse', '0', null, '1', '2008-02-27 17:39:41', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('224', '92', '0', '0', 'Course Introduction', '0', null, '1', '2008-02-27 09:55:40', '2008-02-28 23:50:35');
INSERT INTO `nodes` VALUES ('225', '92', '167', '0', 'One Solitary Life', '0', null, '0', '2008-02-27 09:55:46', '2008-02-27 15:13:02');
INSERT INTO `nodes` VALUES ('226', '92', '0', '0', 'Course Information', '1', null, '2', '2008-02-27 09:55:55', '2008-02-28 23:50:35');
INSERT INTO `nodes` VALUES ('249', '92', '232', '0', 'asdfasdfasdf', '0', null, '11', '2008-02-27 17:39:51', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('250', '92', '232', '0', 'asdfasdfsd', '0', null, '12', '2008-02-27 17:39:53', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('251', '92', '232', '0', 'asdfasdfsad', '0', null, '10', '2008-02-27 17:39:54', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('252', '92', '232', '0', 'asdfasdfasdf', '0', null, '13', '2008-02-27 17:39:55', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('253', '92', '232', '0', 'asdfasdsdfsadfds', '0', null, '14', '2008-02-27 17:39:57', '2008-02-28 04:56:11');
INSERT INTO `nodes` VALUES ('254', '92', '240', '0', 'asdfasdfasdfasdf', '0', null, '0', '2008-02-28 12:58:56', '2008-02-28 12:58:56');
INSERT INTO `nodes` VALUES ('255', '92', '228', '0', 'asdf', '0', null, '4', '2008-02-28 12:59:05', '2008-02-28 12:59:05');
INSERT INTO `textareas` VALUES ('28', '224', '<blockquote>You are about to begin study of the Greatest Life Ever Lived! We are praying with you that this course will dramatically affect your life and ministry.</blockquote> <p>This course is part 1 of a 2 part course consisting of a total of 24 lessons.</p>', '1', '2008-02-27 09:59:22', '2008-02-27 09:59:22');
INSERT INTO `users` VALUES ('52', 'aaronshaf@gmail.com', '3a00070e691147f18e69201fc1431b0d39248af9', 'aaronshaf', 'Aaron', 'Shafovaloff', 'abc', 'abc', 'Midvale', 'UT', '90210', '1', '0', null, '0', '1', '0000-00-00 00:00:00', '2008-02-19 20:39:50', '0');
INSERT INTO `users` VALUES ('53', 'patty.thompson@fake_domain_name.org', null, 'patty.thompson', 'Patty', 'Thompson', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:36:38', '2008-02-19 20:36:38', '0');
INSERT INTO `users` VALUES ('54', 'paul.walgren@fake_domain_name.org', null, 'paul.walgren', 'Paul', 'Walgren', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:36:52', '2008-02-19 20:36:52', '0');
INSERT INTO `users` VALUES ('57', 'spamthisallyouwant@pysquared.com', 'f51917152d00e8f50f3bdde3674397b1e4825ffc', 'TestUserODD', 'John', 'Doe', '32325 CR 323', 'some 32 houses down', 'Killgore', 'TX', '75603', '1', '0', '47bba0d0-a538-4ba9-9cf1-08ccab4a69cb', '0', '0', '2008-02-19 20:38:56', '2008-02-19 20:38:56', '0');
INSERT INTO `users` VALUES ('56', 'linus.torvalds@fake_domain_name.org', null, 'linus.torvalds', 'Linus', 'Torvalds', '21 Lakeside Drive', 'Apt #11', 'Beverly Hills', 'CA', '90210', '1', '0', null, '0', '0', '2008-02-19 20:37:21', '2008-02-19 20:37:21', '0');
