SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `user_notification`;
DROP TABLE IF EXISTS `info_form`;
DROP TABLE IF EXISTS `info_form_company_calendar_row`;
DROP TABLE IF EXISTS `info_form_intern_calendar_row`;
DROP TABLE IF EXISTS `info_form_organization_calendar_row`;
DROP TABLE IF EXISTS `info_form_company`;
DROP TABLE IF EXISTS `info_form_intern`;
DROP TABLE IF EXISTS `info_form_organization`;
DROP TABLE IF EXISTS `intern_member`;
DROP TABLE IF EXISTS `organization_member`;
DROP TABLE IF EXISTS `company_member`;
DROP TABLE IF EXISTS `training_session`;
DROP TABLE IF EXISTS `training`;
DROP TABLE IF EXISTS `notification`;
DROP TABLE IF EXISTS `organization`;
DROP TABLE IF EXISTS `company`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `messenger_messages`;
DROP TABLE IF EXISTS `doctrine_migration_versions`;

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
(5,	'0123456789',	'Google',	'0123456789',	NULL,	NULL),
(6,	'0987654321',	'Netflix',	'0987654321',	NULL,	NULL),
(7,	'1122334455',	'Tesla',	'1122334455',	NULL,	NULL),
(8,	'5566778899',	'Spotify',	'5566778899',	NULL,	NULL);

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `role` varchar(255) DEFAULT NULL,
  `notification` tinyint(1) DEFAULT NULL,
  `dark_mode` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `login`, `avatar`, `updated_at`, `created_at`, `role`, `notification`, `dark_mode`) VALUES
