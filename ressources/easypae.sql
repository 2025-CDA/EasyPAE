SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;


INSERT INTO `training` (`id`, `name`, `category`, `updated_at`, `created_at`) VALUES
(1,	'CDA', 'informatique',	'2025-10-22 09:00:00',	'2025-01-10 10:00:00'),
(2,	'CDUI', 'design informatique',	'2025-10-22 09:01:00',	'2025-01-10 10:01:00'),
(3,	'DWWM', 'creation site web',	'2025-10-22 09:02:00',	'2025-01-10 10:02:00'),
(4,	'DevOps Engineer', 'déploiement applicatif',	'2025-10-24 12:06:57',	'2025-10-24 12:06:57');


INSERT INTO `organization` (`id`, `siret`, `name`, `updated_at`, `created_at`) VALUES
(1,	'12345678901234',	'AFPA Bégles',	'2025-10-22 09:00:00',	'2025-01-10 10:00:00'),
(2,	'12345678901235',	'AFPA Paris',	'2025-10-22 09:01:00',	'2025-01-10 10:01:00');


INSERT INTO `company` (`id`, `siret`, `name`, `phone_number`, `updated_at`, `created_at`, `address`) VALUES
(1,	'82341567800012',	'Meta',	'0145678912',	'2025-10-22 09:00:00',	'2025-01-15 10:00:00',	'10 Rue de la Tech, 75001 Paris, France'),
(2,	'82341567800023',	'Apple',	'0145678913',	'2025-10-22 09:01:00',	'2025-01-15 10:01:00',	'20 Avenue des Pommes, 75002 Paris, France'),
(3,	'82341567800034',	'Microsoft',	'0145678914',	'2025-10-22 09:02:00',	'2025-01-15 10:02:00',	'30 Boulevard Windows, 75003 Paris, France'),
(4,	'82341567800045',	'Amazon',	'0145678915',	'2025-10-22 09:03:00',	'2025-01-15 10:03:00',	'40 Rue du Commerce, 75004 Paris, France'),
(5,	'82341567800056',	'Google',	'0145678916',	'2025-10-22 09:04:00',	'2025-01-15 10:04:00',	'50 Place de la Recherche, 75005 Paris, France'),
(6,	'82341567800067',	'Netflix',	'0145678917',	'2025-10-22 09:05:00',	'2025-01-15 10:05:00',	'60 Avenue du Streaming, 75006 Paris, France'),
(7,	'82341567800078',	'Tesla',	'0145678918',	'2025-10-22 09:06:00',	'2025-01-15 10:06:00',	'70 Route Électrique, 75007 Paris, France'),
(8,	'82341567800089',	'Spotify',	'0145678919',	'2025-10-22 09:07:00',	'2025-01-15 10:07:00',	'80 Rue de la Musique, 75008 Paris, France');



INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `login`, `updated_at`, `created_at`, `role`, `notification`, `dark_mode`, `avatar`, `phone`, `address`, `birthday`, `is_first_connection`) VALUES
(1, 'vpg@gmail.com', '$2y$13$DCqcmcfTYU3q.t01thUr0OIWJr5D/SvxFF3sjH74OsaKN9/G2rfmK', 'Vincent', 'Pierre-Gaillard', 'vincentpg', '2025-10-20 16:28:03', '2025-10-20 16:28:03', 'organization', 1, 0, 'https://randomuser.me/api/portraits/men/1.jpg', '0612345678', '12 Rue de Paris, 75001 Paris, France', '1985-05-15', 0),
(2, 'jérémiechabanais@gmail.com', '$2y$13$3jfSIjbBADnm/bQkzKR6gevIlN1PO39GQssxhkN8rxYTJUECAt0Yq', 'Jérémie', 'Chabanais', 'jeremiec', '2025-10-20 16:28:45', '2025-10-20 16:28:45', 'organization', 1, 1, 'https://randomuser.me/api/portraits/men/2.jpg', '0612345679', '15 Avenue de Lyon, 69001 Lyon, France', '1988-08-22', 0),
(3, 'maximecouillet@gmail.com', '$2y$13$7nG41tFtzJZOwo5ebjrFiOds8hhTs3v8v4j4uluLG3oKaVf.vew8G', 'Maxime', 'Couillet', 'maximec', '2025-10-20 16:29:37', '2025-10-20 16:29:37', 'intern', 0, 0, 'https://randomuser.me/api/portraits/men/3.jpg', '0612345680', '20 Boulevard des Étudiants, 33000 Bordeaux, France', '2000-03-10', 0),
(4, 'melissabedhomme@gmail.com', '$2y$13$4vU32kQWsNhZA5AYUIJdeeAifdZfMuycbApUVHxlL6dkS/io/.68m', 'Mélissa', 'Bedhomme', 'melissab', '2025-10-20 16:30:09', '2025-10-20 16:30:09', 'intern', 1, 1, 'https://randomuser.me/api/portraits/women/1.jpg', '0612345681', '25 Rue de Marseille, 13001 Marseille, France', '1999-11-25', 0),
(5, 'arnaurabel@gmail.com', '$2y$13$zaB7zjMxgpZ7A2drGcELYu7dDWuRViQJr7JWTPYuLEQTG4RXOo.nO', 'Arnaud', 'Rabel', 'arnaudr', '2025-10-20 16:30:32', '2025-10-20 16:30:32', 'intern', 0, 0, 'https://randomuser.me/api/portraits/men/4.jpg', '0612345682', '30 Place de Toulouse, 31000 Toulouse, France', '2001-01-18', 0),
(6, 'monique@gmail.com', '$2y$13$R64w.Fn4Q77ouv25eOW6gOw3/6wNqhgIDECIz9a/LveOiPAqxTaxC', 'Monique', 'Lefevre', 'monique', '2025-10-20 16:31:02', '2025-10-20 16:31:02', 'organization', 1, 0, 'https://randomuser.me/api/portraits/women/2.jpg', '0612345683', '35 Quai de Bordeaux, 33000 Bordeaux, France', '1975-06-30', 0),
(7, 'amine-elkhal@gmail.com', '$2y$13$qpBm5FQFDyvUZ7ktKYVvwOXeemc/iTvRIDHTYNTCIlnfU2fMW/52q', 'Amine', 'El Khal', 'aminel', '2025-10-20 16:33:36', '2025-10-20 16:33:36', 'intern', 0, 1, 'https://randomuser.me/api/portraits/men/5.jpg', '0612345684', '40 Rue de Nantes, 44000 Nantes, France', '2002-04-12', 0),
(8, 'mounirsebti@gmail.com', '$2y$13$PCo.TyRbXLEejags1J05yeM8CH64153FCrS9loYEKIKEPvP0Zwil2', 'Mounir', 'Sebti', 'mounirs', '2025-10-20 16:34:21', '2025-10-20 16:34:21', 'intern', 1, 0, 'https://randomuser.me/api/portraits/men/6.jpg', '0612345685', '45 Avenue de Strasbourg, 67000 Strasbourg, France', '1998-09-05', 0),
(9, 'margothourdille@gmail.com', '$2y$13$iqKPXtRXsLpp8mtHXs42be.932l4e4NnCuSvhoHuo1shnbz0Qh4Ru', 'Margot', 'Hourdille', 'margoth', '2025-10-20 16:34:48', '2025-10-20 16:34:48', 'intern', 1, 1, 'https://randomuser.me/api/portraits/women/3.jpg', '0612345686', '50 Boulevard de Lille, 59000 Lille, France', '2000-07-20', 0),
(10, 'julengouchault@gmail.com', '$2y$13$wFxFY3CxdrhMEW5dpUs02OjQOLRh9qda/G/gRK8ly1iE0d2GvWoBu', 'Julen', 'Gouchault', 'juleng', '2025-10-20 16:35:24', '2025-10-20 16:35:24', 'intern', 0, 0, 'https://randomuser.me/api/portraits/men/7.jpg', '0612345687', '55 Rue de Rennes, 35000 Rennes, France', '2001-12-03', 0),
(11, 'karimmohamed@gmail.com', '$2y$13$MTaVcvFIaNdaUTBxLdxt3e5H03FUzBl2GnbWvc8B57sH26vpXNyna', 'Karim', 'Imad Mohamed', 'karimi', '2025-10-20 16:36:00', '2025-10-20 16:36:00', 'intern', 1, 1, 'https://randomuser.me/api/portraits/men/8.jpg', '0612345688', '60 Place de Nice, 06000 Nice, France', '1999-02-28', 0),
(12, 'sabrinabenoudiba@gmail.com', '$2y$13$tkUj6jS7tr7lZwml8W6jiuh.UQWnTFxWL0Ca0/mKzXCNLzi.69exe', 'Sabrina', 'Benoudiba', 'sabrinab', '2025-10-20 16:37:54', '2025-10-20 16:37:54', 'intern', 0, 0, 'https://randomuser.me/api/portraits/women/4.jpg', '0612345689', '65 Avenue de Montpellier, 34000 Montpellier, France', '2000-10-15', 0),
(13, 'sariashamashan@gmail.com', '$2y$13$gJVttro416qztjr3q/ubyu0xwyuDyq9J27ecSlbkUTQJBQK8X.7gW', 'Saria', 'Shamashan', 'sarias', '2025-10-20 16:38:30', '2025-10-20 16:38:30', 'intern', 1, 0, 'https://randomuser.me/api/portraits/women/5.jpg', '0612345690', '70 Rue de Reims, 51100 Reims, France', '2002-05-08', 0),
(14, 'azizalahcen@gmail.com', '$2y$13$qaO.3blj/bvgthnzLTb40uo/jLqLo1nSO7GehAqAVQnrLEc7eTLSa', 'Aziza', 'Ait Lahcen', 'azizal', '2025-10-20 16:39:08', '2025-10-20 16:39:08', 'intern', 1, 1, 'https://randomuser.me/api/portraits/women/6.jpg', '0612345691', '75 Boulevard de Dijon, 21000 Dijon, France', '1998-08-19', 0),
(15, 'patiencekoribirama@gmail.com', '$2y$13$aYM1./nWbarj1Lv8tWLOsOQdNs55yGLQoe50QPZlZxQu3ke896jMa', 'Patience', 'Koribirama', 'patiencek', '2025-10-20 16:39:50', '2025-10-20 16:39:50', 'intern', 0, 1, 'https://randomuser.me/api/portraits/women/7.jpg', '0612345692', '80 Place de Tours, 37000 Tours, France', '2001-03-22', 0),
(16, 'charlesproust@gmail.com', '$2y$13$yBV0p0YErW7WJ0Cn4BShL.3.8Tk7wz.HOMBAHMUjARvOt.tFnuZNu', 'Charles', 'Proust', 'charlesp', '2025-10-20 16:40:36', '2025-10-20 16:40:36', 'intern', 1, 0, 'https://randomuser.me/api/portraits/men/9.jpg', '0612345693', '85 Avenue de Clermont-Ferrand, 63000 Clermont-Ferrand, France', '2000-11-11', 0),
(17, 'monalisacdui@gmail.com', '$2y$13$txyfUjDvP9lly.N3q2yuMeu8sLQeFDVe6Zfn2eowdzIV9o9OhuQSe', 'Lisa', 'Mona', 'lisam', '2025-10-20 18:07:21', '2025-10-20 18:07:21', 'intern', 1, 1, 'https://randomuser.me/api/portraits/women/8.jpg', '0612345694', '90 Rue de Grenoble, 38000 Grenoble, France', '1999-06-14', 0),
(18, 'tuteurfacebook@gmail.com', '$2y$13$TiONor0uVxoU0uU4pQs1muV9yi0GMwpUWThsI7D7Rows1m0HqRBzC', 'Marc', 'Dubois', 'tuteurf', '2025-10-20 18:08:37', '2025-10-20 18:08:37', 'company', 0, 0, 'https://randomuser.me/api/portraits/men/10.jpg', '0612345695', '10 Rue de la Tech, 75001 Paris, France', '1980-04-10', 0),
(19, 'tuteurapple@gmail.com', '$2y$13$Tc4VxQZ.GWyXLHv5VBWfGOgRgk0INUDW3ZXHEK7XBz2mdEolZx4la', 'Sophie', 'Martin', 'tuteura', '2025-10-20 18:09:25', '2025-10-20 18:09:25', 'company', 1, 0, 'https://randomuser.me/api/portraits/women/9.jpg', '0612345696', '20 Avenue des Pommes, 75002 Paris, France', '1983-07-18', 0),
(20, 'tuteurgoogle@gmail.com', '$2y$13$SqSdNBxD3bCn6xq1WoSBx.2fP1vVRyC.bvMXF35cXL8qAbmpEEZDC', 'Thomas', 'Petit', 'tuteurg', '2025-10-20 18:09:39', '2025-10-20 18:09:39', 'company', 0, 1, 'https://randomuser.me/api/portraits/men/11.jpg', '0612345697', '50 Place de la Recherche, 75005 Paris, France', '1978-12-25', 0),
(21, 'legalrpgoogle@gmail.com', '$2y$13$h/M6Rk5OgSev5ve.i34She2i.JglDFV9xUhsaFAanRODUwR6HhaRq', 'Sundar', 'Pichai', 'legalrpg', '2025-10-20 18:17:00', '2025-10-20 18:17:00', 'company', 1, 0, 'https://randomuser.me/api/portraits/men/12.jpg', '0612345698', '50 Place de la Recherche, 75005 Paris, France', '1972-06-10', 0),
(22, 'legalrpapple@gmail.com', '$2y$13$3xlhHOVVSCaCL/4tQsgu3.rWGkKx8XKGrNPBIYeBAWjl21qrG/n6i', 'Tim', 'Cook', 'legalrpa', '2025-10-20 18:17:19', '2025-10-20 18:17:19', 'company', 0, 1, 'https://randomuser.me/api/portraits/men/13.jpg', '0612345699', '20 Avenue des Pommes, 75002 Paris, France', '1960-11-01', 0),
(23, 'legalrpfacebook@gmail.com', '$2y$13$gIbAQvhWoaDIfTdk07PXY.HTLFbXW8ZjFmc/EyCt9wyAzf.KHQATC', 'Mark', 'Zuckerberg', 'legalrpf', '2025-10-20 18:17:36', '2025-10-20 18:17:36', 'company', 1, 1, 'https://randomuser.me/api/portraits/men/14.jpg', '0612345700', '10 Rue de la Tech, 75001 Paris, France', '1984-05-14', 0),
(24, 'jeanine@gmail.com', '$2y$13$RH0Ot8IHAM9SyEQ3Fp7N7OX70/yj5kNbbDQffuvarEsnlQ0v7mQLS', 'Jeanine', 'Moreau', 'jeanine', '2025-10-20 18:19:22', '2025-10-20 18:19:22', 'organization', 1, 0, 'https://randomuser.me/api/portraits/women/10.jpg', '0612345701', '95 Rue de Bègles, 33130 Bègles, France', '1970-03-15', 0),
(25, 'tuteurnetflix@gmail.com', '$2y$13$abcd1234567890abcdef', 'Julie', 'Bernard', 'tuteurnetflix', '2025-10-22 10:00:00', '2025-10-22 10:00:00', 'company', 1, 0, 'https://randomuser.me/api/portraits/women/11.jpg', '0612345702', '60 Avenue du Streaming, 75006 Paris, France', '1985-09-20', 0),
(26, 'tuteurtesla@gmail.com', '$2y$13$abcd1234567890abcdef', 'Luc', 'Robert', 'tuteurtesla', '2025-10-22 10:01:00', '2025-10-22 10:01:00', 'company', 0, 1, 'https://randomuser.me/api/portraits/men/15.jpg', '0612345703', '70 Route Électrique, 75007 Paris, France', '1982-02-14', 0),
(27, 'tuteurspotify@gmail.com', '$2y$13$abcd1234567890abcdef', 'Claire', 'Simon', 'tuteurspotify', '2025-10-22 10:02:00', '2025-10-22 10:02:00', 'company', 1, 1, 'https://randomuser.me/api/portraits/women/12.jpg', '0612345704', '80 Rue de la Musique, 75008 Paris, France', '1987-11-30', 0),
(28, 'legalnetflix@gmail.com', '$2y$13$abcd1234567890abcdef', 'Reed', 'Hastings', 'legalnetflix', '2025-10-22 10:03:00', '2025-10-22 10:03:00', 'company', 0, 0, 'https://randomuser.me/api/portraits/men/16.jpg', '0612345705', '60 Avenue du Streaming, 75006 Paris, France', '1960-10-08', 0),
(29, 'legaltesla@gmail.com', '$2y$13$abcd1234567890abcdef', 'Elon', 'Musk', 'legaltesla', '2025-10-22 10:04:00', '2025-10-22 10:04:00', 'company', 1, 0, 'https://randomuser.me/api/portraits/men/17.jpg', '0612345706', '70 Route Électrique, 75007 Paris, France', '1971-06-28', 0),
(30, 'legalspotify@gmail.com', '$2y$13$abcd1234567890abcdef', 'Daniel', 'Ek', 'legalspotify', '2025-10-22 10:05:00', '2025-10-22 10:05:00', 'company', 1, 1, 'https://randomuser.me/api/portraits/men/18.jpg', '0612345707', '80 Rue de la Musique, 75008 Paris, France', '1983-02-21', 0);


