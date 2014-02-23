--
-- Make x2_docs InnoDB for Foreign Keys.
--
ALTER TABLE `x2_docs` ENGINE = InnoDB;

DROP TABLE IF EXISTS `docs_revisions`;
CREATE TABLE IF NOT EXISTS `docs_revisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `text` longtext NOT NULL,
  `createDate` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `rev_id` (`doc_id`,`user_id`,`createDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=284 ;

ALTER TABLE `docs_revisions`
  ADD CONSTRAINT `docs_revisions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `x2_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `docs_revisions_ibfk_2` FOREIGN KEY (`doc_id`) REFERENCES `x2_docs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