(1,	'vpg@gmail.com',	'$2y$13$DCqcmcfTYU3q.t01thUr0OIWJr5D/SvxFF3sjH74OsaKN9/G2rfmK',	'Vincent Séparé',	'Pierre-Gaillard',	'vincentpg',	'https://example.com/avatar.jpg',	'2025-10-20 16:28:03',	'2025-10-20 16:28:03',	NULL,	1,	0),
(2,	'jérémiechabanais@gmail.com',	'$2y$13$3jfSIjbBADnm/bQkzKR6gevIlN1PO39GQssxhkN8rxYTJUECAt0Yq',	'Jérémie',	'Chabanais',	'jeremiec',	NULL,	'2025-10-20 16:28:45',	'2025-10-20 16:28:45',	NULL,	1,	1),
(3,	'maximecouillet@gmail.com',	'$2y$13$7nG41tFtzJZOwo5ebjrFiOds8hhTs3v8v4j4uluLG3oKaVf.vew8G',	'Maxime',	'Couillet',	'maximec',	'https://example.com/maxime-avatar.jpg',	'2025-10-20 16:29:37',	'2025-10-20 16:29:37',	NULL,	0,	0),
(4,	'melissabedhomme@gmail.com',	'$2y$13$4vU32kQWsNhZA5AYUIJdeeAifdZfMuycbApUVHxlL6dkS/io/.68m',	'Mélissa',	'Bedhomme',	'melissab',	'https://example.com/melissa-avatar.jpg',	'2025-10-20 16:30:09',	'2025-10-20 16:30:09',	NULL,	1,	1),
(5,	'arnaurabel@gmail.com',	'$2y$13$zaB7zjMxgpZ7A2drGcELYu7dDWuRViQJr7JWTPYuLEQTG4RXOo.nO',	'Arnaud',	'Rabel',	'arnaudr',	NULL,	'2025-10-20 16:30:32',	'2025-10-20 16:30:32',	NULL,	0,	0),
(6,	'monique@gmail.com',	'$2y$13$R64w.Fn4Q77ouv25eOW6gOw3/6wNqhgIDECIz9a/LveOiPAqxTaxC',	'Monique',	'Monique',	'monique',	'https://example.com/monique-avatar.jpg',	'2025-10-20 16:31:02',	'2025-10-20 16:31:02',	NULL,	1,	0),
(7,	'amine-elkhal@gmail.com',	'$2y$13$qpBm5FQFDyvUZ7ktKYVvwOXeemc/iTvRIDHTYNTCIlnfU2fMW/52q',	'Amine',	'El Khal',	'aminel',	NULL,	'2025-10-20 16:33:36',	'2025-10-20 16:33:36',	NULL,	0,	1),
(8,	'mounirsebti@gmail.com',	'$2y$13$PCo.TyRbXLEejags1J05yeM8CH64153FCrS9loYEKIKEPvP0Zwil2',	'Mounir',	'Sebti',	'mounirs',	'https://example.com/mounir-avatar.jpg',	'2025-10-20 16:34:21',	'2025-10-20 16:34:21',	NULL,	1,	0),
(9,	'margothourdille@gmail.com',	'$2y$13$iqKPXtRXsLpp8mtHXs42be.932l4e4NnCuSvhoHuo1shnbz0Qh4Ru',	'Margot',	'Hourdille',	'margoth',	NULL,	'2025-10-20 16:34:48',	'2025-10-20 16:34:48',	NULL,	1,	1),
(10,	'julengouchault@gmail.com',	'$2y$13$wFxFY3CxdrhMEW5dpUs02OjQOLRh9qda/G/gRK8ly1iE0d2GvWoBu',	'Julen',	'Gouchault',	'juleng',	'https://example.com/julen-avatar.jpg',	'2025-10-20 16:35:24',	'2025-10-20 16:35:24',	NULL,	0,	0),
(11,	'karimmohamed@gmail.com',	'$2y$13$MTaVcvFIaNdaUTBxLdxt3e5H03FUzBl2GnbWvc8B57sH26vpXNyna',	'Karim',	'Imad Mohamed',	'karimi',	NULL,	'2025-10-20 16:36:00',	'2025-10-20 16:36:00',	NULL,	1,	1),
(12,	'sabrinabenoudiba@gmail.com',	'$2y$13$tkUj6jS7tr7lZwml8W6jiuh.UQWnTFxWL0Ca0/mKzXCNLzi.69exe',	'Sabrina',	'Benoudiba',	'sabrinab',	'https://example.com/sabrina-avatar.jpg',	'2025-10-20 16:37:54',	'2025-10-20 16:37:54',	NULL,	0,	0),
(13,	'sariashamashan@gmail.com',	'$2y$13$gJVttro416qztjr3q/ubyu0xwyuDyq9J27ecSlbkUTQJBQK8X.7gW',	'Saria',	'Shamashan',	'sarias',	NULL,	'2025-10-20 16:38:30',	'2025-10-20 16:38:30',	NULL,	1,	0),
(14,	'azizalahcen@gmail.com',	'$2y$13$qaO.3blj/bvgthnzLTb40uo/jLqLo1nSO7GehAqAVQnrLEc7eTLSa',	'Aziza',	'Ait Lahcen',	'azizal',	'https://example.com/aziza-avatar.jpg',	'2025-10-20 16:39:08',	'2025-10-20 16:39:08',	NULL,	1,	1),
(15,	'patiencekoribirama@gmail.com',	'$2y$13$aYM1./nWbarj1Lv8tWLOsOQdNs55yGLQoe50QPZlZxQu3ke896jMa',	'Patience',	'Koribirama',	'patiencek',	NULL,	'2025-10-20 16:39:50',	'2025-10-20 16:39:50',	NULL,	0,	1),
(16,	'charlesproust@gmail.com',	'$2y$13$yBV0p0YErW7WJ0Cn4BShL.3.8Tk7wz.HOMBAHMUjARvOt.tFnuZNu',	'Charles',	'Proust',	'charlesp',	'https://example.com/charles-avatar.jpg',	'2025-10-20 16:40:36',	'2025-10-20 16:40:36',	NULL,	1,	0),
(17,	'monalisacdui@gmail.com',	'$2y$13$txyfUjDvP9lly.N3q2yuMeu8sLQeFDVe6Zfn2eowdzIV9o9OhuQSe',	'Lisa',	'Mona',	'lisam',	NULL,	'2025-10-20 18:07:21',	'2025-10-20 18:07:21',	NULL,	1,	1),
(18,	'tuteurfacebook@gmail.com',	'$2y$13$TiONor0uVxoU0uU4pQs1muV9yi0GMwpUWThsI7D7Rows1m0HqRBzC',	'Tuteur',	'Facebook',	'tuteurf',	NULL,	'2025-10-20 18:08:37',	'2025-10-20 18:08:37',	NULL,	0,	0),
(19,	'tuteurapple@gmail.com',	'$2y$13$Tc4VxQZ.GWyXLHv5VBWfGOgRgk0INUDW3ZXHEK7XBz2mdEolZx4la',	'Tuteur',	'Apple',	'tuteura',	'https://example.com/tuteur-apple.jpg',	'2025-10-20 18:09:25',	'2025-10-20 18:09:25',	NULL,	1,	0),
(20,	'tuteurgoogle@gmail.com',	'$2y$13$SqSdNBxD3bCn6xq1WoSBx.2fP1vVRyC.bvMXF35cXL8qAbmpEEZDC',	'Tuteur',	'Google',	'tuteurg',	NULL,	'2025-10-20 18:09:39',	'2025-10-20 18:09:39',	NULL,	0,	1),
(21,	'legalrpgoogle@gmail.com',	'$2y$13$h/M6Rk5OgSev5ve.i34She2i.JglDFV9xUhsaFAanRODUwR6HhaRq',	'Représentant légal',	'Google',	'legalrpg',	'https://example.com/legal-google.jpg',	'2025-10-20 18:17:00',	'2025-10-20 18:17:00',	NULL,	1,	0),
(22,	'legalrpapple@gmail.com',	'$2y$13$3xlhHOVVSCaCL/4tQsgu3.rWGkKx8XKGrNPBIYeBAWjl21qrG/n6i',	'Représentant légal',	'Apple',	'legalrpa',	NULL,	'2025-10-20 18:17:19',	'2025-10-20 18:17:19',	NULL,	0,	1),
(23,	'legalrpfacebook@gmail.com',	'$2y$13$gIbAQvhWoaDIfTdk07PXY.HTLFbXW8ZjFmc/EyCt9wyAzf.KHQATC',	'Représentant légal',	'Facebook',	'legalrpf',	'https://example.com/legal-fb.jpg',	'2025-10-20 18:17:36',	'2025-10-20 18:17:36',	NULL,	1,	1),
(24,	'jeanine@gmail.com',	'$2y$13$RH0Ot8IHAM9SyEQ3Fp7N7OX70/yj5kNbbDQffuvarEsnlQ0v7mQLS',	'Jeanine',	'Jeanine',	'jeanine',	NULL,	'2025-10-20 18:19:22',	'2025-10-20 18:19:22',	NULL,	1,	0),
(25,	'tuteurnetflix@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Tuteur',	'Netflix',	'tuteurnetflix',	'https://example.com/tuteur-netflix.jpg',	'2025-10-22 10:00:00',	'2025-10-22 10:00:00',	NULL,	1,	0),
(26,	'tuteurtesla@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Tuteur',	'Tesla',	'tuteurtesla',	NULL,	'2025-10-22 10:01:00',	'2025-10-22 10:01:00',	NULL,	0,	1),
(27,	'tuteurspotify@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Tuteur',	'Spotify',	'tuteurspotify',	'https://example.com/tuteur-spotify.jpg',	'2025-10-22 10:02:00',	'2025-10-22 10:02:00',	NULL,	1,	1),
(28,	'legalnetflix@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Représentant légal',	'Netflix',	'legalnetflix',	NULL,	'2025-10-22 10:03:00',	'2025-10-22 10:03:00',	NULL,	0,	0),
(29,	'legaltesla@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Représentant légal',	'Tesla',	'legaltesla',	'https://example.com/legal-tesla.jpg',	'2025-10-22 10:04:00',	'2025-10-22 10:04:00',	NULL,	1,	0),
(30,	'legalspotify@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Représentant légal',	'Spotify',	'legalspotify',	NULL,	'2025-10-22 10:05:00',	'2025-10-22 10:05:00',	NULL,	1,	1);

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
(6,	23,	1,	'Représentant légal',	NULL,	NULL),
(7,	25,	6,	'Tuteur',	NULL,	NULL),
(8,	26,	7,	'Tuteur',	NULL,	NULL),
(9,	27,	8,	'Tuteur',	NULL,	NULL),
(10,	28,	6,	'Représentant légal',	NULL,	NULL),
(11,	29,	7,	'Représentant légal',	NULL,	NULL),
(12,	30,	8,	'Représentant légal',	NULL,	NULL);