INSERT INTO `intern_member` (`id`, `user_id`, `updated_at`, `created_at`) VALUES
(101,	3,	'2025-10-22 09:00:00',	'2025-02-01 10:00:00'),
(102,	17,	'2025-10-22 09:01:00',	'2025-02-01 10:01:00'),
(103,	2,	'2025-10-22 09:02:00',	'2025-02-01 10:02:00'),
(104,	4,	'2025-10-22 09:03:00',	'2025-02-01 10:03:00'),
(105,	5,	'2025-10-22 09:04:00',	'2025-02-01 10:04:00'),
(106,	7,	'2025-10-22 09:05:00',	'2025-02-01 10:05:00'),
(107,	8,	'2025-10-22 09:06:00',	'2025-02-01 10:06:00'),
(108,	9,	'2025-10-22 09:07:00',	'2025-02-01 10:07:00'),
(109,	10,	'2025-10-22 09:08:00',	'2025-02-01 10:08:00'),
(110,	11,	'2025-10-22 09:09:00',	'2025-02-01 10:09:00'),
(111,	12,	'2025-10-22 09:10:00',	'2025-02-01 10:10:00'),
(112,	13,	'2025-10-22 09:11:00',	'2025-02-01 10:11:00'),
(113,	14,	'2025-10-22 09:12:00',	'2025-02-01 10:12:00'),
(114,	15,	'2025-10-22 09:13:00',	'2025-02-01 10:13:00'),
(115,	16,	'2025-10-22 09:14:00',	'2025-02-01 10:14:00'),
(116,	18,	'2025-10-22 09:15:00',	'2025-02-01 10:15:00'),
(117,	19,	'2025-10-22 09:16:00',	'2025-02-01 10:16:00'),
(118,	20,	'2025-10-22 09:17:00',	'2025-02-01 10:17:00');


INSERT INTO `organization_member` (`id`, `user_id`, `organization_id`, `role`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 'trainer', '2025-10-22 09:00:00', '2025-02-01 10:00:00'),
(2, 6, 1, 'monique', '2025-10-24 13:15:38', '2025-02-01 10:01:00'),
(3, 2, 1, 'trainer', '2025-10-22 09:02:00', '2025-02-01 10:02:00');


INSERT INTO `company_member` (`id`, `user_id`, `company_id`, `role`, `updated_at`, `created_at`) VALUES
(1, 18, 1, 'tutor', '2025-10-22 09:00:00', '2025-02-01 10:00:00'),
(2, 19, 2, 'tutor', '2025-10-22 09:01:00', '2025-02-01 10:01:00'),
(3, 20, 5, 'tutor', '2025-10-22 09:02:00', '2025-02-01 10:02:00'),
(4, 21, 5, 'legal_representative', '2025-10-22 09:03:00', '2025-02-01 10:03:00'),
(5, 22, 2, 'legal_representative', '2025-10-22 09:04:00', '2025-02-01 10:04:00'),
(6, 23, 1, 'legal_representative', '2025-10-22 09:05:00', '2025-02-01 10:05:00'),
(7, 25, 6, 'tutor', '2025-10-22 09:06:00', '2025-02-01 10:06:00'),
(8, 26, 7, 'tutor', '2025-10-22 09:07:00', '2025-02-01 10:07:00'),
(9, 27, 8, 'tutor', '2025-10-22 09:08:00', '2025-02-01 10:08:00'),
(10, 28, 6, 'legal_representative', '2025-10-22 09:09:00', '2025-02-01 10:09:00'),
(11, 29, 7, 'legal_representative', '2025-10-22 09:10:00', '2025-02-01 10:10:00'),
(12, 30, 8, 'legal_representative', '2025-10-22 09:11:00', '2025-02-01 10:11:00');


