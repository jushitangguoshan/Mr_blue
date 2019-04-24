-- MySQL dump 10.13  Distrib 5.6.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: test
-- ------------------------------------------------------
-- Server version	5.6.42-log

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
-- Table structure for table `cms_user`
--

DROP TABLE IF EXISTS `cms_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `alipay_openid` char(60) NOT NULL DEFAULT '' COMMENT '支付宝openid',
  `weixin_openid` char(60) NOT NULL DEFAULT '' COMMENT '微信openid',
  `baidu_openid` char(60) NOT NULL DEFAULT '' COMMENT '百度openid',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态（0正常, 1禁止发言, 2禁止登录）',
  `salt` char(32) NOT NULL DEFAULT '' COMMENT '配合密码加密串',
  `pwd` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `username` char(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` char(60) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` char(60) NOT NULL DEFAULT '' COMMENT '电子邮箱（最大长度60个字符）',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `avatar` char(255) NOT NULL DEFAULT '' COMMENT '用户头像地址',
  `province` char(60) NOT NULL DEFAULT '' COMMENT '所在省',
  `city` char(60) NOT NULL DEFAULT '' COMMENT '所在市',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日',
  `address` char(150) NOT NULL DEFAULT '' COMMENT '详细地址',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `grade` tinyint(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级 0普通会员,1VIP会员,2超级VIP会员',
  `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `referrer` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人用户id',
  `referrer_giving_integral_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐赠送积分次数（0未赠送, 大于0则是赠送次数）',
  `is_delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否已删除（0否, 大于0删除时间）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `alipay_openid` (`alipay_openid`),
  KEY `weixin_openid` (`weixin_openid`),
  KEY `mobile` (`mobile`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_user`
--

LOCK TABLES `cms_user` WRITE;
/*!40000 ALTER TABLE `cms_user` DISABLE KEYS */;
INSERT INTO `cms_user` VALUES (77,'2088502175420842-','','',0,'430953','13ee29b2b06000b088a07cf36e7062f7','','龚哥哥','13250814883','fuxiang.gong@qq.com',2,'https://tfs.alipayobjects.com/images/partner/T10d8lXm4dXXXXXXXX','上海','上海市',1540915200,'',0.00,0,982,0,0,0,0,1550466434),(90,'2088502175420842','','',0,'081377','354c9ea986fbdaec110d310c324dbcab','','魔鬼','17688888888','',2,'','上海','上海市',666201600,'',0.00,0,50,0,0,0,1539167253,1552534767);
/*!40000 ALTER TABLE `cms_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-21 11:24:49
