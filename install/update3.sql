DROP TABLE IF EXISTS `dg_pay`;
CREATE TABLE `dg_pay` (
`trade_no` varchar(64) NOT NULL,
`type` varchar(20) NULL,
`uid` int(11) NOT NULL DEFAULT '0',
`time` datetime NULL,
`name` varchar(64) NULL,
`money` varchar(32) NULL,
`status` int(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`trade_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;