CREATE TABLE `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `organization` (`id`, `name`, `updated_at`, `created_at`) VALUES
(1,	'AFPA Saint-Denis',	NULL,	NULL),
(2,	'AFPA Paris',	NULL,	NULL);

CREATE TABLE `organization_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_756149C0A76ED395` (`user_id`),
  KEY `IDX_756149C032C8A3DE` (`organization_id`),
  CONSTRAINT `FK_756149C032C8A3DE` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`),
  CONSTRAINT `FK_756149C0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `organization_member` (`id`, `user_id`, `organization_id`, `role`, `updated_at`, `created_at`) VALUES
(1,	1,	1,	'Formateur',	NULL,	NULL),
(2,	6,	1,	'Directeur',	NULL,	NULL),
(3,	24,	2,	'Formateur',	NULL,	NULL);

CREATE TABLE `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `training` (`id`, `name`, `updated_at`, `created_at`) VALUES
(1,	'CDA',	NULL,	NULL),
(2,	'CDUI',	NULL,	NULL),
(3,	'DWWM',	NULL,	NULL);

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
(2,	2,	'0123456789',	'2025-12-01',	'2025-12-03',	'2025-12-01',	'2025-12-03',	NULL,	NULL),
(3,	3,	'0123456790',	'2025-11-15',	'2025-12-15',	'2025-10-01',	'2026-04-01',	NULL,	NULL);

