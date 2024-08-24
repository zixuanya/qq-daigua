-- MySQL dump 10.13  Distrib 5.6.46, for Linux (x86_64)
--
-- Host: localhost    Database: s0570369
-- ------------------------------------------------------
-- Server version	5.6.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dg_apis`
--

DROP TABLE IF EXISTS `dg_apis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `apikey` varchar(64) DEFAULT NULL,
  `active` tinyint(2) NOT NULL DEFAULT '1',
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_apis`
--

LOCK TABLES `dg_apis` WRITE;
/*!40000 ALTER TABLE `dg_apis` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_apis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_chats`
--

DROP TABLE IF EXISTS `dg_chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_chats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zid` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_chats`
--

LOCK TABLES `dg_chats` WRITE;
/*!40000 ALTER TABLE `dg_chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_configs`
--

DROP TABLE IF EXISTS `dg_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_configs` (
  `vkey` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`vkey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_configs`
--

LOCK TABLES `dg_configs` WRITE;
/*!40000 ALTER TABLE `dg_configs` DISABLE KEYS */;
INSERT INTO `dg_configs` VALUES ('price_dx','0.2'),('price_all','0.5'),('price_dx2','0.1'),('price_all2','0.4'),('tc_rate','0.1'),('point_invite1','1'),('point_invite2','0'),('domain','sejima.com.cn'),('domains','qswl.name,qqshabi.cn'),('price_ktfz','30'),('price_ktfz_super','100'),('ktfz_rate','10'),('qiandao_num','50'),('qiandao_rule','1:0.2,3:0.4,5:0.6'),('qq','444586924'),('gg_admin',''),('daili_rate','90'),('invite_rate','10'),('email_host','smtp.qq.com'),('email_port','465'),('email_user','444586924@qq.com'),('email_pwd',''),('apiurl','http://pay.yw52.cn/'),('syskey','9222i9U8x885GGIIOfj2zf1ujuKOegoX'),('alipay_api','2'),('alipay_pid',''),('alipay_key',''),('alipay2_api','0'),('tenpay_api','2'),('tenpay_pid',''),('tenpay_key',''),('qqpay_api','2'),('wxpay_api','2'),('epay_pid',''),('epay_key',''),('chose','0'),('zqq',''),('musicoff','0'),('nmusicoff','0'),('musickey',''),('login_api',''),('addqq_mode','0'),('cronkey',''),('getway_api','0'),('price_sfz',''),('price_all3',''),('price_all4',''),('price_dx3',''),('price_dx4',''),('price_ktfz_sec',''),('price_ktfz_sup',''),('price_ktfz_cp',''),('price_ktfz_da',''),('tixian_rate',''),('tixian_min',''),('qttcoff','1'),('tcoff','1'),('qttc','裕网云支付:pay.yw52.cn三网支付接口正常\r\n货源商城sejima.com.cn'),('fztc','	<style>\r\n    #nr{\r\n    	font-size:20px;\r\n    	margin: 0;\r\n        background: -webkit-linear-gradient(left,\r\n            #ffffff,\r\n            #ff0000 6.25%,\r\n            #ff7d00 12.5%,\r\n            #ffff00 18.75%,\r\n            #00ff00 25%,\r\n            #00ffff 31.25%,\r\n            #0000ff 37.5%,\r\n            #ff00ff 43.75%,\r\n            #ffff00 50%,\r\n            #ff0000 56.25%,\r\n            #ff7d00 62.5%,\r\n            #ffff00 68.75%,\r\n            #00ff00 75%,\r\n            #00ffff 81.25%,\r\n            #0000ff 87.5%,\r\n            #ff00ff 93.75%,\r\n            #ffff00 100%);\r\n        -webkit-background-clip: text;\r\n        -webkit-text-fill-color: transparent;\r\n        background-size: 200% 100%;\r\n        animation: masked-animation 2s infinite linear;\r\n    }\r\n    @keyframes masked-animation {\r\n        0% {\r\n            background-position: 0 0;\r\n        }\r\n        100% {\r\n            background-position: -100%, 0;\r\n        }\r\n    }\r\n</style>\r\n	<div style=\"background-color:#333;border-radius:25px;box-shadow:0px 0px 5px #f200ff;padding:5px;margin-top:10px;margin-bottom:0px;\">\r\n		<marquee>\r\n    	<b id=\"nr\">欢迎进入本系统下方信誉推荐站点</b> </marquee>\r\n	</div>\r\n<a class=\"adplan\" data-id=\"15\" style=\"display:block;width:100%;margin-bottom:0px;\" rel=\"nofollow\" target=\"_blank\" href=\"http://pay.yw52.cn\r\n\" title=\"广告联系q：444586924|过期时间：9.30\"> <img src=\"https://pay.yw52.cn/zfjkgg.gif\" style=\"max-height:70px;width:100%;border-radius:40px;\" width=\"644\" height=\"70\" title=\"\" align=\"\" alt=\"\" /></a>\r\n\r\n\r\n			\r\n			<style>\r\n.txtguanggao{width: 100%;overflow: hidden;display: block;box-shadow: 0 1px 2px 0 rgba(0,0,0,.05);}.txtguanggao a{width: 24.5%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}.txtguanggao a:nth-child(1) {background-color: #dc3545;}.txtguanggao a:nth-child(2) {background-color: #007bff;}.txtguanggao a:nth-child(3) {background-color: #28a745;}.txtguanggao a:nth-child(4) {background-color: #ffc107;}.txtguanggao a:nth-child(5) {background-color: #28a745;}.txtguanggao a:nth-child(6) {background-color: #ffc107;}.txtguanggao a:nth-child(7) {background-color: #dc3545;}.txtguanggao a:nth-child(8){background-color: #007bff;}.txtguanggao a:hover{background:#FF2805;color:#FFF}@media screen and (max-width: 1000px) {.txtguanggao a{width: 47.96%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}}\r\n  </style>\r\n	<div class=\"txtguanggao\">\r\n		<a href=\"http://sejima.com.cn/\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">货源云商城</a>\r\n		<a href=\"https://web.by52eg.com/history?lang=zh\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">流量卡3/张</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">裕网云支付</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">支付宝微信正常支付</a> \r\n	</div>\r\n</div>');
/*!40000 ALTER TABLE `dg_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_dgkms`
--

DROP TABLE IF EXISTS `dg_dgkms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_dgkms` (
  `kid` int(11) NOT NULL AUTO_INCREMENT,
  `zid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `km` varchar(255) NOT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
  `addtime` timestamp NULL DEFAULT NULL,
  `user` varchar(20) NOT NULL DEFAULT '0',
  `usetime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_dgkms`
