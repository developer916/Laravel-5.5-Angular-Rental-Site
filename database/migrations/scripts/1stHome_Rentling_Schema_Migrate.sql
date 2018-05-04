# IMPORTANT
# IMPORTANT: YOU MUST HAVE A RENTLING DATABASE WITH (FORMER RENTOMATO) TABLES BEFORE YOU CAN RUN THIS SCRIPT
# IMPORTANT

CREATE TABLE `data_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('SCtype','RentComponent','RoomCharge') NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `data_property_names` (
  `data_property_id` int(11) NOT NULL,
  `language_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user_property_constants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=533 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `rent_contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `template` longtext NOT NULL,
  `language_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `rent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `totalRent` decimal(10,2) NOT NULL,
  `serviceCost` decimal(10,2) NOT NULL,
  `notificationActiveFrom` date DEFAULT NULL,
  `notificationActiveTo` date DEFAULT NULL,
  `effectiveDate` date NOT NULL,
  `notificationDocument` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE rent CHANGE COLUMN user user_id int(11);

CREATE TABLE `rent_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `data_property` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `effective_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=677 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `deposit_charges` (
  `user` int(11) NOT NULL,
  `deposit` float NOT NULL,
  `cancel3m` int(11) NOT NULL,
  `cancel6m` int(11) NOT NULL,
  `cancel1y` int(11) NOT NULL,
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE deposit_charges CHANGE COLUMN user user_id int(11);

CREATE TABLE `general_charges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `amount` float NOT NULL,
  `chargetype` int(11) DEFAULT NULL COMMENT 'Points to a "data_properties" row having type="RoomCharge"',
  `comments` varchar(5000) DEFAULT NULL COMMENT 'Set on ad-hoc charges having chargeType=NULL',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE general_charges CHANGE COLUMN user user_id int(11);


CREATE TABLE `utility_meters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `entered_by_user_id` int(11) DEFAULT NULL,
  `remark` varchar(50) NOT NULL,
  `value_date` date NOT NULL,
  `meter_nr` varchar(20) NOT NULL,
  `meter_value` double NOT NULL,
  `measuring_unit` varchar(20) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=321 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `property_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `data_property` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `effective_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `room_cleanings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `charge_id` int(11) NOT NULL,
  `cleaning_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `room_visit_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `room_visit_id` int(10) unsigned NOT NULL,
  `response` enum('accept','reject') DEFAULT NULL,
  `response_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `room_visits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `visit_datetime` datetime NOT NULL,
  `visitor_name` varchar(200) NOT NULL,
  `visitor_phone` varchar(200) NOT NULL,
  `visitor_email` varchar(200) NOT NULL,
  `remarks` varchar(2048) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `handled_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `SCaccounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aptNr` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `costID` int(11) NOT NULL,
  `jpgFile` varchar(1024) DEFAULT NULL,
  `amountPP` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=283 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE SCaccounts CHANGE COLUMN aptNr property_id int(11);


CREATE TABLE `payment_imports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user_devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `device_type` enum('android','ios') NOT NULL,
  `device_token` varchar(2048) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `users_info` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT, 
  `phone` varchar(100) NOT NULL DEFAULT '',
  `birth_date` date DEFAULT NULL,
  `gender` enum('M','F') DEFAULT NULL,
  `occupation` enum('student','internship','work_part_time','work_full_time','looking_for_job') DEFAULT NULL,
  `source` enum('expatriates','kamernet','kamertje','former_tenant','other') DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `move_out_date` date DEFAULT NULL,
  `receive_visit_offers` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