INSERT INTO `training_session` (`id`, `training_id`, `offer_number`, `internship_period_start`, `internship_period_end`, `training_period_start`, `training_period_end`, `updated_at`, `created_at`, `has_ended`) VALUES
(1,	4,	'OFF-2024-001',	'2025-11-01',	'2025-12-31',	'2025-03-01',	'2026-02-28',	'2025-10-24 13:33:17',	'2025-03-01 10:00:00',	1),
(2,	2,	'OFF-2024-002',	'2025-11-01',	'2025-12-31',	'2025-03-15',	'2026-03-14',	'2025-10-22 09:00:00',	'2025-03-15 10:00:00',	0),
(3,	3,	'OFF-2024-003',	'2025-11-15',	'2026-01-15',	'2025-04-01',	'2026-03-31',	'2025-10-22 09:01:00',	'2025-04-01 10:00:00',	0);


INSERT INTO `organization_member_training_session` (`organization_member_id`, `training_session_id`) VALUES
(1,	2),
(2,	1),
(3,	1);


INSERT INTO `training_session_intern_member` (`training_session_id`, `intern_member_id`) VALUES
(1, 101),
(1, 102),
(1, 103),
(1, 104),
(1, 105),
(1, 106),
(1, 107),
(1, 108),
(2, 106),
(2, 107),
(2, 108),
(2, 109),
(2, 110),
(2, 111),
(2, 112),
(2, 113),
(2, 114),
(2, 115);


INSERT INTO `info_form_intern_company` (`id`, `company_name`, `address`, `email`, `updated_at`, `created_at`, `legal_representative_last_name`, `legal_representative_first_name`) VALUES
(101,	'Société Générale Technologies',	'15 Avenue des Champs-Élysées, 75008 Paris, France',	'contact@sgtech.fr',	'2025-10-25 05:56:08',	'2025-10-25 05:56:08',	'Dupont',	'Marie'),
(102,	'Tech Solutions SARL',	'25 Rue de la République, 69002 Lyon, France',	'contact@techsolutions.fr',	'2025-10-22 10:01:00',	'2025-10-22 10:01:00',	'Martin',	'Jean'),
(103,	'Digital Experts SAS',	'12 Boulevard Haussmann, 75009 Paris, France',	'info@digitalexperts.fr',	'2025-10-22 10:02:00',	'2025-10-22 10:02:00',	'Dubois',	'Sophie'),
(104,	'Innovation Labs',	'8 Avenue Victor Hugo, 33000 Bordeaux, France',	'hello@innovationlabs.fr',	'2025-10-22 10:03:00',	'2025-10-22 10:03:00',	'Leroy',	'Pierre'),
(105,	'Web Creators',	'45 Rue de Rivoli, 75001 Paris, France',	'contact@webcreators.fr',	'2025-10-22 10:04:00',	'2025-10-22 10:04:00',	'Bernard',	'Marie'),
(106,	'Cloud Services France',	'22 Quai de la Loire, 75019 Paris, France',	'info@cloudservices.fr',	'2025-10-22 10:05:00',	'2025-10-22 10:05:00',	'Petit',	'Luc'),
(107,	'Data Analytics Pro',	'17 Rue de la Paix, 75002 Paris, France',	'contact@dataanalytics.fr',	'2025-10-22 10:06:00',	'2025-10-22 10:06:00',	'Moreau',	'Claire'),
(108,	'Mobile Dev Studio',	'33 Avenue Montaigne, 75008 Paris, France',	'hello@mobiledev.fr',	'2025-10-22 10:07:00',	'2025-10-22 10:07:00',	'Simon',	'Thomas'),
(109,	'AI Innovations',	'50 Rue du Faubourg Saint-Honoré, 75008 Paris, France',	'info@aiinnovations.fr',	'2025-10-22 11:00:00',	'2025-10-22 11:00:00',	'Laurent',	'Emma'),
(110,	'Cyber Security Plus',	'14 Avenue des Ternes, 75017 Paris, France',	'contact@cybersecurity.fr',	'2025-10-22 11:01:00',	'2025-10-22 11:01:00',	'Roux',	'Antoine'),
(111,	'DevOps Solutions',	'28 Rue de Courcelles, 75008 Paris, France',	'info@devops.fr',	'2025-10-22 11:02:00',	'2025-10-22 11:02:00',	'Girard',	'Julie'),
(112,	'E-Commerce Experts',	'19 Boulevard des Capucines, 75002 Paris, France',	'contact@ecommerce.fr',	'2025-10-22 11:03:00',	'2025-10-22 11:03:00',	'Faure',	'Nicolas'),
(113,	'Blockchain Technologies',	'41 Rue de la Boétie, 75008 Paris, France',	'hello@blockchain.fr',	'2025-10-22 11:04:00',	'2025-10-22 11:04:00',	'Mercier',	'David'),
(114,	'UX Design Studio',	'23 Rue de Berri, 75008 Paris, France',	'info@uxdesign.fr',	'2025-10-22 11:05:00',	'2025-10-22 11:05:00',	'Boyer',	'Isabelle'),
(115,	'IoT Solutions',	'37 Avenue George V, 75008 Paris, France',	'contact@iotsolutions.fr',	'2025-10-22 11:06:00',	'2025-10-22 11:06:00',	'Blanc',	'François'),
(116,	'Gaming Studios France',	'52 Rue Pierre Charron, 75008 Paris, France',	'hello@gamingstudios.fr',	'2025-10-22 11:07:00',	'2025-10-22 11:07:00',	'Garnier',	'Céline'),
(117,	'VR Experiences',	'16 Rue Marbeuf, 75008 Paris, France',	'info@vrexperiences.fr',	'2025-10-22 11:08:00',	'2025-10-22 11:08:00',	'Robert',	'Camille'),
(118,	'Smart City Tech',	'44 Avenue Marceau, 75008 Paris, France',	'contact@smartcity.fr',	'2025-10-22 11:09:00',	'2025-10-22 11:09:00',	'Vincent',	'Maxime'),
(119,	'DevOps Company',	'50 Rue du Faubourg Saint-Honoré, 75008 Paris, France',	'contact@devopscompany.fr',	'2025-10-22 11:10:00',	'2025-10-22 11:10:00',	'Wilson',	'Kate'),
(120,	'AI Research Lab',	'60 Avenue des Champs-Élysées, 75008 Paris, France',	'hello@airesearch.fr',	'2025-10-22 11:11:00',	'2025-10-22 11:11:00',	'Anderson',	'Tom'),
(121,	'CyberSec Solutions',	'70 Boulevard Haussmann, 75008 Paris, France',	'info@cybersec.fr',	'2025-10-22 11:12:00',	'2025-10-22 11:12:00',	'Johnson',	'Lisa'),
(122,	'UX Design Studio',	'80 Rue de Rivoli, 75008 Paris, France',	'contact@uxdesign.fr',	'2025-10-22 11:13:00',	'2025-10-22 11:13:00',	'Brown',	'Mike'),
(123,	'Data Analytics Corp',	'90 Place Vendôme, 75008 Paris, France',	'hello@dataanalytics.fr',	'2025-10-22 11:14:00',	'2025-10-22 11:14:00',	'Davis',	'Sarah');


