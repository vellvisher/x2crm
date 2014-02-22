--
-- Database: `x2engine`
--

-- --------------------------------------------------------

--
-- Table structure for table `editor_files`
--

-- CREATE TABLE IF NOT EXISTS `editor_files` (
--   `id` varchar(30) NOT NULL,
--   `file_id` varchar(30) NOT NULL,
--   `user_id` int(10) unsigned NOT NULL,
--   `owner_id` int(10) unsigned NOT NULL,
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `x2_modules`
			(`name`,			title,			visible, 	menuPosition,	searchable,	editable,	adminOnly,	custom,	toggleable)
	VALUES	("editor",	"Editor",		1,			19,				1,			1,			0,			0,		0);

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