CREATE TABLE `intern_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `training_session_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_40D2391A76ED395` (`user_id`),
  KEY `IDX_40D2391DB8156B9` (`training_session_id`),
  CONSTRAINT `FK_40D2391A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_40D2391DB8156B9` FOREIGN KEY (`training_session_id`) REFERENCES `training_session` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `intern_member` (`id`, `user_id`, `training_session_id`, `updated_at`, `created_at`) VALUES
(101,	3,	1,	NULL,	NULL),
(102,	17,	2,	NULL,	NULL),
(103,	2,	1,	NULL,	NULL),
(104,	4,	1,	NULL,	NULL),
(105,	5,	1,	NULL,	NULL),
(106,	7,	2,	NULL,	NULL),
(107,	8,	2,	NULL,	NULL),
(108,	9,	3,	NULL,	NULL),
(109,	10,	3,	NULL,	NULL),
(110,	11,	3,	NULL,	NULL),
(111,	12,	1,	NULL,	NULL),
(112,	13,	2,	NULL,	NULL),
(113,	14,	3,	NULL,	NULL),
(114,	15,	1,	NULL,	NULL),
(115,	16,	2,	NULL,	NULL);

CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notification` (`id`, `title`, `content`, `type`, `created_at`, `updated_at`) VALUES
(1,	'Nouveau formulaire de stage disponible',	'Un nouveau formulaire de suivi de stage est maintenant disponible pour votre formation CDA. Veuillez le compléter avant la fin de la semaine.',	'info',	'2025-10-22 08:00:00',	'2025-10-22 08:00:00'),
(2,	'Rappel: Évaluation entreprise',	'N''oubliez pas de faire évaluer votre stage par votre tuteur entreprise avant la date limite du 25 octobre.',	'warning',	'2025-10-22 09:30:00',	'2025-10-22 09:30:00'),
(3,	'Validation de votre dossier',	'Votre dossier de stage a été validé par l''organisme de formation. Félicitations !',	'success',	'2025-10-22 10:15:00',	'2025-10-22 10:15:00'),
(4,	'Problème avec votre formulaire',	'Nous avons détecté un problème avec votre formulaire de stage. Merci de nous contacter.',	'error',	'2025-10-22 11:00:00',	'2025-10-22 11:00:00'),
(5,	'Nouvelle session de formation',	'Une nouvelle session de formation DWWM commence le mois prochain. Inscriptions ouvertes.',	'info',	'2025-10-22 14:00:00',	'2025-10-22 14:00:00'),
(6,	'Entretien planifié',	'Votre entretien de suivi de stage est planifié pour demain à 14h00.',	'info',	'2025-10-22 16:30:00',	'2025-10-22 16:30:00'),
(7,	'Document manquant',	'Il manque des documents dans votre dossier. Veuillez les télécharger rapidement.',	'warning',	'2025-10-21 10:00:00',	'2025-10-21 10:00:00'),
(8,	'Stage validé avec succès',	'Votre stage a été validé avec succès par tous les intervenants. Bravo !',	'success',	'2025-10-21 15:45:00',	'2025-10-21 15:45:00'),
(9,	'Réunion équipe pédagogique',	'Réunion de l''équipe pédagogique prévue vendredi à 9h00 en salle de formation.',	'info',	'2025-10-20 17:00:00',	'2025-10-20 17:00:00'),
(10,	'Mise à jour du système',	'Le système sera mis à jour cette nuit entre 2h et 4h du matin. Service temporairement indisponible.',	'warning',	'2025-10-22 18:00:00',	'2025-10-22 18:00:00');

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