INSERT INTO `info_form_intern` (`id`, `info_form_intern_company_id`, `date_start`, `date_end`, `gender`, `updated_at`, `created_at`, `status`) VALUES
(101, 101, '2025-11-01', '2025-12-31', 'male', '2025-10-25 05:58:27', '2025-10-22 10:00:00', 'validated'),
(102, 102, '2025-11-01', '2025-12-31', 'female', '2025-10-22 10:01:00', '2025-10-22 10:01:00', 'validated'),
(103, 103, '2025-11-01', '2025-12-31', 'male', '2025-10-22 10:02:00', '2025-10-22 10:02:00', 'pending'),
(104, 104, '2025-11-01', '2025-12-31', 'female', '2025-10-22 10:03:00', '2025-10-22 10:03:00', 'invalidated'),
(105, 105, '2025-11-01', '2025-12-31', 'male', '2025-10-22 10:04:00', '2025-10-22 10:04:00', 'validated'),
(106, 106, '2025-11-01', '2025-12-31', 'female', '2025-10-22 10:05:00', '2025-10-22 10:05:00', 'pending'),
(107, 107, '2025-11-01', '2025-12-31', 'male', '2025-10-22 10:06:00', '2025-10-22 10:06:00', 'invalidated'),
(108, 108, '2025-11-01', '2025-12-31', 'male', '2025-10-22 10:07:00', '2025-10-22 10:07:00', 'validated'),
(109, 109, '2025-11-01', '2025-12-31', 'female', '2025-10-22 11:00:00', '2025-10-22 11:00:00', 'validated'),
(110, 110, '2025-11-01', '2025-12-31', 'male', '2025-10-22 11:01:00', '2025-10-22 11:01:00', 'pending'),
(111, 111, '2025-11-01', '2025-12-31', 'female', '2025-10-22 11:02:00', '2025-10-22 11:02:00', 'pending'),
(112, 112, '2025-11-01', '2025-12-31', 'male', '2025-10-22 11:03:00', '2025-10-22 11:03:00', 'validated'),
(113, 113, '2025-11-01', '2025-12-31', 'male', '2025-10-22 11:04:00', '2025-10-22 11:04:00', 'invalidated'),
(114, 114, '2025-11-01', '2025-12-31', 'female', '2025-10-22 11:05:00', '2025-10-22 11:05:00', 'invalidated'),
(115, 115, '2025-11-01', '2025-12-31', 'male', '2025-10-22 11:06:00', '2025-10-22 11:06:00', 'validated'),
(116, 116, '2025-11-01', '2025-12-31', 'female', '2025-10-22 11:07:00', '2025-10-22 11:07:00', 'pending'),
(117, 117, '2025-11-01', '2025-12-31', 'male', '2025-10-22 11:08:00', '2025-10-22 11:08:00', 'pending'),
(118, 118, '2025-11-01', '2025-12-31', 'male', '2025-10-22 11:09:00', '2025-10-22 11:09:00', 'validated'),
(119, 119, '2025-11-01', '2025-12-31', 'female', '2025-10-22 11:10:00', '2025-10-22 11:10:00', 'validated'),
(120, 120, '2025-11-01', '2025-12-31', 'male', '2025-10-22 11:11:00', '2025-10-22 11:11:00', 'validated'),
(121, 121, '2025-11-01', '2025-12-31', 'female', '2025-10-22 11:12:00', '2025-10-22 11:12:00', 'validated'),
(122, 122, '2025-11-01', '2025-12-31', 'male', '2025-10-22 11:13:00', '2025-10-22 11:13:00', 'validated'),
(123, 123, '2025-11-01', '2025-12-31', 'female', '2025-10-22 11:14:00', '2025-10-22 11:14:00', 'validated');


