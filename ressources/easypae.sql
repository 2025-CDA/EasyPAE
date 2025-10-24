-- Adminer 5.3.0 MariaDB 12.0.2-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

INSERT INTO `company` (`id`, `siret`, `name`, `phone_number`, `updated_at`, `created_at`, `address`) VALUES
(1,	'0123456789',	'Meta',	'0123456789',	NULL,	NULL,	NULL),
(2,	'0123456789',	'Apple',	'0123456789',	NULL,	NULL,	NULL),
(3,	'0123456789',	'Microsoft',	'0123456789',	NULL,	NULL,	NULL),
(4,	'0123456789',	'Amazon',	'0123456789',	NULL,	NULL,	NULL),
(5,	'0123456789',	'Google',	'0123456789',	NULL,	NULL,	NULL),
(6,	'0987654321',	'Netflix',	'0987654321',	NULL,	NULL,	NULL),
(7,	'1122334455',	'Tesla',	'1122334455',	NULL,	NULL,	NULL),
(8,	'5566778899',	'Spotify',	'5566778899',	NULL,	NULL,	NULL);

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

INSERT INTO `info_form` (`id`, `intern_member_id`, `info_form_intern_id`, `info_form_organization_id`, `info_form_company_id`, `company_id`, `organization_id`, `training_session_id`, `status`, `updated_at`, `created_at`) VALUES
(9,	2,	NULL,	NULL,	NULL,	5,	1,	2,	NULL,	'2025-10-22 10:08:00',	'2025-10-22 09:08:00'),
(10,	6,	9,	9,	9,	2,	1,	2,	'completed_intern_validation',	'2025-10-22 10:09:00',	'2025-10-22 09:09:00'),
(11,	7,	10,	10,	10,	3,	1,	2,	'fully_completed',	'2025-10-22 10:10:00',	'2025-10-22 09:10:00'),
(12,	12,	NULL,	NULL,	NULL,	4,	1,	2,	'completed_company_validation',	'2025-10-22 10:11:00',	'2025-10-22 09:11:00'),
(13,	15,	NULL,	NULL,	NULL,	8,	1,	2,	'rejected',	'2025-10-22 10:12:00',	'2025-10-22 09:12:00'),
(101,	101,	101,	101,	101,	1,	1,	1,	'fully_completed',	'2025-10-22 10:00:00',	'2025-10-22 09:00:00'),
(102,	103,	102,	102,	102,	2,	1,	1,	'fully_completed',	'2025-10-22 10:01:00',	'2025-10-22 09:01:00'),
(103,	104,	103,	103,	103,	3,	1,	1,	'completed_organization',	'2025-10-22 10:02:00',	'2025-10-22 09:02:00'),
(104,	105,	104,	104,	104,	4,	1,	1,	NULL,	'2025-10-22 10:03:00',	'2025-10-22 09:03:00'),
(105,	111,	105,	105,	105,	5,	1,	1,	'completed_intern',	'2025-10-22 10:04:00',	'2025-10-22 09:04:00'),
(106,	114,	106,	106,	106,	1,	1,	1,	'completed_company',	'2025-10-22 10:05:00',	'2025-10-22 09:05:00'),
(107,	102,	107,	107,	107,	6,	1,	1,	'rejected',	'2025-10-22 10:06:00',	'2025-10-22 09:06:00'),
(108,	101,	108,	108,	108,	7,	1,	1,	'fully_completed',	'2025-10-22 10:07:00',	'2025-10-22 09:07:00'),
(109,	106,	109,	109,	109,	8,	2,	2,	'fully_completed',	'2025-10-22 11:00:00',	'2025-10-22 10:00:00'),
(110,	107,	110,	110,	110,	9,	2,	2,	'completed_organization',	'2025-10-22 11:01:00',	'2025-10-22 10:01:00'),
(111,	108,	111,	111,	111,	10,	2,	2,	'completed_company',	'2025-10-22 11:02:00',	'2025-10-22 10:02:00'),
(112,	109,	112,	112,	112,	2,	2,	2,	'completed_intern',	'2025-10-22 11:03:00',	'2025-10-22 10:03:00'),
(113,	112,	113,	113,	113,	3,	2,	2,	NULL,	'2025-10-22 11:04:00',	'2025-10-22 10:04:00'),
(114,	113,	114,	114,	114,	4,	2,	2,	'rejected',	'2025-10-22 11:05:00',	'2025-10-22 10:05:00'),
(115,	115,	115,	115,	115,	5,	2,	2,	'fully_completed',	'2025-10-22 11:06:00',	'2025-10-22 10:06:00'),
(116,	116,	116,	116,	116,	6,	2,	2,	'completed_organization',	'2025-10-22 11:07:00',	'2025-10-22 10:07:00'),
(117,	117,	117,	117,	117,	7,	2,	2,	'completed_company',	'2025-10-22 11:08:00',	'2025-10-22 10:08:00'),
(118,	118,	118,	118,	118,	8,	2,	2,	'fully_completed',	'2025-10-22 11:09:00',	'2025-10-22 10:09:00');

