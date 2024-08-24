ALTER TABLE `dg_webs`
MODIFY COLUMN `price_dx` varchar(50) NOT NULL DEFAULT '0.8|0.6|0.5|0.4|0.3|0.1',
MODIFY COLUMN `price_all` varchar(50) NOT NULL DEFAULT '3|2|1.8|1.5|1|0.8',
ADD COLUMN `price_vip` varchar(50) NOT NULL DEFAULT '3|5|10|15|22';

ALTER TABLE `dg_users`
ADD COLUMN `pay_account` varchar(50) DEFAULT NULL,
ADD COLUMN `pay_name` varchar(50) DEFAULT NULL;

DROP TABLE IF EXISTS `dg_tixian`;
CREATE TABLE `dg_tixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `money` varchar(32) NOT NULL,
  `realmoney` varchar(32) NOT NULL,
  `pay_account` varchar(50) NOT NULL,
  `pay_name` varchar(50) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;