INSERT INTO `info_form_company` (`id`, `fax`, `activity`, `activity_description`, `stamp`, `legal_representative_gender`, `legal_representative_last_name`, `legal_representative_first_name`, `legal_representative_signature`, `legal_representative_email`, `interview_start_date_time`, `interview_end_date_time`, `agree_terms`, `work_location`, `tutor_gender`, `tutor_first_name`, `tutor_last_name`, `tutor_email`, `tutor_phone_number`, `updated_at`, `created_at`, `status`) VALUES
(101, '01 42 68 53 00', 'Développement de logiciels et conseil en technologies de l\'information', 'Société spécialisée dans le développement de solutions logicielles sur mesure, le conseil en transformation digitale et l\'intégration de systèmes d\'information pour les entreprises du secteur financier et bancaire.', 'stamp-101.png', 'female', 'Dupont', 'Marie', 'signature-101.png', 'marie.dupont@sgtech.fr', '2025-11-15 09:00:00', '2025-11-15 11:00:00', 1, 'hybrid', 'male', 'Jean', 'Martin', 'jean.martin@sgtech.fr', '01 42 68 53 15', '2025-10-25 06:13:24', '2025-10-22 10:00:00', 'validated'),
(102, '01 45 67 89 20', 'Conseil en systèmes informatiques', 'Expertise en cloud computing et infrastructure', 'stamp-102.png', 'male', 'Johnson', 'Mark', 'signature-102.png', 'mark.johnson@apple.com', '2025-11-15 14:00:00', '2025-11-15 16:00:00', 1, 'on_site', 'female', 'Sophie', 'Bernard', 'sophie.bernard@apple.com', '01 45 67 89 21', '2025-10-22 10:01:00', '2025-10-22 10:01:00', 'validated'),
(103, '01 45 67 89 30', 'Edition de logiciels applicatifs', 'Solutions professionnelles pour entreprises', 'stamp-103.png', 'male', 'Gates', 'William', 'signature-103.png', 'william.gates@microsoft.com', '2025-11-16 09:00:00', '2025-11-16 11:00:00', 1, 'hybrid', 'male', 'Pierre', 'Durant', 'pierre.durant@microsoft.com', '01 45 67 89 31', '2025-10-22 10:02:00', '2025-10-22 10:02:00', 'validated'),
(104, '01 45 67 89 40', 'Commerce électronique', 'Plateforme de vente en ligne', 'stamp-104.png', 'male', 'Bezos', 'Jeff', 'signature-104.png', 'jeff.bezos@amazon.com', '2025-11-16 14:00:00', '2025-11-16 16:00:00', 1, 'remote', 'female', 'Marie', 'Leclerc', 'marie.leclerc@amazon.com', '01 45 67 89 41', '2025-10-22 10:03:00', '2025-10-22 10:03:00', 'validated'),
(105, '01 45 67 89 50', 'Moteur de recherche et services web', 'Technologies de recherche et publicité en ligne', 'stamp-105.png', 'male', 'Pichai', 'Sundar', 'signature-105.png', 'sundar.pichai@google.com', '2025-11-17 09:00:00', '2025-11-17 11:00:00', 1, 'hybrid', 'male', 'Thomas', 'Petit', 'thomas.petit@google.com', '01 45 67 89 51', '2025-10-22 10:04:00', '2025-10-22 10:04:00', 'validated'),
(106, '01 45 67 89 60', 'Streaming vidéo', 'Production et distribution de contenus audiovisuels', 'stamp-106.png', 'male', 'Hastings', 'Reed', 'signature-106.png', 'reed.hastings@netflix.com', '2025-11-17 14:00:00', '2025-11-17 16:00:00', 1, 'on_site', 'female', 'Julie', 'Moreau', 'julie.moreau@netflix.com', '01 45 67 89 61', '2025-10-22 10:05:00', '2025-10-22 10:05:00', 'validated'),
(107, '01 45 67 89 70', 'Construction automobile électrique', 'Véhicules électriques et énergies renouvelables', 'stamp-107.png', 'male', 'Musk', 'Elon', 'signature-107.png', 'elon.musk@tesla.com', '2025-11-18 09:00:00', '2025-11-18 11:00:00', 0, 'hybrid', 'male', 'Luc', 'Robert', 'luc.robert@tesla.com', '01 45 67 89 71', '2025-10-22 10:06:00', '2025-10-22 10:06:00', 'invalidated'),
(108, '01 45 67 89 80', 'Streaming audio', 'Plateforme de musique en streaming', 'stamp-108.png', 'male', 'Ek', 'Daniel', 'signature-108.png', 'daniel.ek@spotify.com', '2025-11-18 14:00:00', '2025-11-18 16:00:00', 1, 'remote', 'female', 'Claire', 'Simon', 'claire.simon@spotify.com', '01 45 67 89 81', '2025-10-22 10:07:00', '2025-10-22 10:07:00', 'validated'),
(109, '01 45 67 89 90', 'Réseaux sociaux', 'Plateforme de communication et partage', 'stamp-109.png', 'male', 'Zuckerberg', 'Mark', 'signature-109.png', 'mark.zuck@meta.com', '2025-11-19 09:00:00', '2025-11-19 11:00:00', 1, 'hybrid', 'male', 'Antoine', 'Roux', 'antoine.roux@meta.com', '01 45 67 89 91', '2025-10-22 11:00:00', '2025-10-22 11:00:00', 'validated'),
(110, '01 45 67 89 92', 'Conseil en systèmes informatiques', 'Solutions cloud et data centers', 'stamp-110.png', 'female', 'Cook', 'Linda', 'signature-110.png', 'linda.cook@apple.com', '2025-11-19 14:00:00', '2025-11-19 16:00:00', 1, 'on_site', 'male', 'François', 'Lefebvre', 'francois.lefebvre@apple.com', '01 45 67 89 93', '2025-10-22 11:01:00', '2025-10-22 11:01:00', 'pending'),
(111, '01 45 67 89 94', 'Edition de logiciels système', 'Systèmes d\'exploitation et outils', 'stamp-111.png', 'male', 'Nadella', 'Satya', 'signature-111.png', 'satya.nadella@microsoft.com', '2025-11-20 09:00:00', '2025-11-20 11:00:00', 1, 'hybrid', 'female', 'Emma', 'Garnier', 'emma.garnier@microsoft.com', '01 45 67 89 95', '2025-10-22 11:02:00', '2025-10-22 11:02:00', 'validated'),
(112, '01 45 67 89 96', 'Commerce électronique', 'Logistique et livraison express', 'stamp-112.png', 'male', 'Jassy', 'Andy', 'signature-112.png', 'andy.jassy@amazon.com', '2025-11-20 14:00:00', '2025-11-20 16:00:00', 1, 'remote', 'male', 'David', 'Faure', 'david.faure@amazon.com', '01 45 67 89 97', '2025-10-22 11:03:00', '2025-10-22 11:03:00', 'pending'),
(113, '01 45 67 89 98', 'Intelligence artificielle', 'Recherche et développement IA', 'stamp-113.png', 'male', 'Dean', 'Jeff', 'signature-113.png', 'jeff.dean@google.com', '2025-11-21 09:00:00', '2025-11-21 11:00:00', 1, 'hybrid', 'female', 'Isabelle', 'Mercier', 'isabelle.mercier@google.com', '01 45 67 89 99', '2025-10-22 11:04:00', '2025-10-22 11:04:00', 'pending'),
(114, '01 45 67 90 00', 'Production audiovisuelle', 'Création de contenus originaux', 'stamp-114.png', 'female', 'Sarandos', 'Teresa', 'signature-114.png', 'teresa.sarandos@netflix.com', '2025-11-21 14:00:00', '2025-11-21 16:00:00', 0, 'on_site', 'male', 'Nicolas', 'Boyer', 'nicolas.boyer@netflix.com', '01 45 67 90 01', '2025-10-22 11:05:00', '2025-10-22 11:05:00', 'invalidated'),
(115, '01 45 67 90 02', 'Mobilité électrique', 'Innovation en transport durable', 'stamp-115.png', 'male', 'Straubel', 'JB', 'signature-115.png', 'jb.straubel@tesla.com', '2025-11-22 09:00:00', '2025-11-22 11:00:00', 1, 'hybrid', 'female', 'Céline', 'Laurent', 'celine.laurent@tesla.com', '01 45 67 90 03', '2025-10-22 11:06:00', '2025-10-22 11:06:00', 'validated'),
(116, '01 45 67 90 04', 'Distribution musicale', 'Catalogue musical mondial', 'stamp-116.png', 'male', 'Lorentzon', 'Martin', 'signature-116.png', 'martin.lorentzon@spotify.com', '2025-11-22 14:00:00', '2025-11-22 16:00:00', 1, 'remote', 'male', 'Julien', 'Blanc', 'julien.blanc@spotify.com', '01 45 67 90 05', '2025-10-22 11:07:00', '2025-10-22 11:07:00', 'pending'),
(117, '01 45 67 90 06', 'Réalité virtuelle', 'Technologies immersives', 'stamp-117.png', 'male', 'Bosworth', 'Andrew', 'signature-117.png', 'andrew.bosworth@meta.com', '2025-11-23 09:00:00', '2025-11-23 11:00:00', 1, 'hybrid', 'female', 'Camille', 'Girard', 'camille.girard@meta.com', '01 45 67 90 07', '2025-10-22 11:08:00', '2025-10-22 11:08:00', 'validated'),
(118, '01 45 67 90 08', 'Services cloud', 'Infrastructure as a Service', 'stamp-118.png', 'male', 'Federighi', 'Craig', 'signature-118.png', 'craig.federighi@apple.com', '2025-11-23 14:00:00', '2025-11-23 16:00:00', 1, 'on_site', 'male', 'Maxime', 'Vincent', 'maxime.vincent@apple.com', '01 45 67 90 09', '2025-10-22 11:09:00', '2025-10-22 11:09:00', 'validated'),
(119, '01 45 67 90 10', 'DevOps', 'Infrastructure et déploiement', 'stamp-119.png', 'female', 'Wilson', 'Kate', 'signature-119.png', 'kate.wilson@company.com', '2025-11-24 09:00:00', '2025-11-24 11:00:00', 1, 'hybrid', 'male', 'Pierre', 'Martin', 'pierre.martin@company.com', '01 45 67 90 11', '2025-10-22 11:10:00', '2025-10-22 11:10:00', 'validated'),
(120, '01 45 67 90 12', 'Machine Learning', 'IA et apprentissage automatique', 'stamp-120.png', 'male', 'Anderson', 'Tom', 'signature-120.png', 'tom.anderson@company.com', '2025-11-24 14:00:00', '2025-11-24 16:00:00', 1, 'remote', 'female', 'Sophie', 'Durand', 'sophie.durand@company.com', '01 45 67 90 13', '2025-10-22 11:11:00', '2025-10-22 11:11:00', 'validated'),
(121, '01 45 67 90 14', 'Cybersécurité', 'Protection des données', 'stamp-121.png', 'female', 'Johnson', 'Lisa', 'signature-121.png', 'lisa.johnson@company.com', '2025-11-25 09:00:00', '2025-11-25 11:00:00', 1, 'on_site', 'male', 'Marc', 'Dubois', 'marc.dubois@company.com', '01 45 67 90 15', '2025-10-22 11:12:00', '2025-10-22 11:12:00', 'validated'),
(122, '01 45 67 90 16', 'UX/UI Design', 'Expérience utilisateur', 'stamp-122.png', 'male', 'Brown', 'Mike', 'signature-122.png', 'mike.brown@company.com', '2025-11-25 14:00:00', '2025-11-25 16:00:00', 1, 'hybrid', 'female', 'Émilie', 'Leroy', 'emilie.leroy@company.com', '01 45 67 90 17', '2025-10-22 11:13:00', '2025-10-22 11:13:00', 'validated'),
(123, '01 45 67 90 18', 'Data Science', 'Analyse de données avancée', 'stamp-123.png', 'female', 'Davis', 'Sarah', 'signature-123.png', 'sarah.davis@company.com', '2025-11-26 09:00:00', '2025-11-26 11:00:00', 1, 'remote', 'male', 'Alexandre', 'Moreau', 'alexandre.moreau@company.com', '01 45 67 90 19', '2025-10-22 11:14:00', '2025-10-22 11:14:00', 'validated');


