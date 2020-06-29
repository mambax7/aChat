#
# Table structure for table `achat_messages`
#

CREATE TABLE `achat_messages` (
    `mid`   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uid`   INT(5) UNSIGNED          DEFAULT '0' NOT NULL,
    `uname` VARCHAR(60)              DEFAULT '',
    `msg`   VARCHAR(255)    NOT NULL,
    `color` VARCHAR(6)      NOT NULL DEFAULT '000000',
    `date`  INT(11)         NOT NULL DEFAULT '0',
    `ip`    VARCHAR(45)              DEFAULT '0.0.0.0' NOT NULL,
    PRIMARY KEY (`mid`),
    KEY `uid` (uid),
    KEY `ip` (ip),
    KEY `date` (date)
)
    ENGINE = MyISAM;
