-- Adminer 5.3.0 MariaDB 12.0.2-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siret` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `company` (`id`, `siret`, `name`, `phone_number`, `updated_at`, `created_at`) VALUES
(1,	'0123456789',	'Meta',	'0123456789',	NULL,	NULL),
(2,	'0123456789',	'Apple',	'0123456789',	NULL,	NULL),
(3,	'0123456789',	'Microsoft',	'0123456789',	NULL,	NULL),
(4,	'0123456789',	'Amazon',	'0123456789',	NULL,	NULL),
(5,	'0123456789',	'Google',	'0123456789',	NULL,	NULL);

DROP TABLE IF EXISTS `company_member`;
CREATE TABLE `company_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4D7B9E0DA76ED395` (`user_id`),
  KEY `IDX_4D7B9E0D979B1AD6` (`company_id`),
  CONSTRAINT `FK_4D7B9E0D979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_4D7B9E0DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `company_member` (`id`, `user_id`, `company_id`, `role`, `updated_at`, `created_at`) VALUES
(1,	18,	1,	'Tuteur',	NULL,	NULL),
(2,	19,	2,	'Tuteur',	NULL,	NULL),
(3,	20,	5,	'Tuteur',	NULL,	NULL),
(4,	21,	5,	'Représentant légal',	NULL,	NULL),
(5,	22,	2,	'Représentant légal',	NULL,	NULL),
(6,	23,	1,	'Représentant légal',	NULL,	NULL);

DROP TABLE IF EXISTS `info_form`;
CREATE TABLE `info_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intern_member_id` int(11) DEFAULT NULL,
  `info_form_intern_id` int(11) DEFAULT NULL,
  `info_form_organization_id` int(11) DEFAULT NULL,
  `info_form_company_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BE32FC1DAAC2B3C` (`info_form_intern_id`),
  UNIQUE KEY `UNIQ_BE32FC1DBB3C91D` (`info_form_organization_id`),
  UNIQUE KEY `UNIQ_BE32FC17470E03B` (`info_form_company_id`),
  KEY `IDX_BE32FC156817849` (`intern_member_id`),
  KEY `IDX_BE32FC1979B1AD6` (`company_id`),
  KEY `IDX_BE32FC132C8A3DE` (`organization_id`),
  CONSTRAINT `FK_BE32FC132C8A3DE` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`),
  CONSTRAINT `FK_BE32FC156817849` FOREIGN KEY (`intern_member_id`) REFERENCES `intern_member` (`id`),
  CONSTRAINT `FK_BE32FC17470E03B` FOREIGN KEY (`info_form_company_id`) REFERENCES `info_form_company` (`id`),
  CONSTRAINT `FK_BE32FC1979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_BE32FC1DAAC2B3C` FOREIGN KEY (`info_form_intern_id`) REFERENCES `info_form_intern` (`id`),
  CONSTRAINT `FK_BE32FC1DBB3C91D` FOREIGN KEY (`info_form_organization_id`) REFERENCES `info_form_organization` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form` (`id`, `intern_member_id`, `info_form_intern_id`, `info_form_organization_id`, `info_form_company_id`, `company_id`, `organization_id`, `status`, `updated_at`, `created_at`) VALUES
