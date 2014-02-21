--
-- Database: `x2engine`
--

-- --------------------------------------------------------

--
-- Table structure for table `editorroom_invite`
--

CREATE TABLE IF NOT EXISTS `editor_files` (
  `file_id` varchar(30) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `poster_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`editorroom_id`,`user_id`),
  KEY `poster_id` (`poster_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `x2_modules`
			(`name`,			title,			visible, 	menuPosition,	searchable,	editable,	adminOnly,	custom,	toggleable)
	VALUES	("editor",	"Editor",		1,			19,				1,			1,			0,			0,		0);
--
-- Constraints for table `editorroom_invite`
--
ALTER TABLE `editorroom_invite`
  ADD CONSTRAINT `editorroom_invite_ibfk_2` FOREIGN KEY (`poster_id`) REFERENCES `x2_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `editorroom_invite_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `x2_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `x2_auth_item` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('EditorIndex',0,'',NULL,'N;'),
('EditorJoin',0,'',NULL,'N;'),
('EditorInvite',0,'',NULL,'N;');

INSERT INTO `x2_auth_item_child` (`parent`,`child`) VALUES
('AuthenticatedSiteFunctionsTask', 'EditorIndex');
INSERT INTO `x2_auth_item_child` (`parent`,`child`) VALUES
('AuthenticatedSiteFunctionsTask', 'EditorJoin');
INSERT INTO `x2_auth_item_child` (`parent`,`child`) VALUES
('AuthenticatedSiteFunctionsTask', 'EditorInvite');

-- Remove old auth_cache entries
DELETE FROM `x2_auth_cache` WHERE `authItem` LIKE '%editor%';
