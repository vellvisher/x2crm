DROP TABLE IF EXISTS `x2_advertise`;

CREATE TABLE `x2_advertise` (
    id              INT             NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100)    NOT NULL,
    email           VARCHAR(100)    NOT NULL,
    phone           VARCHAR(30)     NOT NULL,
    address         VARCHAR(255)    NOT NULL,
    budget          TINYINT         NOT NULL,
    url             VARCHAR(255)    NOT NULL,
    user            VARCHAR(50)     NOT NULL
) COLLATE = utf8_general_ci;

INSERT INTO `x2_modules`
            (`name`,        title,      visible,    menuPosition,   searchable, editable,   adminOnly,  custom, toggleable)
    VALUES  ("advertise", "Advertise",  1,          4,              0,          0,          0,          0,      0);

INSERT INTO `x2_fields` (`modelName`, `fieldName`, `attributeLabel`, `modified`, `custom`, `type`, `required`, `readOnly`, `linkType`, `searchable`, `relevance`, `isVirtual`)
VALUES
('Advertise','id','ID',0,0,'int',0,1,NULL,0,NULL,0),
('Advertise','name','Name',0,0,'varchar',1,0,NULL,0,NULL,0),
('Advertise','email','Email Address',0,0,'varchar',0,0,NULL,0,NULL,0),
('Advertise','phone','Phone Number',0,0,'varchar',0,0,NULL,0,NULL,0),
('Advertise','address','Address',0,0,'varchar',0,0,NULL,0,NULL,0),
('Advertise','budget','Budget',0,0,'int',0,0,NULL,0,NULL,0),
('Advertise','url','URL',0,0,'varchar',0,0,NULL,0,NULL,0),
('Advertise','user','User',0,0,'varchar',0,0,NULL,0,NULL,0);