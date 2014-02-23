SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `chatroom_invite` (
  `id` int(10) not null auto_increment primary key,
  `chatroom_id` varchar(30) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `poster_id` int(10) unsigned NOT NULL,
  KEY `poster_id` (`poster_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
alter table `chatroom_invite` add unique index (`chatroom_id`, `user_id`);

--
-- Change x2_users to InnoDB
--
ALTER TABLE `x2_users` ENGINE = InnoDB;

INSERT INTO `x2_modules`
			(`name`,			title,			visible, 	menuPosition,	searchable,	editable,	adminOnly,	custom,	toggleable)
	VALUES	("chat",	"Chat",		1,			18,				1,			1,			0,			0,		0);
--
-- Constraints for table `chatroom_invite`
--
ALTER TABLE `chatroom_invite`
  ADD CONSTRAINT `chatroom_invite_ibfk_2` FOREIGN KEY (`poster_id`) REFERENCES `x2_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chatroom_invite_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `x2_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `x2_auth_item` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('ChatIndex',0,'',NULL,'N;'),
('ChatJoin',0,'',NULL,'N;'),
('ChatInvite',0,'',NULL,'N;');

INSERT INTO `x2_auth_item_child` (`parent`,`child`) VALUES
('AuthenticatedSiteFunctionsTask', 'ChatIndex');
INSERT INTO `x2_auth_item_child` (`parent`,`child`) VALUES
('AuthenticatedSiteFunctionsTask', 'ChatJoin');
INSERT INTO `x2_auth_item_child` (`parent`,`child`) VALUES
('AuthenticatedSiteFunctionsTask', 'ChatInvite');

-- Remove old auth_cache entries
DELETE FROM `x2_auth_cache` WHERE `authItem` LIKE '%chat%';
