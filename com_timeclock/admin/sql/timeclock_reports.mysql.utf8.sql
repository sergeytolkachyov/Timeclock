CREATE TABLE IF NOT EXISTS `#__timeclock_reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `type` varchar(16) CHARACTER SET utf8 NOT NULL,
  `users` longtext CHARACTER SET utf8 NOT NULL,
  `timesheets` longtext CHARACTER SET utf8 NOT NULL,
  `projects` longtext CHARACTER SET utf8 NOT NULL,
  `customers` longtext CHARACTER SET utf8 NOT NULL,
  `departments` longtext CHARACTER SET utf8 NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`report_id`),
  UNIQUE KEY `date` (`startDate`,`endDate`,`type`)
) DEFAULT CHARSET=utf8;