INSERT INTO `user_notification` (`id`, `user_id`, `notification_id`, `is_read`) VALUES
(1, 1, 1, 0),
(2, 1, 3, 1),
(3, 1, 9, 1),
(4, 2, 1, 0),
(5, 2, 2, 0),
(6, 2, 7, 1),
(7, 3, 1, 1),
(8, 3, 2, 0),
(9, 3, 3, 1),
(10, 4, 1, 0),
(11, 4, 4, 0),
(12, 4, 7, 0),
(13, 5, 5, 1),
(14, 6, 9, 1),
(15, 6, 10, 0),
(16, 7, 5, 0),
(17, 7, 6, 1),
(18, 8, 5, 0),
(19, 8, 6, 0),
(20, 8, 8, 1),
(21, 9, 5, 1),
(22, 10, 5, 0),
(23, 10, 8, 1),
(24, 18, 2, 1),
(25, 19, 2, 0),
(26, 20, 2, 1),
(27, 21, 10, 0),
(28, 23, 4, 0);

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
  `tutor_position` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form_company` (`id`, `status`, `created_at`) VALUES
(101, 'Validé', '2025-10-22 10:00:00'),
(102, 'Validé', '2025-10-22 10:01:00'),
(103, 'Validé', '2025-10-22 10:02:00'),
(104, 'Validé', '2025-10-22 10:03:00'),
(105, 'Validé', '2025-10-22 10:04:00'),
(106, 'Validé', '2025-10-22 10:05:00'),
(107, 'Pas validé', '2025-10-22 10:06:00'),
(108, 'Validé', '2025-10-22 10:07:00'),
(109, 'Validé', '2025-10-22 11:00:00'),
(110, 'En cours de validation', '2025-10-22 11:01:00'),
(111, 'Validé', '2025-10-22 11:02:00'),
(112, 'En cours de validation', '2025-10-22 11:03:00'),
(113, 'En cours de validation', '2025-10-22 11:04:00'),
(114, 'Pas validé', '2025-10-22 11:05:00'),
(115, 'Validé', '2025-10-22 11:06:00'),
(116, 'En cours de validation', '2025-10-22 11:07:00'),
(117, 'Validé', '2025-10-22 11:08:00'),
(118, 'Validé', '2025-10-22 11:09:00');

CREATE TABLE `info_form_intern` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intern_signature` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form_intern` (`id`, `status`, `created_at`) VALUES
(101, 'wesh', '2025-10-22 10:00:00'),
(102, 'wesh', '2025-10-22 10:01:00'),
(103, 'En cours', '2025-10-22 10:02:00'),
(104, 'pas cool', '2025-10-22 10:03:00'),
(105, 'wesh', '2025-10-22 10:04:00'),
(106, 'En cours', '2025-10-22 10:05:00'),
(107, 'pas cool', '2025-10-22 10:06:00'),
(108, 'wesh', '2025-10-22 10:07:00'),
(109, 'wesh', '2025-10-22 11:00:00'),
(110, 'En cours', '2025-10-22 11:01:00'),
(111, 'En cours', '2025-10-22 11:02:00'),
(112, 'wesh', '2025-10-22 11:03:00'),
(113, 'pas cool', '2025-10-22 11:04:00'),
(114, 'pas cool', '2025-10-22 11:05:00'),
(115, 'wesh', '2025-10-22 11:06:00'),
(116, 'En cours', '2025-10-22 11:07:00'),
(117, 'En cours', '2025-10-22 11:08:00'),
(118, 'wesh', '2025-10-22 11:09:00');

CREATE TABLE `info_form_organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_signature` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form_organization` (`id`, `status`, `created_at`) VALUES
(101, 'guénial', '2025-10-22 10:00:00'),
(102, 'guénial', '2025-10-22 10:01:00'),
(103, 'guénial', '2025-10-22 10:02:00'),
(104, 'pas le temps', '2025-10-22 10:03:00'),
(105, 'pas le temps', '2025-10-22 10:04:00'),
(106, 'pas le temps', '2025-10-22 10:05:00'),
(107, 'a chier', '2025-10-22 10:06:00'),
(108, 'guénial', '2025-10-22 10:07:00'),
(109, 'guénial', '2025-10-22 11:00:00'),
(110, 'guénial', '2025-10-22 11:01:00'),
(111, 'pas le temps', '2025-10-22 11:02:00'),
(112, 'pas le temps', '2025-10-22 11:03:00'),
(113, 'pas le temps', '2025-10-22 11:04:00'),
(114, 'a chier', '2025-10-22 11:05:00'),
(115, 'guénial', '2025-10-22 11:06:00'),
(116, 'guénial', '2025-10-22 11:07:00'),
(117, 'pas le temps', '2025-10-22 11:08:00'),
(118, 'guénial', '2025-10-22 11:09:00');

