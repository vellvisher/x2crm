DROP TABLE IF EXISTS `x2_chatroom`;
/*&*/
CREATE TABLE x2_chatroom(
	id						INT				UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name					VARCHAR(255)	NOT NULL,
	members					VARCHAR(255)
) COLLATE = utf8_general_ci;
/*&*/
INSERT INTO `x2_modules`
			(`name`,			title,			visible, 	menuPosition,	searchable,	editable,	adminOnly,	custom,	toggleable)
	VALUES	("videoChat",	"Video Chat",		1,			17,				1,			1,			0,			0,		0);
/*&*/
INSERT INTO x2_fields
(modelName,			fieldName,				attributeLabel,	 modified,	custom,	type,		required,	readOnly,  linkType,   searchable,	isVirtual,	relevance)
VALUES
("ChatRoom",		"id",					"ID",					0,		0,	"varchar",		0,			0,		NULL,			0,		0,			""),
("ChatRoom",		"name",					"Name",					0,		0,	"varchar",		1,			0,		NULL,			1,		0,			"High"),
("ChatRoom",		"members",				"Members",				0,		0,	"varchar",		0,			1,		NULL,			0,		0,			"");