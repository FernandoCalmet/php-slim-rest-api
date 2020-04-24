-- ----------------------------
-- Table structure for `modules`
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL DEFAULT '1',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of `modules`
-- ----------------------------
INSERT INTO `modules` (`name`, `description`) VALUES
('Modules', 'It contains the information of all the modules of the system.'),
('Operations', 'It contains the information of all the user operations of the system.'),
('Profiles', 'It contains the information of all the user profiles of the system.');

-- ----------------------------
-- Table structure for `operations`
-- ----------------------------
DROP TABLE IF EXISTS `operations`;
CREATE TABLE IF NOT EXISTS `operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL DEFAULT '2',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of `operations`
-- ----------------------------
INSERT INTO `operations` (`name`, `description`) VALUES
('Get All Modules', 'Operation for Modules'),
('Get One Module', 'Operation for Modules'),
('Search Module', 'Operation for Modules'),
('Create Module', 'Operation for Modules'),
('Update Module', 'Operation for Modules'),
('Delete Module', 'Operation for Modules'),
('Get All Operations', 'Operation for Operations'),
('Get One Operation', 'Operation for Operations'),
('Search Operation', 'Operation for Operations'),
('Create Operation', 'Operation for Operations'),
('Update Operation', 'Operation for Operations'),
('Delete Operation', 'Operation for Operations'),
('Get All Permissions', 'Operation for Permissions'),
('Get One Permission', 'Operation for Permissions'),
('Search Permission', 'Operation for Permissions'),
('Create Permission', 'Operation for Permissions'),
('Update Permission', 'Operation for Permissions'),
('Delete Permission', 'Operation for Permissions'),
('Get All Roles', 'Operation for Roles'),
('Get One Role', 'Operation for Roles'),
('Search Role', 'Operation for Roles'),
('Create Role', 'Operation for Roles'),
('Update Role', 'Operation for Roles'),
('Delete Role', 'Operation for Roles'),
('Get All Users', 'Operation for Users'),
('Get One User', 'Operation for Users'),
('Search User', 'Operation for Users'),
('Create User', 'Operation for Users'),
('Update User', 'Operation for Users'),
('Delete User', 'Operation for Users'),
('Get All Profiles', 'Operation for Profiles'),
('Get One Profile', 'Operation for Profiles'),
('Search Profile', 'Operation for Profiles'),
('Create Profile', 'Operation for Profiles'),
('Update Profile', 'Operation for Profiles'),
('Delete Profile', 'Operation for Profiles');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of `roles`
-- ----------------------------
INSERT INTO `roles` (`name`, `description`) VALUES
('Administrator', 'This role has all the privileges of the system.'),
('Customer', 'This role has limited privileges on the system.');

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of `permissions`
-- ----------------------------
INSERT INTO `permissions` (`role_id`, `operation_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 36);

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '2',
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('female','male','other') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `status` enum('actived','blocked') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'actived',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of `users`
-- ----------------------------
INSERT INTO `users` (`email`, `password`, `first_name`, `last_name`, `gender`, `birthday`) VALUES
('fercalmet@gmail.com', 'd5f4da62059760b35de35f8fbd8efb43eee26ac741ef8c6e51782a13ac7d50e927b653160c591616a9dc8a452c877a6b80c00aecba14504756a65f88439fcd1e', 'Fernando', 'Calmet', 'Male', '1989-01-01');

-- ----------------------------
-- Table structure for `profiles`
-- ----------------------------
DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL DEFAULT '3',
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `biography` varchar(250) COLLATE utf8_unicode_ci NULL,
  `status` enum('actived','blocked') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'actived',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of `profiles`
-- ----------------------------
INSERT INTO `profiles` (`user_id`, `biography`) VALUES
(1, 'Self-learning software engineering through research & development.');