CREATE TABLE `info_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intern_member_id` int(11) DEFAULT NULL,
  `info_form_intern_id` int(11) DEFAULT NULL,
  `info_form_organization_id` int(11) DEFAULT NULL,
  `info_form_company_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `training_session_id` int(11) DEFAULT NULL,
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
  KEY `IDX_BE32FC1DB8156B9` (`training_session_id`),
  CONSTRAINT `FK_BE32FC132C8A3DE` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`),
  CONSTRAINT `FK_BE32FC156817849` FOREIGN KEY (`intern_member_id`) REFERENCES `intern_member` (`id`),
  CONSTRAINT `FK_BE32FC17470E03B` FOREIGN KEY (`info_form_company_id`) REFERENCES `info_form_company` (`id`),
  CONSTRAINT `FK_BE32FC1979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_BE32FC1DAAC2B3C` FOREIGN KEY (`info_form_intern_id`) REFERENCES `info_form_intern` (`id`),
  CONSTRAINT `FK_BE32FC1DBB3C91D` FOREIGN KEY (`info_form_organization_id`) REFERENCES `info_form_organization` (`id`),
  CONSTRAINT `FK_BE32FC1DB8156B9` FOREIGN KEY (`training_session_id`) REFERENCES `training_session` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `info_form` (`id`, `intern_member_id`, `info_form_intern_id`, `info_form_organization_id`, `info_form_company_id`, `company_id`, `organization_id`, `training_session_id`, `status`, `updated_at`, `created_at`) VALUES
