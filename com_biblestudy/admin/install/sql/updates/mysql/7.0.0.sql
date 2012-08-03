ALTER Table `#__bsms_studies` MODIFY `show_level` varchar(100) NOT NULL DEFAULT '0';
ALTER TABLE #__bsms_studies MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
ADD COLUMN `asset_id` INT(10) DEFAULT NULL,
ADD COLUMN `access` INT(10) DEFAULT NULL;
UPDATE #__bsms_studies SET `access` = '1' WHERE `show_level` = '0';
UPDATE #__bsms_studies SET `access` = '2' WHERE `show_level` = '18';
UPDATE #__bsms_studies SET `access` = '2' WHERE `show_level` = '19';
UPDATE #__bsms_studies SET `access` = '2' WHERE `show_level` = '20';
UPDATE #__bsms_studies SET `access` = '3' WHERE `show_level` = '22';
UPDATE #__bsms_studies SET `access` = '3' WHERE `show_level` = '23';
UPDATE #__bsms_studies SET `access` = '3' WHERE `show_level` = '24';

ALTER Table `#__bsms_studytopics` MODIFY id int(3) NOT NULL AUTO_INCREMENT,
ADD COLUMN `asset_id` INT(10) DEFAULT NULL,
ADD COLUMN `access` INT(10) DEFAULT NULL;

ALTER TABLE #__bsms_teachers MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
ADD COLUMN `asset_id` INT(10) DEFAULT NULL,
ADD COLUMN `access` INT(10) DEFAULT NULL;

ALTER Table `#__bsms_templates` MODIFY id int(3) NOT NULL AUTO_INCREMENT,
ADD COLUMN `asset_id` INT(10) DEFAULT NULL,
ADD COLUMN `access` INT(10) DEFAULT NULL;

DROP TABLE #__bsms_timeset;
CREATE TABLE IF NOT EXISTS `#__bsms_timeset` (
                    `timeset` VARCHAR(14) NOT NULL DEFAULT '',
                    `backup` VARCHAR(14) DEFAULT NULL,
                    PRIMARY KEY `timeset` (`timeset`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `#__bsms_timeset` SET `timeset`='1281646339', `backup` = '1281646339';

ALTER TABLE #__bsms_topics ADD COLUMN `params` varchar(511) DEFAULT NULL;

ALTER TABLE #__bsms_topics MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
ADD COLUMN `asset_id` INT(10) DEFAULT NULL,
ADD COLUMN `access` INT(10) DEFAULT NULL;

ALTER Table `#__bsms_version` MODIFY id int(3) NOT NULL AUTO_INCREMENT,
ADD COLUMN `asset_id` INT(10) DEFAULT NULL,
ADD COLUMN `access` INT(10) DEFAULT NULL;
INSERT INTO #__bsms_version SET `version` = '7.0.0', `installdate`='2011-06-19', `build`='700', `versionname`='1Kings', `versiondate`='2011-03-15';

ALTER TABLE #__bsms_locations MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
ADD COLUMN `asset_id` INT(10) DEFAULT NULL,
ADD COLUMN `access` INT(10) DEFAULT NULL;