INSERT INTO `info_form_company_calendar_row` (`id`, `info_form_company_id`, `day`, `start_morning`, `end_morning`, `start_afternoon`, `end_afternoon`, `work_location`, `updated_at`, `created_at`) VALUES
(1, 101, 'monday', '09:00:00', '12:00:00', '14:00:00', '18:00:00', 'remote', '2025-10-25 06:14:19', '2025-10-25 06:14:19'),
(2, 101, 'tuesday', '09:00:00', '12:00:00', '14:00:00', '18:00:00', 'remote', '2025-10-25 06:14:49', '2025-10-25 06:14:49'),
(3, 101, 'wednesday', '09:00:00', '12:00:00', '14:00:00', '18:00:00', 'on_site', '2025-10-25 06:14:57', '2025-10-25 06:14:57'),
(4, 101, 'thursday', '09:00:00', '12:00:00', '14:00:00', '18:00:00', 'on_site', '2025-10-25 06:15:02', '2025-10-25 06:15:02'),
(5, 101, 'friday', '09:00:00', '12:00:00', '14:00:00', '17:00:00', 'hybrid', '2025-10-25 06:15:09', '2025-10-25 06:15:09');


INSERT INTO `info_form_organization` (`id`, `validation_date`, `signature`, `updated_at`, `created_at`, `status`) VALUES
(101, '2025-10-25', 'org-signature-101.png', '2025-10-25 06:09:04', '2025-10-22 10:00:00', 'validated'),
(102, '2025-10-23', 'org-signature-102.png', '2025-10-23 10:01:00', '2025-10-22 10:01:00', 'validated'),
(103, '2025-10-23', 'org-signature-103.png', '2025-10-23 10:02:00', '2025-10-22 10:02:00', 'validated'),
(104, '2025-10-23', 'org-signature-104.png', '2025-10-23 10:03:00', '2025-10-22 10:03:00', 'pending'),
(105, '2025-10-23', 'org-signature-105.png', '2025-10-23 10:04:00', '2025-10-22 10:04:00', 'pending'),
(106, '2025-10-23', 'org-signature-106.png', '2025-10-23 10:05:00', '2025-10-22 10:05:00', 'pending'),
(107, '2025-10-23', 'org-signature-107.png', '2025-10-23 10:06:00', '2025-10-22 10:06:00', 'invalidated'),
(108, '2025-10-23', 'org-signature-108.png', '2025-10-23 10:07:00', '2025-10-22 10:07:00', 'validated'),
(109, '2025-10-23', 'org-signature-109.png', '2025-10-23 11:00:00', '2025-10-22 11:00:00', 'validated'),
(110, '2025-10-23', 'org-signature-110.png', '2025-10-23 11:01:00', '2025-10-22 11:01:00', 'validated'),
(111, '2025-10-23', 'org-signature-111.png', '2025-10-23 11:02:00', '2025-10-22 11:02:00', 'pending'),
(112, '2025-10-23', 'org-signature-112.png', '2025-10-23 11:03:00', '2025-10-22 11:03:00', 'pending'),
(113, '2025-10-23', 'org-signature-113.png', '2025-10-23 11:04:00', '2025-10-22 11:04:00', 'pending'),
(114, '2025-10-23', 'org-signature-114.png', '2025-10-23 11:05:00', '2025-10-22 11:05:00', 'invalidated'),
(115, '2025-10-23', 'org-signature-115.png', '2025-10-23 11:06:00', '2025-10-22 11:06:00', 'validated'),
(116, '2025-10-23', 'org-signature-116.png', '2025-10-23 11:07:00', '2025-10-22 11:07:00', 'validated'),
(117, '2025-10-23', 'org-signature-117.png', '2025-10-23 11:08:00', '2025-10-22 11:08:00', 'pending'),
(118, '2025-10-23', 'org-signature-118.png', '2025-10-23 11:09:00', '2025-10-22 11:09:00', 'validated'),
(119, '2025-10-23', 'org-signature-119.png', '2025-10-23 11:10:00', '2025-10-22 11:10:00', 'validated'),
(120, '2025-10-23', 'org-signature-120.png', '2025-10-23 11:11:00', '2025-10-22 11:11:00', 'validated'),
(121, '2025-10-23', 'org-signature-121.png', '2025-10-23 11:12:00', '2025-10-22 11:12:00', 'validated'),
(122, '2025-10-23', 'org-signature-122.png', '2025-10-23 11:13:00', '2025-10-22 11:13:00', 'validated'),
(123, '2025-10-23', 'org-signature-123.png', '2025-10-23 11:14:00', '2025-10-22 11:14:00', 'validated');