--

LOCK TABLES `dg_dgkms` WRITE;
/*!40000 ALTER TABLE `dg_dgkms` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_dgkms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_hongbaos`
--

DROP TABLE IF EXISTS `dg_hongbaos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_hongbaos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `point` varchar(255) NOT NULL,
  `hbdate` date NOT NULL,
  `lqtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_hongbaos`
--

LOCK TABLES `dg_hongbaos` WRITE;
/*!40000 ALTER TABLE `dg_hongbaos` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_hongbaos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_kms`
--

DROP TABLE IF EXISTS `dg_kms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_kms` (
  `kid` int(11) NOT NULL AUTO_INCREMENT,
  `zid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `km` varchar(255) NOT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
  `addtime` timestamp NULL DEFAULT NULL,
  `useid` int(11) NOT NULL DEFAULT '0',
  `usetime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_kms`
--

LOCK TABLES `dg_kms` WRITE;
/*!40000 ALTER TABLE `dg_kms` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_kms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_orders`
--

DROP TABLE IF EXISTS `dg_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `zt` tinyint(2) NOT NULL DEFAULT '0',
  `endtime` datetime NOT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_orders`
--

LOCK TABLES `dg_orders` WRITE;
/*!40000 ALTER TABLE `dg_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_pay`
--

DROP TABLE IF EXISTS `dg_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_pay` (
  `trade_no` varchar(64) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `time` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` varchar(32) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trade_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_pay`
--

LOCK TABLES `dg_pay` WRITE;
/*!40000 ALTER TABLE `dg_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_points`
--

DROP TABLE IF EXISTS `dg_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `action` varchar(255) NOT NULL,
  `point` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bz` varchar(1024) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_points`
--

LOCK TABLES `dg_points` WRITE;
/*!40000 ALTER TABLE `dg_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_qiandaos`
--

DROP TABLE IF EXISTS `dg_qiandaos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_qiandaos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0',
  `qdtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_qiandaos`
--

LOCK TABLES `dg_qiandaos` WRITE;
/*!40000 ALTER TABLE `dg_qiandaos` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_qiandaos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_qqs`
--

DROP TABLE IF EXISTS `dg_qqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_qqs` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `uin` varchar(12) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `skey` varchar(255) NOT NULL,
  `p_skey` varchar(255) NOT NULL,
  `superkey` varchar(255) DEFAULT NULL,
  `zt` tinyint(2) NOT NULL DEFAULT '0',
  `cookiezt` tinyint(2) NOT NULL DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `id` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_qqs`
--

LOCK TABLES `dg_qqs` WRITE;
/*!40000 ALTER TABLE `dg_qqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_qqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_tixian`
--

DROP TABLE IF EXISTS `dg_tixian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_tixian`
--

LOCK TABLES `dg_tixian` WRITE;
/*!40000 ALTER TABLE `dg_tixian` DISABLE KEYS */;
/*!40000 ALTER TABLE `dg_tixian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_tools`
--

DROP TABLE IF EXISTS `dg_tools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_tools` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_tools`
--

LOCK TABLES `dg_tools` WRITE;
/*!40000 ALTER TABLE `dg_tools` DISABLE KEYS */;
INSERT INTO `dg_tools` VALUES (1,'全套代挂',0.00),(2,'电脑在线',0.00),(3,'手机在线',0.00),(4,'苹果在线',0.00),(5,'电脑管家',0.00),(6,'音乐加速',0.00),(7,'手游加速',0.00),(8,'勋章加速',0.00),(9,'微视加速',0.00),(10,'访客加速',0.00),(11,'微视浏览',0.00),(12,'云任务代领',0.00),(13,'qq财付通协议防冻结登录挂常用',0.00),(14,'QQ游戏角色查询【所有游戏】',0.00),(15,'qq游戏封号查询【所有游戏】',0.00),(16,'qq资料查询QQ最全信息查询',0.00),(17,'qq空间清空删除【清空所有】',0.00),(18,'巅峰批量领取【更全】',0.00);
/*!40000 ALTER TABLE `dg_tools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_users`
--

DROP TABLE IF EXISTS `dg_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `zid` int(11) NOT NULL,
  `upid` int(11) NOT NULL DEFAULT '0',
  `user` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `sid` varchar(50) DEFAULT NULL,
  `peie` int(11) NOT NULL DEFAULT '0',
  `coin` decimal(10,2) NOT NULL DEFAULT '0.00',
  `point` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rmb` decimal(10,2) NOT NULL DEFAULT '0.00',
  `power` int(11) NOT NULL DEFAULT '0',
  `daili` int(11) NOT NULL DEFAULT '0',
  `qq` varchar(255) NOT NULL,
  `isemail` varchar(255) DEFAULT NULL,
  `invite` varchar(255) DEFAULT NULL,
  `regip` varchar(255) DEFAULT NULL,
  `regtime` datetime DEFAULT NULL,
  `invitetime` datetime DEFAULT NULL,
  `pay_account` varchar(50) DEFAULT NULL,
  `pay_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_users`
--

LOCK TABLES `dg_users` WRITE;
/*!40000 ALTER TABLE `dg_users` DISABLE KEYS */;
INSERT INTO `dg_users` VALUES (10000,1,0,'admin','4d3ea8f0d1aa6fa07b6c0a5375645c48','1107338256151ba2b8d48c209e023d34',10,0.00,0.00,0.00,9,0,'1170981606','0',NULL,NULL,'2019-01-01 00:00:01',NULL,NULL,NULL);
/*!40000 ALTER TABLE `dg_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dg_webs`
--

DROP TABLE IF EXISTS `dg_webs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dg_webs` (
  `zid` int(11) NOT NULL AUTO_INCREMENT,
  `upzid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `super` tinyint(2) NOT NULL DEFAULT '0',
  `domain` varchar(255) DEFAULT NULL,
  `domain2` varchar(255) DEFAULT NULL,
  `qq` varchar(12) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price_dx` varchar(50) NOT NULL DEFAULT '0.8|0.6|0.5|0.4|0.3|0.1',
  `price_all` varchar(50) NOT NULL DEFAULT '3|2|1.8|1.5|1|0.8',
  `price_vip` varchar(50) NOT NULL DEFAULT '3|5|10|15|22',
  `price_ktfz` decimal(10,2) NOT NULL DEFAULT '30.00',
  `addtime` timestamp NULL DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `gg_panel` text,
  `gg_qqadd` text,
  `gg_dgadd` text,
  `gg_invite` text,
  `endtime` datetime DEFAULT '2016-06-01 00:00:00',
  PRIMARY KEY (`zid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dg_webs`
--

LOCK TABLES `dg_webs` WRITE;
/*!40000 ALTER TABLE `dg_webs` DISABLE KEYS */;
INSERT INTO `dg_webs` VALUES (1,0,10000,0,'ceshiwang.5iyw.top','','10000','裕网云代挂系统','0.8|0.6|0.5|0.4|0.3|0.1','3|2|1.8|1.5|1|0.8','3|5|10|15|22',30.00,NULL,'裕网云代挂系统','裕网云支付:pay.yw52.cn三网支付接口正常\r\n货源商城sejima.com.cn','裕网云支付:pay.yw52.cn三网支付接口正常\r\n货源商城sejima.com.cn','	<style>\r\n    #nr{\r\n    	font-size:20px;\r\n    	margin: 0;\r\n        background: -webkit-linear-gradient(left,\r\n            #ffffff,\r\n            #ff0000 6.25%,\r\n            #ff7d00 12.5%,\r\n            #ffff00 18.75%,\r\n            #00ff00 25%,\r\n            #00ffff 31.25%,\r\n            #0000ff 37.5%,\r\n            #ff00ff 43.75%,\r\n            #ffff00 50%,\r\n            #ff0000 56.25%,\r\n            #ff7d00 62.5%,\r\n            #ffff00 68.75%,\r\n            #00ff00 75%,\r\n            #00ffff 81.25%,\r\n            #0000ff 87.5%,\r\n            #ff00ff 93.75%,\r\n            #ffff00 100%);\r\n        -webkit-background-clip: text;\r\n        -webkit-text-fill-color: transparent;\r\n        background-size: 200% 100%;\r\n        animation: masked-animation 2s infinite linear;\r\n    }\r\n    @keyframes masked-animation {\r\n        0% {\r\n            background-position: 0 0;\r\n        }\r\n        100% {\r\n            background-position: -100%, 0;\r\n        }\r\n    }\r\n</style>\r\n	<div style=\"background-color:#333;border-radius:25px;box-shadow:0px 0px 5px #f200ff;padding:5px;margin-top:10px;margin-bottom:0px;\">\r\n		<marquee>\r\n    	<b id=\"nr\">欢迎进入本系统下方信誉推荐站点</b> </marquee>\r\n	</div>\r\n<a class=\"adplan\" data-id=\"15\" style=\"display:block;width:100%;margin-bottom:0px;\" rel=\"nofollow\" target=\"_blank\" href=\"http://pay.yw52.cn\r\n\" title=\"广告联系q：444586924|过期时间：9.30\"> <img src=\"https://pay.yw52.cn/zfjkgg.gif\" style=\"max-height:70px;width:100%;border-radius:40px;\" width=\"644\" height=\"70\" title=\"\" align=\"\" alt=\"\" /></a>\r\n\r\n\r\n			\r\n			<style>\r\n.txtguanggao{width: 100%;overflow: hidden;display: block;box-shadow: 0 1px 2px 0 rgba(0,0,0,.05);}.txtguanggao a{width: 24.5%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}.txtguanggao a:nth-child(1) {background-color: #dc3545;}.txtguanggao a:nth-child(2) {background-color: #007bff;}.txtguanggao a:nth-child(3) {background-color: #28a745;}.txtguanggao a:nth-child(4) {background-color: #ffc107;}.txtguanggao a:nth-child(5) {background-color: #28a745;}.txtguanggao a:nth-child(6) {background-color: #ffc107;}.txtguanggao a:nth-child(7) {background-color: #dc3545;}.txtguanggao a:nth-child(8){background-color: #007bff;}.txtguanggao a:hover{background:#FF2805;color:#FFF}@media screen and (max-width: 1000px) {.txtguanggao a{width: 47.96%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}}\r\n  </style>\r\n	<div class=\"txtguanggao\">\r\n		<a href=\"http://sejima.com.cn/\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">货源云商城</a>\r\n		<a href=\"https://web.by52eg.com/history?lang=zh\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">流量卡3/张</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">裕网云支付</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">支付宝微信正常支付</a> \r\n	</div>\r\n</div>','	<style>\r\n    #nr{\r\n    	font-size:20px;\r\n    	margin: 0;\r\n        background: -webkit-linear-gradient(left,\r\n            #ffffff,\r\n            #ff0000 6.25%,\r\n            #ff7d00 12.5%,\r\n            #ffff00 18.75%,\r\n            #00ff00 25%,\r\n            #00ffff 31.25%,\r\n            #0000ff 37.5%,\r\n            #ff00ff 43.75%,\r\n            #ffff00 50%,\r\n            #ff0000 56.25%,\r\n            #ff7d00 62.5%,\r\n            #ffff00 68.75%,\r\n            #00ff00 75%,\r\n            #00ffff 81.25%,\r\n            #0000ff 87.5%,\r\n            #ff00ff 93.75%,\r\n            #ffff00 100%);\r\n        -webkit-background-clip: text;\r\n        -webkit-text-fill-color: transparent;\r\n        background-size: 200% 100%;\r\n        animation: masked-animation 2s infinite linear;\r\n    }\r\n    @keyframes masked-animation {\r\n        0% {\r\n            background-position: 0 0;\r\n        }\r\n        100% {\r\n            background-position: -100%, 0;\r\n        }\r\n    }\r\n</style>\r\n	<div style=\"background-color:#333;border-radius:25px;box-shadow:0px 0px 5px #f200ff;padding:5px;margin-top:10px;margin-bottom:0px;\">\r\n		<marquee>\r\n    	<b id=\"nr\">欢迎进入本系统下方信誉推荐站点</b> </marquee>\r\n	</div>\r\n<a class=\"adplan\" data-id=\"15\" style=\"display:block;width:100%;margin-bottom:0px;\" rel=\"nofollow\" target=\"_blank\" href=\"http://pay.yw52.cn\r\n\" title=\"广告联系q：444586924|过期时间：9.30\"> <img src=\"https://pay.yw52.cn/zfjkgg.gif\" style=\"max-height:70px;width:100%;border-radius:40px;\" width=\"644\" height=\"70\" title=\"\" align=\"\" alt=\"\" /></a>\r\n\r\n\r\n			\r\n			<style>\r\n.txtguanggao{width: 100%;overflow: hidden;display: block;box-shadow: 0 1px 2px 0 rgba(0,0,0,.05);}.txtguanggao a{width: 24.5%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}.txtguanggao a:nth-child(1) {background-color: #dc3545;}.txtguanggao a:nth-child(2) {background-color: #007bff;}.txtguanggao a:nth-child(3) {background-color: #28a745;}.txtguanggao a:nth-child(4) {background-color: #ffc107;}.txtguanggao a:nth-child(5) {background-color: #28a745;}.txtguanggao a:nth-child(6) {background-color: #ffc107;}.txtguanggao a:nth-child(7) {background-color: #dc3545;}.txtguanggao a:nth-child(8){background-color: #007bff;}.txtguanggao a:hover{background:#FF2805;color:#FFF}@media screen and (max-width: 1000px) {.txtguanggao a{width: 47.96%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}}\r\n  </style>\r\n	<div class=\"txtguanggao\">\r\n		<a href=\"http://sejima.com.cn/\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">货源云商城</a>\r\n		<a href=\"https://web.by52eg.com/history?lang=zh\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">流量卡3/张</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">裕网云支付</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">支付宝微信正常支付</a> \r\n	</div>\r\n</div>','	<style>\r\n    #nr{\r\n    	font-size:20px;\r\n    	margin: 0;\r\n        background: -webkit-linear-gradient(left,\r\n            #ffffff,\r\n            #ff0000 6.25%,\r\n            #ff7d00 12.5%,\r\n            #ffff00 18.75%,\r\n            #00ff00 25%,\r\n            #00ffff 31.25%,\r\n            #0000ff 37.5%,\r\n            #ff00ff 43.75%,\r\n            #ffff00 50%,\r\n            #ff0000 56.25%,\r\n            #ff7d00 62.5%,\r\n            #ffff00 68.75%,\r\n            #00ff00 75%,\r\n            #00ffff 81.25%,\r\n            #0000ff 87.5%,\r\n            #ff00ff 93.75%,\r\n            #ffff00 100%);\r\n        -webkit-background-clip: text;\r\n        -webkit-text-fill-color: transparent;\r\n        background-size: 200% 100%;\r\n        animation: masked-animation 2s infinite linear;\r\n    }\r\n    @keyframes masked-animation {\r\n        0% {\r\n            background-position: 0 0;\r\n        }\r\n        100% {\r\n            background-position: -100%, 0;\r\n        }\r\n    }\r\n</style>\r\n	<div style=\"background-color:#333;border-radius:25px;box-shadow:0px 0px 5px #f200ff;padding:5px;margin-top:10px;margin-bottom:0px;\">\r\n		<marquee>\r\n    	<b id=\"nr\">欢迎进入本系统下方信誉推荐站点</b> </marquee>\r\n	</div>\r\n<a class=\"adplan\" data-id=\"15\" style=\"display:block;width:100%;margin-bottom:0px;\" rel=\"nofollow\" target=\"_blank\" href=\"http://pay.yw52.cn\r\n\" title=\"广告联系q：444586924|过期时间：9.30\"> <img src=\"https://pay.yw52.cn/zfjkgg.gif\" style=\"max-height:70px;width:100%;border-radius:40px;\" width=\"644\" height=\"70\" title=\"\" align=\"\" alt=\"\" /></a>\r\n\r\n\r\n			\r\n			<style>\r\n.txtguanggao{width: 100%;overflow: hidden;display: block;box-shadow: 0 1px 2px 0 rgba(0,0,0,.05);}.txtguanggao a{width: 24.5%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}.txtguanggao a:nth-child(1) {background-color: #dc3545;}.txtguanggao a:nth-child(2) {background-color: #007bff;}.txtguanggao a:nth-child(3) {background-color: #28a745;}.txtguanggao a:nth-child(4) {background-color: #ffc107;}.txtguanggao a:nth-child(5) {background-color: #28a745;}.txtguanggao a:nth-child(6) {background-color: #ffc107;}.txtguanggao a:nth-child(7) {background-color: #dc3545;}.txtguanggao a:nth-child(8){background-color: #007bff;}.txtguanggao a:hover{background:#FF2805;color:#FFF}@media screen and (max-width: 1000px) {.txtguanggao a{width: 47.96%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}}\r\n  </style>\r\n	<div class=\"txtguanggao\">\r\n		<a href=\"http://sejima.com.cn/\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">货源云商城</a>\r\n		<a href=\"https://web.by52eg.com/history?lang=zh\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">流量卡3/张</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">裕网云支付</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">支付宝微信正常支付</a> \r\n	</div>\r\n</div>','	<style>\r\n    #nr{\r\n    	font-size:20px;\r\n    	margin: 0;\r\n        background: -webkit-linear-gradient(left,\r\n            #ffffff,\r\n            #ff0000 6.25%,\r\n            #ff7d00 12.5%,\r\n            #ffff00 18.75%,\r\n            #00ff00 25%,\r\n            #00ffff 31.25%,\r\n            #0000ff 37.5%,\r\n            #ff00ff 43.75%,\r\n            #ffff00 50%,\r\n            #ff0000 56.25%,\r\n            #ff7d00 62.5%,\r\n            #ffff00 68.75%,\r\n            #00ff00 75%,\r\n            #00ffff 81.25%,\r\n            #0000ff 87.5%,\r\n            #ff00ff 93.75%,\r\n            #ffff00 100%);\r\n        -webkit-background-clip: text;\r\n        -webkit-text-fill-color: transparent;\r\n        background-size: 200% 100%;\r\n        animation: masked-animation 2s infinite linear;\r\n    }\r\n    @keyframes masked-animation {\r\n        0% {\r\n            background-position: 0 0;\r\n        }\r\n        100% {\r\n            background-position: -100%, 0;\r\n        }\r\n    }\r\n</style>\r\n	<div style=\"background-color:#333;border-radius:25px;box-shadow:0px 0px 5px #f200ff;padding:5px;margin-top:10px;margin-bottom:0px;\">\r\n		<marquee>\r\n    	<b id=\"nr\">欢迎进入本系统下方信誉推荐站点</b> </marquee>\r\n	</div>\r\n<a class=\"adplan\" data-id=\"15\" style=\"display:block;width:100%;margin-bottom:0px;\" rel=\"nofollow\" target=\"_blank\" href=\"http://pay.yw52.cn\r\n\" title=\"广告联系q：444586924|过期时间：9.30\"> <img src=\"https://pay.yw52.cn/zfjkgg.gif\" style=\"max-height:70px;width:100%;border-radius:40px;\" width=\"644\" height=\"70\" title=\"\" align=\"\" alt=\"\" /></a>\r\n\r\n\r\n			\r\n			<style>\r\n.txtguanggao{width: 100%;overflow: hidden;display: block;box-shadow: 0 1px 2px 0 rgba(0,0,0,.05);}.txtguanggao a{width: 24.5%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}.txtguanggao a:nth-child(1) {background-color: #dc3545;}.txtguanggao a:nth-child(2) {background-color: #007bff;}.txtguanggao a:nth-child(3) {background-color: #28a745;}.txtguanggao a:nth-child(4) {background-color: #ffc107;}.txtguanggao a:nth-child(5) {background-color: #28a745;}.txtguanggao a:nth-child(6) {background-color: #ffc107;}.txtguanggao a:nth-child(7) {background-color: #dc3545;}.txtguanggao a:nth-child(8){background-color: #007bff;}.txtguanggao a:hover{background:#FF2805;color:#FFF}@media screen and (max-width: 1000px) {.txtguanggao a{width: 47.96%;float: left;border-radius: 2px;line-height: 35.35px;height: 35.35px;text-align: center;font-size: 14px;color: #fff;display: inline-block;background-color: rgb(255, 153, 159);margin: 2.5px;transition-duration: .3s;}}\r\n  </style>\r\n	<div class=\"txtguanggao\">\r\n		<a href=\"http://sejima.com.cn/\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">货源云商城</a>\r\n		<a href=\"https://web.by52eg.com/history?lang=zh\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">流量卡3/张</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">裕网云支付</a> \r\n		<a href=\"http://pay.yw52.cn\" target=\"_blank\" rel=\"nofollow\" class=\"dh\">支付宝微信正常支付</a> \r\n	</div>\r\n</div>','2030-12-31 08:00:00');
/*!40000 ALTER TABLE `dg_webs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-08 17:05:00