(1,	1,	1,	1,	1,	1,	1,	NULL,	NULL,	NULL),
(2,	2,	NULL,	NULL,	NULL,	5,	1,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `info_form_company`;
CREATE TABLE `info_form_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fax` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `activity_description` longtext DEFAULT NULL,
  `stamp` varchar(255) DEFAULT NULL,
  `legal_representative_gender` varchar(255) DEFAULT NULL,
  `legal_representative_last_name` varchar(255) DEFAULT NULL,
  `legal_representative_first_name` varchar(255) DEFAULT NULL,
  `legal_representative_signature` varchar(255) DEFAULT NULL,
  `legal_representative_email` varchar(255) DEFAULT NULL,
  `interview_start_date_time` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `interview_end_date_time` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `agree_terms` tinyint(1) DEFAULT NULL,
  `work_location` varchar(255) DEFAULT NULL,
  `tutor_gender` varchar(255) DEFAULT NULL,
  `tutor_first_name` varchar(255) DEFAULT NULL,
  `tutor_last_name` varchar(255) DEFAULT NULL,
  `tutor_email` varchar(255) DEFAULT NULL,
  `tutor_phone_number` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form_company` (`id`, `fax`, `activity`, `activity_description`, `stamp`, `legal_representative_gender`, `legal_representative_last_name`, `legal_representative_first_name`, `legal_representative_signature`, `legal_representative_email`, `interview_start_date_time`, `interview_end_date_time`, `agree_terms`, `work_location`, `tutor_gender`, `tutor_first_name`, `tutor_last_name`, `tutor_email`, `tutor_phone_number`, `updated_at`, `created_at`, `status`) VALUES
(1,	'osef',	'Facebook, Inc.',	'American social media and technology company known for its social networking site Facebook. Rebranded as Meta Platforms, Inc. in October 2021; operates platforms such as Facebook, Instagram, WhatsApp, and Messenger.',	NULL,	'Mme',	'Delacompta',	'Josiane',	NULL,	'josianedelacompta@gmail.com',	NULL,	NULL,	NULL,	'Hybrid',	'M',	'Johnny',	'Letuteur',	'johnnyletuteur@gmail.com',	'0102030405',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `info_form_company_calendar_row`;
CREATE TABLE `info_form_company_calendar_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_form_company_id` int(11) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `start_morning` time DEFAULT NULL COMMENT '(DC2Type:time_immutable)',
  `end_morning` time DEFAULT NULL COMMENT '(DC2Type:time_immutable)',
  `start_afternoon` time DEFAULT NULL COMMENT '(DC2Type:time_immutable)',
  `end_afternoon` time DEFAULT NULL COMMENT '(DC2Type:time_immutable)',
  `work_location` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_A9AA14DE7470E03B` (`info_form_company_id`),
  CONSTRAINT `FK_A9AA14DE7470E03B` FOREIGN KEY (`info_form_company_id`) REFERENCES `info_form_company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form_company_calendar_row` (`id`, `info_form_company_id`, `day`, `start_morning`, `end_morning`, `start_afternoon`, `end_afternoon`, `work_location`, `updated_at`, `created_at`) VALUES
(1,	1,	'Lundi',	'08:00:00',	'12:00:00',	'13:00:00',	'16:00:00',	'Hybrid',	NULL,	NULL),
(2,	1,	'Mardi',	'08:00:00',	'12:00:00',	'13:00:00',	'16:00:00',	'Hybrid',	NULL,	NULL),
(3,	1,	'Mercredi',	'08:00:00',	'12:00:00',	'13:00:00',	'16:00:00',	'Hybrid',	NULL,	NULL),
(4,	1,	'Jeudi',	'08:00:00',	'12:00:00',	'13:00:00',	'16:00:00',	'Hybrid',	NULL,	NULL),
(5,	1,	'Vendredi',	'08:00:00',	'12:00:00',	'13:00:00',	'16:00:00',	'Hybrid',	NULL,	NULL);

DROP TABLE IF EXISTS `info_form_intern`;
CREATE TABLE `info_form_intern` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_form_intern_company_id` int(11) DEFAULT NULL,
  `date_start` date DEFAULT NULL COMMENT '(DC2Type:date_immutable)',
  `date_end` date DEFAULT NULL COMMENT '(DC2Type:date_immutable)',
  `gender` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_78AFA1678F0DCFE2` (`info_form_intern_company_id`),
  CONSTRAINT `FK_78AFA1678F0DCFE2` FOREIGN KEY (`info_form_intern_company_id`) REFERENCES `info_form_intern_company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form_intern` (`id`, `info_form_intern_company_id`, `date_start`, `date_end`, `gender`, `updated_at`, `created_at`, `status`) VALUES
(1,	1,	'2025-12-01',	'2025-12-03',	'M',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `info_form_intern_company`;
CREATE TABLE `info_form_intern_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form_intern_company` (`id`, `company_name`, `address`, `email`, `contact_name`, `updated_at`, `created_at`) VALUES
(1,	'Facebook',	'2 rue du loup',	'tuteurfacebook@gmail.com',	'Tuteur Facebook',	NULL,	NULL);

DROP TABLE IF EXISTS `info_form_organization`;
CREATE TABLE `info_form_organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `validation_date` date DEFAULT NULL COMMENT '(DC2Type:date_immutable)',
  `signature` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form_organization` (`id`, `validation_date`, `signature`, `updated_at`, `created_at`, `status`) VALUES
(1,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `intern_member`;
CREATE TABLE `intern_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_31CB5C38A76ED395` (`user_id`),
  CONSTRAINT `FK_31CB5C38A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `intern_member` (`id`, `user_id`, `updated_at`, `created_at`) VALUES
(1,	3,	NULL,	NULL),
(2,	4,	NULL,	NULL),
(3,	5,	NULL,	NULL),
(4,	6,	NULL,	NULL),
(5,	7,	NULL,	NULL),
(6,	8,	NULL,	NULL),
(7,	9,	NULL,	NULL),
(8,	10,	NULL,	NULL),
(9,	11,	NULL,	NULL),
(10,	12,	NULL,	NULL),
(11,	13,	NULL,	NULL),
(12,	14,	NULL,	NULL),
(13,	15,	NULL,	NULL),
(14,	16,	NULL,	NULL),
(15,	17,	NULL,	NULL);

DROP TABLE IF EXISTS `intern_member_training_session`;
CREATE TABLE `intern_member_training_session` (
  `intern_member_id` int(11) NOT NULL,
  `training_session_id` int(11) NOT NULL,
  PRIMARY KEY (`intern_member_id`,`training_session_id`),
  KEY `IDX_7873472156817849` (`intern_member_id`),
  KEY `IDX_78734721DB8156B9` (`training_session_id`),
  CONSTRAINT `FK_7873472156817849` FOREIGN KEY (`intern_member_id`) REFERENCES `intern_member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_78734721DB8156B9` FOREIGN KEY (`training_session_id`) REFERENCES `training_session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `intern_member_training_session` (`intern_member_id`, `training_session_id`) VALUES
(1,	1),
(2,	1),
(3,	1),
(4,	1),
(5,	1),
(6,	1),
(7,	1),
(8,	1),
(9,	1),
(10,	1),
(11,	1),
(12,	1),
(13,	1),
(14,	1),
(15,	2);

DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `organization`;
CREATE TABLE `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siret` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `organization` (`id`, `siret`, `name`, `updated_at`, `created_at`) VALUES
(1,	'0123456789',	'Afpa',	NULL,	NULL);

DROP TABLE IF EXISTS `organization_member`;
CREATE TABLE `organization_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_756A2A8DA76ED395` (`user_id`),
  KEY `IDX_756A2A8D32C8A3DE` (`organization_id`),
  CONSTRAINT `FK_756A2A8D32C8A3DE` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`),
  CONSTRAINT `FK_756A2A8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `organization_member` (`id`, `user_id`, `organization_id`, `role`, `updated_at`, `created_at`) VALUES
(1,	1,	1,	'Formateur',	NULL,	NULL),
(2,	2,	1,	'Formateur',	NULL,	NULL),
(3,	24,	1,	'Monique',	NULL,	NULL),
(4,	6,	1,	'Monique',	NULL,	NULL);

DROP TABLE IF EXISTS `organization_member_training_session`;
CREATE TABLE `organization_member_training_session` (
  `organization_member_id` int(11) NOT NULL,
  `training_session_id` int(11) NOT NULL,
  PRIMARY KEY (`organization_member_id`,`training_session_id`),
  KEY `IDX_A4F87C184DA009F8` (`organization_member_id`),
  KEY `IDX_A4F87C18DB8156B9` (`training_session_id`),
  CONSTRAINT `FK_A4F87C184DA009F8` FOREIGN KEY (`organization_member_id`) REFERENCES `organization_member` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A4F87C18DB8156B9` FOREIGN KEY (`training_session_id`) REFERENCES `training_session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `organization_member_training_session` (`organization_member_id`, `training_session_id`) VALUES
(1,	2),
(2,	1);

DROP TABLE IF EXISTS `training`;
CREATE TABLE `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `training` (`id`, `name`, `updated_at`, `created_at`) VALUES
(1,	'CDA',	NULL,	NULL),
(2,	'CDUI',	NULL,	NULL);

DROP TABLE IF EXISTS `training_session`;
CREATE TABLE `training_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `training_id` int(11) DEFAULT NULL,
  `offer_number` varchar(255) DEFAULT NULL,
  `internship_period_start` date DEFAULT NULL COMMENT '(DC2Type:date_immutable)',
  `internship_period_end` date DEFAULT NULL COMMENT '(DC2Type:date_immutable)',
  `training_period_start` date DEFAULT NULL COMMENT '(DC2Type:date_immutable)',
  `training_period_end` date DEFAULT NULL COMMENT '(DC2Type:date_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_D7A45DABEFD98D1` (`training_id`),
  CONSTRAINT `FK_D7A45DABEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `training_session` (`id`, `training_id`, `offer_number`, `internship_period_start`, `internship_period_end`, `training_period_start`, `training_period_end`, `updated_at`, `created_at`) VALUES
(1,	1,	'0123456789',	'2025-12-01',	'2025-12-03',	'2025-12-01',	'2025-12-03',	NULL,	NULL),
(2,	2,	'0123456789',	'2025-12-01',	'2025-12-03',	'2025-12-01',	'2025-12-03',	NULL,	NULL);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `role` varchar(255) DEFAULT NULL,
  `notification` tinyint(1) DEFAULT NULL,
  `dark_mode` tinyint(1) DEFAULT NULL,
  `avatar`varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `login`, `updated_at`, `created_at`, `role`, `notification`, `dark_mode`, `avatar`) VALUES
(1,	'vpg@gmail.com',	'$2y$13$DCqcmcfTYU3q.t01thUr0OIWJr5D/SvxFF3sjH74OsaKN9/G2rfmK',	'Vincent',	'Pierre-Gaillard',	'vincentpg',	'2025-10-20 16:28:03',	'2025-10-20 16:28:03',	NULL,	NULL,	NULL, NULL),
(2,	'jérémiechabanais@gmail.com',	'$2y$13$3jfSIjbBADnm/bQkzKR6gevIlN1PO39GQssxhkN8rxYTJUECAt0Yq',	'Jérémie',	'Chabanais',	'jeremiec',	'2025-10-20 16:28:45',	'2025-10-20 16:28:45',	NULL,	NULL,	NULL, NULL),
(3,	'maximecouillet@gmail.com',	'$2y$13$7nG41tFtzJZOwo5ebjrFiOds8hhTs3v8v4j4uluLG3oKaVf.vew8G',	'Maxime',	'Couillet',	'maximec',	'2025-10-20 16:29:37',	'2025-10-20 16:29:37',	NULL,	NULL,	NULL, NULL),
(4,	'melissabedhomme@gmail.com',	'$2y$13$4vU32kQWsNhZA5AYUIJdeeAifdZfMuycbApUVHxlL6dkS/io/.68m',	'Mélissa',	'Bedhomme',	'melissab',	'2025-10-20 16:30:09',	'2025-10-20 16:30:09',	NULL,	NULL,	NULL, NULL),
(5,	'arnaurabel@gmail.com',	'$2y$13$zaB7zjMxgpZ7A2drGcELYu7dDWuRViQJr7JWTPYuLEQTG4RXOo.nO',	'Arnaud',	'Rabel',	'arnaudr',	'2025-10-20 16:30:32',	'2025-10-20 16:30:32',	NULL,	NULL,	NULL, NULL),
(6,	'monique@gmail.com',	'$2y$13$R64w.Fn4Q77ouv25eOW6gOw3/6wNqhgIDECIz9a/LveOiPAqxTaxC',	'Monique',	'Monique',	'monique',	'2025-10-20 16:31:02',	'2025-10-20 16:31:02',	NULL,	NULL,	NULL, NULL),
(7,	'amine-elkhal@gmail.com',	'$2y$13$qpBm5FQFDyvUZ7ktKYVvwOXeemc/iTvRIDHTYNTCIlnfU2fMW/52q',	'Amine',	'El Khal',	'aminel',	'2025-10-20 16:33:36',	'2025-10-20 16:33:36',	NULL,	NULL,	NULL, NULL),
(8,	'mounirsebti@gmail.com',	'$2y$13$PCo.TyRbXLEejags1J05yeM8CH64153FCrS9loYEKIKEPvP0Zwil2',	'Mounir',	'Sebti',	'mounirs',	'2025-10-20 16:34:21',	'2025-10-20 16:34:21',	NULL,	NULL,	NULL, NULL),
(9,	'margothourdille@gmail.com',	'$2y$13$iqKPXtRXsLpp8mtHXs42be.932l4e4NnCuSvhoHuo1shnbz0Qh4Ru',	'Margot',	'Hourdille',	'margoth',	'2025-10-20 16:34:48',	'2025-10-20 16:34:48',	NULL,	NULL,	NULL, NULL),
(10,	'julengouchault@gmail.com',	'$2y$13$wFxFY3CxdrhMEW5dpUs02OjQOLRh9qda/G/gRK8ly1iE0d2GvWoBu',	'Julen',	'Gouchault',	'juleng',	'2025-10-20 16:35:24',	'2025-10-20 16:35:24',	NULL,	NULL,	NULL, NULL),
(11,	'karimmohamed@gmail.com',	'$2y$13$MTaVcvFIaNdaUTBxLdxt3e5H03FUzBl2GnbWvc8B57sH26vpXNyna',	'Karim',	'Imad Mohamed',	'karimi',	'2025-10-20 16:36:00',	'2025-10-20 16:36:00',	NULL,	NULL,	NULL, NULL),
(12,	'sabrinabenoudiba@gmail.com',	'$2y$13$tkUj6jS7tr7lZwml8W6jiuh.UQWnTFxWL0Ca0/mKzXCNLzi.69exe',	'Sabrina',	'Benoudiba',	'sabrinab',	'2025-10-20 16:37:54',	'2025-10-20 16:37:54',	NULL,	NULL,	NULL, NULL),
(13,	'sariashamashan@gmail.com',	'$2y$13$gJVttro416qztjr3q/ubyu0xwyuDyq9J27ecSlbkUTQJBQK8X.7gW',	'Saria',	'Shamashan',	'sarias',	'2025-10-20 16:38:30',	'2025-10-20 16:38:30',	NULL,	NULL,	NULL, NULL),
(14,	'azizalahcen@gmail.com',	'$2y$13$qaO.3blj/bvgthnzLTb40uo/jLqLo1nSO7GehAqAVQnrLEc7eTLSa',	'Aziza',	'Ait Lahcen',	'azizal',	'2025-10-20 16:39:08',	'2025-10-20 16:39:08',	NULL,	NULL,	NULL, NULL),
(15,	'patiencekoribirama@gmail.com',	'$2y$13$aYM1./nWbarj1Lv8tWLOsOQdNs55yGLQoe50QPZlZxQu3ke896jMa',	'Patience',	'Koribirama',	'patiencek',	'2025-10-20 16:39:50',	'2025-10-20 16:39:50',	NULL,	NULL,	NULL, NULL),
(16,	'charlesproust@gmail.com',	'$2y$13$yBV0p0YErW7WJ0Cn4BShL.3.8Tk7wz.HOMBAHMUjARvOt.tFnuZNu',	'Charles',	'Proust',	'charlesp',	'2025-10-20 16:40:36',	'2025-10-20 16:40:36',	NULL,	NULL,	NULL, NULL),
(17,	'monalisacdui@gmail.com',	'$2y$13$txyfUjDvP9lly.N3q2yuMeu8sLQeFDVe6Zfn2eowdzIV9o9OhuQSe',	'Lisa',	'Mona',	'lisam',	'2025-10-20 18:07:21',	'2025-10-20 18:07:21',	NULL,	NULL,	NULL, NULL),
(18,	'tuteurfacebook@gmail.com',	'$2y$13$TiONor0uVxoU0uU4pQs1muV9yi0GMwpUWThsI7D7Rows1m0HqRBzC',	'Tuteur',	'Facebook',	'tuteurf',	'2025-10-20 18:08:37',	'2025-10-20 18:08:37',	NULL,	NULL,	NULL, NULL),
(19,	'tuteurapple@gmail.com',	'$2y$13$Tc4VxQZ.GWyXLHv5VBWfGOgRgk0INUDW3ZXHEK7XBz2mdEolZx4la',	'Tuteur',	'Apple',	'tuteura',	'2025-10-20 18:09:25',	'2025-10-20 18:09:25',	NULL,	NULL,	NULL, NULL),
(20,	'tuteurgoogle@gmail.com',	'$2y$13$SqSdNBxD3bCn6xq1WoSBx.2fP1vVRyC.bvMXF35cXL8qAbmpEEZDC',	'Tuteur',	'Google',	'tuteurg',	'2025-10-20 18:09:39',	'2025-10-20 18:09:39',	NULL,	NULL,	NULL, NULL),
(21,	'legalrpgoogle@gmail.com',	'$2y$13$h/M6Rk5OgSev5ve.i34She2i.JglDFV9xUhsaFAanRODUwR6HhaRq',	'Représentant légal',	'Google',	'legalrpg',	'2025-10-20 18:17:00',	'2025-10-20 18:17:00',	NULL,	NULL,	NULL, NULL),
(22,	'legalrpapple@gmail.com',	'$2y$13$3xlhHOVVSCaCL/4tQsgu3.rWGkKx8XKGrNPBIYeBAWjl21qrG/n6i',	'Représentant légal',	'Apple',	'legalrpa',	'2025-10-20 18:17:19',	'2025-10-20 18:17:19',	NULL,	NULL,	NULL, NULL),
(23,	'legalrpfacebook@gmail.com',	'$2y$13$gIbAQvhWoaDIfTdk07PXY.HTLFbXW8ZjFmc/EyCt9wyAzf.KHQATC',	'Représentant légal',	'Facebook',	'legalrpf',	'2025-10-20 18:17:36',	'2025-10-20 18:17:36',	NULL,	NULL,	NULL, NULL),
(24,	'jeanine@gmail.com',	'$2y$13$RH0Ot8IHAM9SyEQ3Fp7N7OX70/yj5kNbbDQffuvarEsnlQ0v7mQLS',	'Jeanine',	'Jeanine',	'jeanine',	'2025-10-20 18:19:22',	'2025-10-20 18:19:22',	NULL,	NULL,	NULL, NULL);

DROP TABLE IF EXISTS `user_notification`;
CREATE TABLE `user_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3F980AC8A76ED395` (`user_id`),
  KEY `IDX_3F980AC8EF1A9D84` (`notification_id`),
  CONSTRAINT `FK_3F980AC8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_3F980AC8EF1A9D84` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2025-10-20 19:54:16 UTC