INSERT INTO `info_form` (`id`, `intern_member_id`, `info_form_intern_id`, `info_form_organization_id`, `info_form_company_id`, `organization_id`, `training_session_id`, `status`, `updated_at`, `created_at`) VALUES
(101,   101,    101,    101,    101,    1,  1,  'fully_completed',  '2025-10-22 10:00:00',  '2025-10-22 09:00:00'),
(102,   103,    102,    102,    102,    1,  1,  'fully_completed',  '2025-10-22 10:01:00',  '2025-10-22 09:01:00'),
(103,   104,    103,    103,    103,    1,  1,  'completed_organization',   '2025-10-22 10:02:00',  '2025-10-22 09:02:00'),
(104,   105,    104,    104,    104,    1,  1,  'completed_company',    '2025-10-22 10:03:00',  '2025-10-22 09:03:00'),
(105,   111,    105,    105,    105,    1,  1,  'completed_intern', '2025-10-22 10:04:00',  '2025-10-22 09:04:00'),
(106,   114,    106,    106,    106,    1,  1,  'completed_company',    '2025-10-22 10:05:00',  '2025-10-22 09:05:00'),
(107,   102,    107,    107,    107,    1,  1,  'rejected', '2025-10-22 10:06:00',  '2025-10-22 09:06:00'),
(108,   101,    108,    108,    108,    1,  1,  'fully_completed',  '2025-10-22 10:07:00',  '2025-10-22 09:07:00'),
(109,   106,    117,    117,    117,    2,  2,  'fully_completed',  '2025-10-22 11:00:00',  '2025-10-22 10:00:00'),
(110,   107,    118,    118,    118,    2,  2,  'completed_organization',   '2025-10-22 11:01:00',  '2025-10-22 10:01:00'),
(111,   108,    113,    113,    113,    2,  2,  'completed_company',    '2025-10-22 11:02:00',  '2025-10-22 10:02:00'),
(112,   109,    115,    115,    115,    2,  2,  'completed_intern', '2025-10-22 11:03:00',  '2025-10-22 10:03:00'),
(113,   112,    114,    114,    114,    2,  2,  'completed_intern', '2025-10-22 11:04:00',  '2025-10-22 10:04:00'),
(114,   113,    119,    119,    119,    2,  2,  'rejected', '2025-10-22 11:05:00',  '2025-10-22 10:05:00'),
(115,   115,    120,    120,    120,    2,  2,  'fully_completed',  '2025-10-22 11:06:00',  '2025-10-22 10:06:00'),
(116,   116,    121,    121,    121,    2,  2,  'completed_organization',   '2025-10-22 11:07:00',  '2025-10-22 10:07:00'),
(117,   117,    122,    122,    122,    2,  2,  'completed_company',    '2025-10-22 11:08:00',  '2025-10-22 10:08:00'),
(118,   118,    123,    123,    123,    2,  2,  'fully_completed',  '2025-10-22 11:09:00',  '2025-10-22 11:09:00');

INSERT INTO `company_member_info_form` (`company_member_id`, `info_form_id`) VALUES
(6, 101),
(5, 102),
(3, 103),
(4, 104),
(4, 105),
(6, 106),
(10, 107),
(11, 108),
(12, 109),
(6, 110),
(5, 111),
(5, 112),
(3, 113),
(4, 114),
(4, 115),
(10, 116),
(11, 117),
(12, 118);


INSERT INTO `user_notification` (`id`, `user_id`, `is_read`, `is_signed`, `updated_at`, `created_at`, `title`, `content`,) VALUES
(1,	1,	0,	0,	'2025-10-22 08:00:00',	'2025-10-22 08:00:00', 'Titre 1', 'Content 1'),
(2,	1,	1,	1,	'2025-10-22 10:15:00',	'2025-10-22 10:15:00', 'Titre 2', 'Content 2'),
(3,	1,	1,	1,	'2025-10-20 17:00:00',	'2025-10-20 17:00:00', 'Titre 3', 'Content 3'),
(4,	2,	0,	0,	'2025-10-22 08:00:00',	'2025-10-22 08:00:00', 'Titre 1', 'Content 4'),
(5,	2,	0,	0,	'2025-10-22 09:30:00',	'2025-10-22 09:30:00', 'Titre 1', 'Content 5'),
(6,	2,	1,	0,	'2025-10-21 10:00:00',	'2025-10-21 10:00:00', 'Titre 1', 'Content 6'),
(7,	3,	1,	1,	'2025-10-22 08:00:00',	'2025-10-22 08:00:00', 'Titre 2', 'Content 1'),
(8,	3,	0,	0,	'2025-10-22 09:30:00',	'2025-10-22 09:30:00', 'Titre 3', 'Content 1'),
(9,	3,	1,	1,	'2025-10-22 10:15:00',	'2025-10-22 10:15:00', 'Titre 1', 'Content 7'),
(10, 4,	0,	0,	'2025-10-22 08:00:00',	'2025-10-22 08:00:00', 'Titre 1', 'Content 8'),
(11, 4,	0,	0,	'2025-10-22 11:00:00',	'2025-10-22 11:00:00', 'Titre 1', 'Content 9'),
(12, 4,	0,	0,	'2025-10-21 10:00:00',	'2025-10-21 10:00:00', 'Titre 1', 'Content 10'),
(13, 5,	1,	0,	'2025-10-22 14:00:00',	'2025-10-22 14:00:00', 'Titre 1', 'Content 11'),
(14, 6,	1,	1,	'2025-10-20 17:00:00',	'2025-10-20 17:00:00', 'Titre 2', 'Content 11'),
(15, 6,	0,	0,	'2025-10-22 18:00:00',	'2025-10-22 18:00:00', 'Titre 3', 'Content 11'),
(16, 7,	0,	0,	'2025-10-22 14:00:00',	'2025-10-22 14:00:00', 'Titre 1', 'Content 12'),
(17, 7,	1,	0,	'2025-10-22 16:30:00',	'2025-10-22 16:30:00', 'Titre 1', 'Content 13'),
(18, 8,	0,	0,	'2025-10-22 14:00:00',	'2025-10-22 14:00:00', 'Titre 1', 'Content 14'),
(19, 8,	0,	0,	'2025-10-22 16:30:00',	'2025-10-22 16:30:00', 'Titre 1', 'Content 15'),
(20, 8,	1,	1,	'2025-10-21 15:45:00',	'2025-10-21 15:45:00', 'Titre 1', 'Content 16'),
(21, 9,	1,	0,	'2025-10-22 14:00:00',	'2025-10-22 14:00:00', 'Titre 1', 'Content 17'),
(22, 10, 0,	0,	'2025-10-22 14:00:00',	'2025-10-22 14:00:00', 'Titre 1', 'Content 18'),
(23, 10, 1,	1,	'2025-10-21 15:45:00',	'2025-10-21 15:45:00', 'Titre 1', 'Content 19'),
(24, 18, 1,	1,	'2025-10-22 09:30:00',	'2025-10-22 09:30:00', 'Titre 1', 'Content 21'),
(25, 19, 0,	0,	'2025-10-22 09:30:00',	'2025-10-22 09:30:00', 'Titre 1', 'Content 221'),
(26, 20, 1,	0,	'2025-10-22 09:30:00',	'2025-10-22 09:30:00', 'Titre 1', 'Content 211'),
(27, 21, 0,	0,	'2025-10-22 18:00:00',	'2025-10-22 18:00:00', 'Titre 1', 'Content 241'),
(28, 23, 0,	0,	'2025-10-22 11:00:00',	'2025-10-22 11:00:00', 'Titre 1', 'Content 2551');
