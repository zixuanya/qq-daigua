ALTER TABLE `dg_webs`
MODIFY COLUMN `price_dx` decimal(10,2) NOT NULL DEFAULT '0.5',
MODIFY COLUMN `price_all` decimal(10,2) NOT NULL DEFAULT '2',
ADD COLUMN `price_ktfz` decimal(10,2) NOT NULL DEFAULT '30';

ALTER TABLE `dg_qqs`
ADD COLUMN `superkey` varchar(255) DEFAULT NULL;

INSERT INTO `dg_configs` VALUES ('invite_rate', '10');
INSERT INTO `dg_configs` VALUES ('ktfz_rate', '10');
INSERT INTO `dg_configs` VALUES ('daili_rate', '90');

DROP TABLE IF EXISTS `dg_apis`;
CREATE TABLE `dg_apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `apikey` varchar(64) DEFAULT NULL,
  `active` tinyint(2) NOT NULL DEFAULT '1',
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;