(101, 101, 101, 101, 101, 1,  1,  1,  'fully_completed',        '2025-10-22 10:00:00', '2025-10-22 09:00:00'),    -- Maxime - 100% complet
(102, 103, 102, 102, 102, 2,  1,  1,  'fully_completed',        '2025-10-22 10:01:00', '2025-10-22 09:01:00'),    -- Jérémie - 100% complet
(103, 104, 103, 103, 103, 3,  1,  1,  'completed_organization', '2025-10-22 10:02:00', '2025-10-22 09:02:00'),    -- Mélissa - Validé organisation seulement
(104, 105, 104, 104, 104, 4,  1,  1,  NULL,                      '2025-10-22 10:03:00', '2025-10-22 09:03:00'),    -- Arnaud - Pas de statut
(105, 111, 105, 105, 105, 5,  1,  1,  'completed_intern',        '2025-10-22 10:04:00', '2025-10-22 09:04:00'),    -- Sabrina - Validé stagiaire seulement
(106, 114, 106, 106, 106, 1,  1,  1,  'completed_company',       '2025-10-22 10:05:00', '2025-10-22 09:05:00'),    -- Patience - Validé entreprise seulement
(107, 102, 107, 107, 107, 6,  1,  1,  'rejected',               '2025-10-22 10:06:00', '2025-10-22 09:06:00'),    -- Autre stagiaire - Rejeté
(108, 101, 108, 108, 108, 7,  1,  1,  'fully_completed',        '2025-10-22 10:07:00', '2025-10-22 09:07:00'),    -- Encore un complet

(9,   2,  NULL, NULL, NULL, 5,   1,  2,  NULL,                      '2025-10-22 10:08:00', '2025-10-22 09:08:00'),    -- Lisa - Pas encore commencé
(10,  6,  9,     9,   9,   2,   1,  2,  'completed_intern_validation',   '2025-10-22 10:09:00', '2025-10-22 09:09:00'),    -- Amine - Validé stagiaire
(11,  7, 10,    10,  10,   3,   1,  2,  'fully_completed',        '2025-10-22 10:10:00', '2025-10-22 09:10:00'),    -- Mounir - 100% complet
(12, 12, NULL, NULL, NULL, 4,   1,  2,  'completed_company_validation', '2025-10-22 10:11:00', '2025-10-22 09:11:00'),    -- Saria - Validé entreprise
(13, 15, NULL, NULL, NULL, 8,   1,  2,  'rejected',               '2025-10-22 10:12:00', '2025-10-22 09:12:00'),    -- Charles - Rejeté

(109, 106, 109, 109, 109, 8,  2,  2,  'fully_completed',        '2025-10-22 11:00:00', '2025-10-22 10:00:00'),    -- Nabil - 100% complet
(110, 107, 110, 110, 110, 9,  2,  2,  'completed_organization', '2025-10-22 11:01:00', '2025-10-22 10:01:00'),    -- Yasmine - Validé organisation seulement
(111, 108, 111, 111, 111, 10, 2,  2,  'completed_company',      '2025-10-22 11:02:00', '2025-10-22 10:02:00'),    -- Omar - Validé entreprise seulement
(112, 109, 112, 112, 112, 2,  2,  2,  'completed_intern',       '2025-10-22 11:03:00', '2025-10-22 10:03:00'),    -- Fatima - Validé stagiaire seulement
(113, 112, 113, 113, 113, 3,  2,  2,  NULL,                     '2025-10-22 11:04:00', '2025-10-22 10:04:00'),    -- Khadija - Pas de statut
(114, 113, 114, 114, 114, 4,  2,  2,  'rejected',               '2025-10-22 11:05:00', '2025-10-22 10:05:00'),    -- Salim - Rejeté
(115, 115, 115, 115, 115, 5,  2,  2,  'fully_completed',        '2025-10-22 11:06:00', '2025-10-22 10:06:00'),    -- Layla - 100% complet
(116, 116, 116, 116, 116, 6,  2,  2,  'completed_organization', '2025-10-22 11:07:00', '2025-10-22 10:07:00'),    -- Adrien - Validé organisation seulement
(117, 117, 117, 117, 117, 7,  2,  2,  'completed_company',      '2025-10-22 11:08:00', '2025-10-22 10:08:00'),    -- Océane - Validé entreprise seulement
(118, 118, 118, 118, 118, 8,  2,  2,  'fully_completed',        '2025-10-22 11:09:00', '2025-10-22 10:09:00');   -- David - 100% complet


SET foreign_key_checks = 1;