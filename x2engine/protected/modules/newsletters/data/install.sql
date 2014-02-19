DROP TABLE IF EXISTS `x2_newsletters`;

CREATE TABLE `x2_newsletters` (
    id              INT             NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100)    NOT NULL,
    subject         VARCHAR(255)    NOT NULL,
    type            TINYINT         NOT NULL,
    body            LONGTEXT        NOT NULL,
    updatedBy       VARCHAR(50)     NOT NULL,
    dateUpdated     BIGINT          NOT NULL,
    published       TINYINT         NOT NULL,
    datePublished   BIGINT
) COLLATE = utf8_general_ci;

INSERT INTO `x2_modules`
            (`name`,        title,          visible,    menuPosition,   searchable, editable,   adminOnly,  custom, toggleable)
    VALUES  ("newsletters", "Newsletters",  1,          1,              0,          0,          0,          0,      0);

INSERT INTO `x2_fields` (`modelName`, `fieldName`, `attributeLabel`, `modified`, `custom`, `type`, `required`, `readOnly`, `linkType`, `searchable`, `relevance`, `isVirtual`)
VALUES
('Newsletters','id','ID',0,0,'int',0,1,NULL,0,NULL,0),
('Newsletters','name','Name',0,0,'varchar',1,0,NULL,0,NULL,0),
('Newsletters','subject','Subject',0,0,'varchar',0,0,NULL,0,NULL,0),
('Newsletters','type','Type',0,0,'int',0,0,NULL,0,NULL,0),
('Newsletters','body','Body',0,0,'text',1,0,NULL,0,NULL,0),
('Newsletters','updatedBy','Updated By',0,0,'link',0,0,'User',0,NULL,0),
('Newsletters','dateUpdated','Updated Date',0,0,'date',0,0,NULL,0,NULL,0),
('Newsletters','published','Published',0,0,'boolean',0,0,NULL,0,NULL,0),
('Newsletters','datePublished','Published Date',0,0,'date',0,0,NULL,0,NULL,0);