INSERT INTO `info_form_company` (`id`, `fax`, `activity`, `activity_description`, `stamp`, `legal_representative_gender`, `legal_representative_last_name`, `legal_representative_first_name`, `legal_representative_signature`, `legal_representative_email`, `interview_start_date_time`, `interview_end_date_time`, `agree_terms`, `work_location`, `tutor_gender`, `tutor_first_name`, `tutor_last_name`, `tutor_email`, `tutor_phone_number`, `updated_at`, `created_at`, `status`) VALUES
(101,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:00:00',	'Validé'),
(102,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:01:00',	'Validé'),
(103,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:02:00',	'Validé'),
(104,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:03:00',	'Validé'),
(105,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:04:00',	'Validé'),
(106,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:05:00',	'Validé'),
(107,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:06:00',	'Pas validé'),
(108,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:07:00',	'Validé'),
(109,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:00:00',	'Validé'),
(110,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:01:00',	'En cours de validation'),
(111,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:02:00',	'Validé'),
(112,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:03:00',	'En cours de validation'),
(113,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:04:00',	'En cours de validation'),
(114,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:05:00',	'Pas validé'),
(115,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:06:00',	'Validé'),
(116,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:07:00',	'En cours de validation'),
(117,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:08:00',	'Validé'),
(118,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:09:00',	'Validé');


INSERT INTO `info_form_intern` (`id`, `info_form_intern_company_id`, `date_start`, `date_end`, `gender`, `updated_at`, `created_at`, `status`) VALUES
(101,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:00:00',	'wesh'),
(102,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:01:00',	'wesh'),
(103,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:02:00',	'En cours'),
(104,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:03:00',	'pas cool'),
(105,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:04:00',	'wesh'),
(106,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:05:00',	'En cours'),
(107,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:06:00',	'pas cool'),
(108,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 10:07:00',	'wesh'),
(109,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:00:00',	'wesh'),
(110,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:01:00',	'En cours'),
(111,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:02:00',	'En cours'),
(112,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:03:00',	'wesh'),
(113,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:04:00',	'pas cool'),
(114,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:05:00',	'pas cool'),
(115,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:06:00',	'wesh'),
(116,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:07:00',	'En cours'),
(117,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:08:00',	'En cours'),
(118,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-10-22 11:09:00',	'wesh');


INSERT INTO `info_form_organization` (`id`, `validation_date`, `signature`, `updated_at`, `created_at`, `status`) VALUES
(101,	NULL,	NULL,	NULL,	'2025-10-22 10:00:00',	'guénial'),
(102,	NULL,	NULL,	NULL,	'2025-10-22 10:01:00',	'guénial'),
(103,	NULL,	NULL,	NULL,	'2025-10-22 10:02:00',	'guénial'),
(104,	NULL,	NULL,	NULL,	'2025-10-22 10:03:00',	'pas le temps'),
(105,	NULL,	NULL,	NULL,	'2025-10-22 10:04:00',	'pas le temps'),
(106,	NULL,	NULL,	NULL,	'2025-10-22 10:05:00',	'pas le temps'),
(107,	NULL,	NULL,	NULL,	'2025-10-22 10:06:00',	'a chier'),
(108,	NULL,	NULL,	NULL,	'2025-10-22 10:07:00',	'guénial'),
(109,	NULL,	NULL,	NULL,	'2025-10-22 11:00:00',	'guénial'),
(110,	NULL,	NULL,	NULL,	'2025-10-22 11:01:00',	'guénial'),
(111,	NULL,	NULL,	NULL,	'2025-10-22 11:02:00',	'pas le temps'),
(112,	NULL,	NULL,	NULL,	'2025-10-22 11:03:00',	'pas le temps'),
(113,	NULL,	NULL,	NULL,	'2025-10-22 11:04:00',	'pas le temps'),
(114,	NULL,	NULL,	NULL,	'2025-10-22 11:05:00',	'a chier'),
(115,	NULL,	NULL,	NULL,	'2025-10-22 11:06:00',	'guénial'),
(116,	NULL,	NULL,	NULL,	'2025-10-22 11:07:00',	'guénial'),
(117,	NULL,	NULL,	NULL,	'2025-10-22 11:08:00',	'pas le temps'),
(118,	NULL,	NULL,	NULL,	'2025-10-22 11:09:00',	'guénial');

INSERT INTO `intern_member` (`id`, `user_id`, `updated_at`, `created_at`) VALUES
(101,	3,	NULL,	NULL),
(102,	17,	NULL,	NULL),
(103,	2,	NULL,	NULL),
(104,	4,	NULL,	NULL),
(105,	5,	NULL,	NULL),
(106,	7,	NULL,	NULL),
(107,	8,	NULL,	NULL),
(108,	9,	NULL,	NULL),
(109,	10,	NULL,	NULL),
(110,	11,	NULL,	NULL),
(111,	12,	NULL,	NULL),
(112,	13,	NULL,	NULL),
(113,	14,	NULL,	NULL),
(114,	15,	NULL,	NULL),
(115,	16,	NULL,	NULL);

INSERT INTO `notification` (`id`, `title`, `content`, `updated_at`, `created_at`) VALUES
(1,	'Nouveau formulaire de stage disponible',	'Un nouveau formulaire de suivi de stage est maintenant disponible pour votre formation CDA. Veuillez le compléter avant la fin de la semaine.',	'2025-10-22 08:00:00',	'2025-10-22 08:00:00'),
(2,	'Rappel: Évaluation entreprise',	'N\'oubliez pas de faire évaluer votre stage par votre tuteur entreprise avant la date limite du 25 octobre.',	'2025-10-22 09:30:00',	'2025-10-22 09:30:00'),
(3,	'Validation de votre dossier',	'Votre dossier de stage a été validé par l\'organisme de formation. Félicitations !',	'2025-10-22 10:15:00',	'2025-10-22 10:15:00'),
(4,	'Problème avec votre formulaire',	'Nous avons détecté un problème avec votre formulaire de stage. Merci de nous contacter.',	'2025-10-22 11:00:00',	'2025-10-22 11:00:00'),
(5,	'Nouvelle session de formation',	'Une nouvelle session de formation DWWM commence le mois prochain. Inscriptions ouvertes.',	'2025-10-22 14:00:00',	'2025-10-22 14:00:00'),
(6,	'Entretien planifié',	'Votre entretien de suivi de stage est planifié pour demain à 14h00.',	'2025-10-22 16:30:00',	'2025-10-22 16:30:00'),
(7,	'Document manquant',	'Il manque des documents dans votre dossier. Veuillez les télécharger rapidement.',	'2025-10-21 10:00:00',	'2025-10-21 10:00:00'),
(8,	'Stage validé avec succès',	'Votre stage a été validé avec succès par tous les intervenants. Bravo !',	'2025-10-21 15:45:00',	'2025-10-21 15:45:00'),
(9,	'Réunion équipe pédagogique',	'Réunion de l\'équipe pédagogique prévue vendredi à 9h00 en salle de formation.',	'2025-10-20 17:00:00',	'2025-10-20 17:00:00'),
(10,	'Mise à jour du système',	'Le système sera mis à jour cette nuit entre 2h et 4h du matin. Service temporairement indisponible.',	'2025-10-22 18:00:00',	'2025-10-22 18:00:00');

INSERT INTO `organization` (`id`, `siret`, `name`, `updated_at`, `created_at`) VALUES
(1,	NULL,	'AFPA Saint-Denis',	NULL,	NULL),
(2,	NULL,	'AFPA Paris',	NULL,	NULL);

INSERT INTO `organization_member` (`id`, `user_id`, `organization_id`, `role`, `updated_at`, `created_at`) VALUES
(1,	1,	1,	'Formateur',	NULL,	NULL),
(2,	6,	1,	'Directeur',	NULL,	NULL),
(3,	2,	1,	'Formateur',	NULL,	NULL);

INSERT INTO `organization_member_training_session` (`organization_member_id`, `training_session_id`) VALUES
(1,	2),
(3,	1);

INSERT INTO `training` (`id`, `name`, `updated_at`, `created_at`) VALUES
(1,	'CDA',	NULL,	NULL),
(2,	'CDUI',	NULL,	NULL),
(3,	'DWWM',	NULL,	NULL);

INSERT INTO `training_session` (`id`, `training_id`, `offer_number`, `internship_period_start`, `internship_period_end`, `training_period_start`, `training_period_end`, `updated_at`, `created_at`, `has_ended`) VALUES
(1,	1,	'0123456789',	'2025-12-01',	'2025-12-03',	'2025-12-01',	'2025-12-03',	NULL,	NULL,	NULL),
(2,	2,	'0123456789',	'2025-12-01',	'2025-12-03',	'2025-12-01',	'2025-12-03',	NULL,	NULL,	NULL),
(3,	3,	'0123456790',	'2025-11-15',	'2025-12-15',	'2025-10-01',	'2026-04-01',	NULL,	NULL,	NULL);


INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `login`, `updated_at`, `created_at`, `role`, `notification`, `dark_mode`, `avatar`, `phone`, `address`, `birthday`) VALUES
(1,	'vpg@gmail.com',	'$2y$13$DCqcmcfTYU3q.t01thUr0OIWJr5D/SvxFF3sjH74OsaKN9/G2rfmK',	'Vincent Séparé',	'Pierre-Gaillard',	'vincentpg',	'2025-10-20 16:28:03',	'2025-10-20 16:28:03',	NULL,	1,	0,	'https://example.com/avatar.jpg',	NULL,	NULL,	NULL),
(2,	'jérémiechabanais@gmail.com',	'$2y$13$3jfSIjbBADnm/bQkzKR6gevIlN1PO39GQssxhkN8rxYTJUECAt0Yq',	'Jérémie',	'Chabanais',	'jeremiec',	'2025-10-20 16:28:45',	'2025-10-20 16:28:45',	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL),
(3,	'maximecouillet@gmail.com',	'$2y$13$7nG41tFtzJZOwo5ebjrFiOds8hhTs3v8v4j4uluLG3oKaVf.vew8G',	'Maxime',	'Couillet',	'maximec',	'2025-10-20 16:29:37',	'2025-10-20 16:29:37',	NULL,	0,	0,	'https://example.com/maxime-avatar.jpg',	NULL,	NULL,	NULL),
(4,	'melissabedhomme@gmail.com',	'$2y$13$4vU32kQWsNhZA5AYUIJdeeAifdZfMuycbApUVHxlL6dkS/io/.68m',	'Mélissa',	'Bedhomme',	'melissab',	'2025-10-20 16:30:09',	'2025-10-20 16:30:09',	NULL,	1,	1,	'https://example.com/melissa-avatar.jpg',	NULL,	NULL,	NULL),
(5,	'arnaurabel@gmail.com',	'$2y$13$zaB7zjMxgpZ7A2drGcELYu7dDWuRViQJr7JWTPYuLEQTG4RXOo.nO',	'Arnaud',	'Rabel',	'arnaudr',	'2025-10-20 16:30:32',	'2025-10-20 16:30:32',	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL),
(6,	'monique@gmail.com',	'$2y$13$R64w.Fn4Q77ouv25eOW6gOw3/6wNqhgIDECIz9a/LveOiPAqxTaxC',	'Monique',	'Monique',	'monique',	'2025-10-20 16:31:02',	'2025-10-20 16:31:02',	NULL,	1,	0,	'https://example.com/monique-avatar.jpg',	NULL,	NULL,	NULL),
(7,	'amine-elkhal@gmail.com',	'$2y$13$qpBm5FQFDyvUZ7ktKYVvwOXeemc/iTvRIDHTYNTCIlnfU2fMW/52q',	'Amine',	'El Khal',	'aminel',	'2025-10-20 16:33:36',	'2025-10-20 16:33:36',	NULL,	0,	1,	NULL,	NULL,	NULL,	NULL),
(8,	'mounirsebti@gmail.com',	'$2y$13$PCo.TyRbXLEejags1J05yeM8CH64153FCrS9loYEKIKEPvP0Zwil2',	'Mounir',	'Sebti',	'mounirs',	'2025-10-20 16:34:21',	'2025-10-20 16:34:21',	NULL,	1,	0,	'https://example.com/mounir-avatar.jpg',	NULL,	NULL,	NULL),
(9,	'margothourdille@gmail.com',	'$2y$13$iqKPXtRXsLpp8mtHXs42be.932l4e4NnCuSvhoHuo1shnbz0Qh4Ru',	'Margot',	'Hourdille',	'margoth',	'2025-10-20 16:34:48',	'2025-10-20 16:34:48',	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL),
(10,	'julengouchault@gmail.com',	'$2y$13$wFxFY3CxdrhMEW5dpUs02OjQOLRh9qda/G/gRK8ly1iE0d2GvWoBu',	'Julen',	'Gouchault',	'juleng',	'2025-10-20 16:35:24',	'2025-10-20 16:35:24',	NULL,	0,	0,	'https://example.com/julen-avatar.jpg',	NULL,	NULL,	NULL),
(11,	'karimmohamed@gmail.com',	'$2y$13$MTaVcvFIaNdaUTBxLdxt3e5H03FUzBl2GnbWvc8B57sH26vpXNyna',	'Karim',	'Imad Mohamed',	'karimi',	'2025-10-20 16:36:00',	'2025-10-20 16:36:00',	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL),
(12,	'sabrinabenoudiba@gmail.com',	'$2y$13$tkUj6jS7tr7lZwml8W6jiuh.UQWnTFxWL0Ca0/mKzXCNLzi.69exe',	'Sabrina',	'Benoudiba',	'sabrinab',	'2025-10-20 16:37:54',	'2025-10-20 16:37:54',	NULL,	0,	0,	'https://example.com/sabrina-avatar.jpg',	NULL,	NULL,	NULL),
(13,	'sariashamashan@gmail.com',	'$2y$13$gJVttro416qztjr3q/ubyu0xwyuDyq9J27ecSlbkUTQJBQK8X.7gW',	'Saria',	'Shamashan',	'sarias',	'2025-10-20 16:38:30',	'2025-10-20 16:38:30',	NULL,	1,	0,	NULL,	NULL,	NULL,	NULL),
(14,	'azizalahcen@gmail.com',	'$2y$13$qaO.3blj/bvgthnzLTb40uo/jLqLo1nSO7GehAqAVQnrLEc7eTLSa',	'Aziza',	'Ait Lahcen',	'azizal',	'2025-10-20 16:39:08',	'2025-10-20 16:39:08',	NULL,	1,	1,	'https://example.com/aziza-avatar.jpg',	NULL,	NULL,	NULL),
(15,	'patiencekoribirama@gmail.com',	'$2y$13$aYM1./nWbarj1Lv8tWLOsOQdNs55yGLQoe50QPZlZxQu3ke896jMa',	'Patience',	'Koribirama',	'patiencek',	'2025-10-20 16:39:50',	'2025-10-20 16:39:50',	NULL,	0,	1,	NULL,	NULL,	NULL,	NULL),
(16,	'charlesproust@gmail.com',	'$2y$13$yBV0p0YErW7WJ0Cn4BShL.3.8Tk7wz.HOMBAHMUjARvOt.tFnuZNu',	'Charles',	'Proust',	'charlesp',	'2025-10-20 16:40:36',	'2025-10-20 16:40:36',	NULL,	1,	0,	'https://example.com/charles-avatar.jpg',	NULL,	NULL,	NULL),
(17,	'monalisacdui@gmail.com',	'$2y$13$txyfUjDvP9lly.N3q2yuMeu8sLQeFDVe6Zfn2eowdzIV9o9OhuQSe',	'Lisa',	'Mona',	'lisam',	'2025-10-20 18:07:21',	'2025-10-20 18:07:21',	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL),
(18,	'tuteurfacebook@gmail.com',	'$2y$13$TiONor0uVxoU0uU4pQs1muV9yi0GMwpUWThsI7D7Rows1m0HqRBzC',	'Tuteur',	'Facebook',	'tuteurf',	'2025-10-20 18:08:37',	'2025-10-20 18:08:37',	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL),
(19,	'tuteurapple@gmail.com',	'$2y$13$Tc4VxQZ.GWyXLHv5VBWfGOgRgk0INUDW3ZXHEK7XBz2mdEolZx4la',	'Tuteur',	'Apple',	'tuteura',	'2025-10-20 18:09:25',	'2025-10-20 18:09:25',	NULL,	1,	0,	'https://example.com/tuteur-apple.jpg',	NULL,	NULL,	NULL),
(20,	'tuteurgoogle@gmail.com',	'$2y$13$SqSdNBxD3bCn6xq1WoSBx.2fP1vVRyC.bvMXF35cXL8qAbmpEEZDC',	'Tuteur',	'Google',	'tuteurg',	'2025-10-20 18:09:39',	'2025-10-20 18:09:39',	NULL,	0,	1,	NULL,	NULL,	NULL,	NULL),
(21,	'legalrpgoogle@gmail.com',	'$2y$13$h/M6Rk5OgSev5ve.i34She2i.JglDFV9xUhsaFAanRODUwR6HhaRq',	'Représentant légal',	'Google',	'legalrpg',	'2025-10-20 18:17:00',	'2025-10-20 18:17:00',	NULL,	1,	0,	'https://example.com/legal-google.jpg',	NULL,	NULL,	NULL),
(22,	'legalrpapple@gmail.com',	'$2y$13$3xlhHOVVSCaCL/4tQsgu3.rWGkKx8XKGrNPBIYeBAWjl21qrG/n6i',	'Représentant légal',	'Apple',	'legalrpa',	'2025-10-20 18:17:19',	'2025-10-20 18:17:19',	NULL,	0,	1,	NULL,	NULL,	NULL,	NULL),
(23,	'legalrpfacebook@gmail.com',	'$2y$13$gIbAQvhWoaDIfTdk07PXY.HTLFbXW8ZjFmc/EyCt9wyAzf.KHQATC',	'Représentant légal',	'Facebook',	'legalrpf',	'2025-10-20 18:17:36',	'2025-10-20 18:17:36',	NULL,	1,	1,	'https://example.com/legal-fb.jpg',	NULL,	NULL,	NULL),
(24,	'jeanine@gmail.com',	'$2y$13$RH0Ot8IHAM9SyEQ3Fp7N7OX70/yj5kNbbDQffuvarEsnlQ0v7mQLS',	'Jeanine',	'Jeanine',	'jeanine',	'2025-10-20 18:19:22',	'2025-10-20 18:19:22',	NULL,	1,	0,	NULL,	NULL,	NULL,	NULL),
(25,	'tuteurnetflix@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Tuteur',	'Netflix',	'tuteurnetflix',	'2025-10-22 10:00:00',	'2025-10-22 10:00:00',	NULL,	1,	0,	'https://example.com/tuteur-netflix.jpg',	NULL,	NULL,	NULL),
(26,	'tuteurtesla@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Tuteur',	'Tesla',	'tuteurtesla',	'2025-10-22 10:01:00',	'2025-10-22 10:01:00',	NULL,	0,	1,	NULL,	NULL,	NULL,	NULL),
(27,	'tuteurspotify@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Tuteur',	'Spotify',	'tuteurspotify',	'2025-10-22 10:02:00',	'2025-10-22 10:02:00',	NULL,	1,	1,	'https://example.com/tuteur-spotify.jpg',	NULL,	NULL,	NULL),
(28,	'legalnetflix@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Représentant légal',	'Netflix',	'legalnetflix',	'2025-10-22 10:03:00',	'2025-10-22 10:03:00',	NULL,	0,	0,	NULL,	NULL,	NULL,	NULL),
(29,	'legaltesla@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Représentant légal',	'Tesla',	'legaltesla',	'2025-10-22 10:04:00',	'2025-10-22 10:04:00',	NULL,	1,	0,	'https://example.com/legal-tesla.jpg',	NULL,	NULL,	NULL),
(30,	'legalspotify@gmail.com',	'$2y$13$abcd1234567890abcdef',	'Représentant légal',	'Spotify',	'legalspotify',	'2025-10-22 10:05:00',	'2025-10-22 10:05:00',	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL);

INSERT INTO `user_notification` (`id`, `user_id`, `notification_id`, `is_read`, `is_signed`, `updated_at`, `created_at`) VALUES
(1,	1,	1,	0,	NULL,	NULL,	NULL),
(2,	1,	3,	1,	NULL,	NULL,	NULL),
(3,	1,	9,	1,	NULL,	NULL,	NULL),
(4,	2,	1,	0,	NULL,	NULL,	NULL),
(5,	2,	2,	0,	NULL,	NULL,	NULL),
(6,	2,	7,	1,	NULL,	NULL,	NULL),
(7,	3,	1,	1,	NULL,	NULL,	NULL),
(8,	3,	2,	0,	NULL,	NULL,	NULL),
(9,	3,	3,	1,	NULL,	NULL,	NULL),
(10,	4,	1,	0,	NULL,	NULL,	NULL),
(11,	4,	4,	0,	NULL,	NULL,	NULL),
(12,	4,	7,	0,	NULL,	NULL,	NULL),
(13,	5,	5,	1,	NULL,	NULL,	NULL),
(14,	6,	9,	1,	NULL,	NULL,	NULL),
(15,	6,	10,	0,	NULL,	NULL,	NULL),
(16,	7,	5,	0,	NULL,	NULL,	NULL),
(17,	7,	6,	1,	NULL,	NULL,	NULL),
(18,	8,	5,	0,	NULL,	NULL,	NULL),
(19,	8,	6,	0,	NULL,	NULL,	NULL),
(20,	8,	8,	1,	NULL,	NULL,	NULL),
(21,	9,	5,	1,	NULL,	NULL,	NULL),
(22,	10,	5,	0,	NULL,	NULL,	NULL),
(23,	10,	8,	1,	NULL,	NULL,	NULL),
(24,	18,	2,	1,	NULL,	NULL,	NULL),
(25,	19,	2,	0,	NULL,	NULL,	NULL),
(26,	20,	2,	1,	NULL,	NULL,	NULL),
(27,	21,	10,	0,	NULL,	NULL,	NULL),
(28,	23,	4,	0,	NULL,	NULL,	NULL);

-- 2025-10-24 08:46:33 UTC
