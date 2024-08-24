ALTER TABLE `dg_users`
ADD COLUMN `coin`  decimal(10,2) NOT NULL AFTER `invitetime`;
DROP TABLE IF EXISTS `dg_hongbaos`;
CREATE TABLE `dg_hongbaos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `point` varchar(255) NOT NULL,
  `hbdate` date NOT NULL,
  `lqtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `dg_qiandaos`;
CREATE TABLE `dg_qiandaos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0',
  `qdtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
ALTER TABLE `dg_webs`
ADD COLUMN `super`  tinyint(2) NOT NULL DEFAULT 0 AFTER `endtime`;
