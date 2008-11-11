/*
MySQL Data Transfer
Source Host: localhost
Source Database: gclms
Target Host: localhost
Target Database: gclms
Date: 11/11/2008 1:34:24 PM
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
  `text1` text,
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
-- Table structure for cake_sessions
-- ----------------------------
DROP TABLE IF EXISTS `cake_sessions`;
CREATE TABLE `cake_sessions` (
  `id` varchar(255) NOT NULL default '',
  `data` text,
  `expires` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `course_id` char(36) NOT NULL,
  `virtual_class_id` char(36) default NULL,
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
  `course_id` char(36) NOT NULL,
  `virtual_class_id` char(36) default NULL,
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
  `user_id` char(36) NOT NULL,
  `virtual_class_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`,`virtual_class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for course_administrators
-- ----------------------------
DROP TABLE IF EXISTS `course_administrators`;
CREATE TABLE `course_administrators` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for course_files
-- ----------------------------
DROP TABLE IF EXISTS `course_files`;
CREATE TABLE `course_files` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for course_images
-- ----------------------------
DROP TABLE IF EXISTS `course_images`;
CREATE TABLE `course_images` (
  `id` char(36) NOT NULL,
  `course_id` char(36) NOT NULL,
  `filename` varchar(255) NOT NULL default '',
  `width` int(11) unsigned default NULL,
  `height` int(11) unsigned default NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `course_id` (`course_id`,`filename`)
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
  `published_status` tinyint(1) NOT NULL default '0',
  `open` tinyint(1) NOT NULL default '1',
  `redistribution_allowed` tinyint(1) NOT NULL default '0',
  `commercial_use_allowed` tinyint(1) NOT NULL default '0',
  `derivative_works_allowed` tinyint(1) NOT NULL default '0',
  `independent_study_allowed` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deprecated` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`web_path`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for forum_posts
-- ----------------------------
DROP TABLE IF EXISTS `forum_posts`;
CREATE TABLE `forum_posts` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `forum_id` char(36) NOT NULL,
  `origin_post_id` char(36) NOT NULL,
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
  `course_id` char(36) default NULL,
  `virtual_class_id` char(36) default NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) default NULL,
  `type` int(1) unsigned NOT NULL default '0',
  `order` int(3) unsigned NOT NULL default '0',
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
  PRIMARY KEY  (`id`),
  UNIQUE KEY `web_path` (`web_path`)
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
  `locked` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `course_id` (`course_id`,`parent_node_id`)
) ENGINE=MyISAM AUTO_INCREMENT=256 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for notebook_entries
-- ----------------------------
DROP TABLE IF EXISTS `notebook_entries`;
CREATE TABLE `notebook_entries` (
  `id` char(36) NOT NULL default '',
  `user_id` char(36) NOT NULL,
  `course_id` char(36) default NULL,
  `question_id` char(36) default NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `private` tinyint(1) unsigned NOT NULL default '1',
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for notebook_entry_comments
-- ----------------------------
DROP TABLE IF EXISTS `notebook_entry_comments`;
CREATE TABLE `notebook_entry_comments` (
  `id` char(36) NOT NULL,
  `notebook_entry_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` char(36) NOT NULL,
  `user_id` char(36) default NULL,
  `group_id` char(36) default NULL,
  `course_id` char(36) default NULL,
  `virtual_class_id` char(36) default NULL,
  `model` varchar(255) default NULL,
  `foreign_key` char(36) default NULL,
  `_create` tinyint(1) default NULL,
  `_read` tinyint(1) default NULL,
  `_update` tinyint(1) default NULL,
  `_delete` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for question_responses
-- ----------------------------
DROP TABLE IF EXISTS `question_responses`;
CREATE TABLE `question_responses` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `question_id` char(36) NOT NULL,
  `correct` tinyint(1) default NULL,
  `answer` text,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UserIdAndQuestionId` (`user_id`,`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
-- Table structure for roster_users
-- ----------------------------
DROP TABLE IF EXISTS `roster_users`;
CREATE TABLE `roster_users` (
  `id` char(36) NOT NULL,
  `group_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`)
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
  `username` varchar(255) NOT NULL,
  `password` varchar(255) default NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `display_full_name` tinyint(1) NOT NULL default '0',
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
  UNIQUE KEY `UniqueUsername` (`username`),
  UNIQUE KEY `UniqueEmail` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- ----------------------------
-- Table structure for virtual_classes
-- ----------------------------
DROP TABLE IF EXISTS `virtual_classes`;
CREATE TABLE `virtual_classes` (
  `id` char(36) NOT NULL,
  `group_id` char(36) default NULL,
  `course_id` char(36) NOT NULL,
  `title` varchar(255) default NULL,
  `facilitated` tinyint(4) NOT NULL default '1',
  `enrollment_deadline` date default NULL,
  `start` date default NULL,
  `end` date default NULL,
  `time_limit_years` int(2) default NULL,
  `time_limit_months` int(11) default NULL,
  `time_limit_days` int(11) default NULL,
  `capacity` int(11) unsigned default NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
