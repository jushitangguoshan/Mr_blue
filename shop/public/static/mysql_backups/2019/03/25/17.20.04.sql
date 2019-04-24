-- MySQL dump 10.13  Distrib 5.6.42, for Win64 (x86_64)
--
-- Host: 192.168.0.104    Database: cms_solarshop
-- ------------------------------------------------------
-- Server version	5.5.53

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
-- Table structure for table `cms_admin`
--

DROP TABLE IF EXISTS `cms_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `username` char(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `login_pwd` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `login_salt` char(6) NOT NULL DEFAULT '' COMMENT '登录密码配合加密字符串',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `login_total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属角色组',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_admin`
--

LOCK TABLES `cms_admin` WRITE;
/*!40000 ALTER TABLE `cms_admin` DISABLE KEYS */;
INSERT INTO `cms_admin` VALUES (1,'admin','e60f4215a952bc89bf57002fecae405c','188293','15815540770',2,405,1553504169,1,1481350313,1552527893),(4,'Mr_blue','c90200ab8d937f88b39c91a59804c22c','803902','15815540770',2,7,1553474559,1,1552903710,0),(5,'123123','8981e0408ef7da09f3e40cb074da76c6','068435','15812345612',0,1,1552906376,13,1552906367,0),(6,'1512514','1d90265fc1e9ef38a8a804939c62db0c','388037','15816647559',0,0,0,13,1553164017,0),(8,'12512','4829ffc050dc09e2334055a8b5cab5d5','972009','15816647559',0,0,0,13,1553164362,0),(9,'Mr_zhang','7beca0fdf2a8d3c9729e227ea745c60d','349404','15090791204',0,1,1553495769,1,1553477564,0),(15,'admin','fecb987c860b2f9a554b12de27f46784','778267','13266879184',0,0,0,1,1553503723,0);
/*!40000 ALTER TABLE `cms_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_admin_log`
--

DROP TABLE IF EXISTS `cms_admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(60) NOT NULL COMMENT '操作名',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作管理员id',
  `role_id` int(10) unsigned NOT NULL COMMENT '所属组',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '操作标题',
  `detail` char(255) NOT NULL DEFAULT '' COMMENT '操作内容',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='管理员操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_admin_log`
--

LOCK TABLES `cms_admin_log` WRITE;
/*!40000 ALTER TABLE `cms_admin_log` DISABLE KEYS */;
INSERT INTO `cms_admin_log` VALUES (1,'Mr_blue',4,1,'增加','Mr_blue增加了管理员12512',1553164404),(2,'Mr_blue',4,1,'删除','Mr_blue删除了管理员12512',1553164429),(3,'admin',1,1,'增加','admin增加了管理员Mr_zhang',1553477564),(4,'admin',1,1,'增加','admin增加了管理员qrqwrqwr',1553502504),(5,'admin',1,1,'删除','admin删除了管理员qrqwrqwr',1553502521),(6,'admin',1,1,'增加','admin增加了管理员hahah',1553502725),(7,'admin',1,1,'删除','admin删除了管理员hahah',1553503009),(8,'admin',1,1,'增加','admin增加了管理员test1',1553503081),(9,'admin',1,1,'增加','admin增加了管理员test2',1553503108),(10,'admin',1,1,'增加','admin增加了管理员test3',1553503126),(11,'admin',1,1,'删除','admin删除了管理员test1',1553503221),(12,'admin',1,1,'删除','admin删除了管理员test2',1553503224),(13,'admin',1,1,'删除','admin删除了管理员test3',1553503226),(14,'admin',1,1,'增加','admin增加了管理员admin',1553503723);
/*!40000 ALTER TABLE `cms_admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_admin_work`
--

DROP TABLE IF EXISTS `cms_admin_work`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_admin_work` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属角色组id',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '消息标题',
  `detail` text NOT NULL COMMENT '消息详情',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0代办工作,1紧急工作,2已办结工作',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读（0否, 1是）',
  `is_delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '是否已删除（0否, 大于0删除时间）',
  `admin_is_delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '管理员是否已删除（0否, 大于0删除时间）',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `admin_id` (`admin_id`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员工作记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_admin_work`
--

LOCK TABLES `cms_admin_work` WRITE;
/*!40000 ALTER TABLE `cms_admin_work` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_admin_work` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_answer`
--

DROP TABLE IF EXISTS `cms_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_answer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `tel` char(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `content` char(255) NOT NULL DEFAULT '' COMMENT '详细内容',
  `reply` char(255) NOT NULL DEFAULT '' COMMENT '回复内容',
  `is_reply` tinyint(1) unsigned DEFAULT '0' COMMENT '是否已回复（0否, 1是）',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示（0不显示, 1显示）',
  `is_delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否已删除（0否, 大于0删除时间）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`name`),
  KEY `is_delete_time` (`is_delete_time`),
  KEY `is_show` (`is_show`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户留言/问答';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_answer`
--

LOCK TABLES `cms_answer` WRITE;
/*!40000 ALTER TABLE `cms_answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_app_home_nav`
--

DROP TABLE IF EXISTS `cms_app_home_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_app_home_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `platform` char(30) NOT NULL DEFAULT 'pc' COMMENT '所属平台（pc PC网站, h5 H5手机网站, app 手机APP, alipay 支付宝小程序, weixin 微信小程序, baidu 百度小程序）',
  `event_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '事件类型（0 WEB页面, 1 内部页面(小程序或APP内部地址), 2 外部小程序(同一个主体下的小程序appid), 3 打开地图, 4 拨打电话）',
  `event_value` char(255) NOT NULL DEFAULT '' COMMENT '事件值',
  `images_url` char(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '别名',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `bg_color` char(30) NOT NULL DEFAULT '' COMMENT 'css背景色值',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `platform` (`platform`),
  KEY `is_enable` (`is_enable`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='手机 - 首页导航';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_app_home_nav`
--

LOCK TABLES `cms_app_home_nav` WRITE;
/*!40000 ALTER TABLE `cms_app_home_nav` DISABLE KEYS */;
INSERT INTO `cms_app_home_nav` VALUES (1,'weixin',1,'/pages/user-order/user-order','/static/upload/images/app_nav/2018/11/19/2018111915461980516.png','分类',1,'#FF3300',0,1542563498,1546671679),(2,'weixin',1,'/pages/cart/cart','/static/upload/images/app_nav/2018/11/19/2018111915473948001.png','购物车',1,'#48CFAE',1,1542613659,1546281258),(3,'alipay',1,'/pages/user-order/user-order','/static/upload/images/app_nav/2018/11/19/2018111915482687655.png','订单',1,'#FF0066',2,1542613706,1542705254),(4,'alipay',1,'/pages/user/user','/static/upload/images/app_nav/2018/11/19/2018111915491258361.png','我的',1,'#49acfa',3,1542613752,1542618360);
/*!40000 ALTER TABLE `cms_app_home_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_article`
--

DROP TABLE IF EXISTS `cms_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '标题',
  `article_category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章分类',
  `title_color` char(7) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `jump_url` char(255) NOT NULL DEFAULT '' COMMENT '跳转url地址',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `content` text COMMENT '内容',
  `image` text COMMENT '图片数据（一维数组json）',
  `image_count` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文章图片数量',
  `access_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `is_home_recommended` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页推荐（0否, 1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `is_enable` (`is_enable`),
  KEY `access_count` (`access_count`),
  KEY `image_count` (`image_count`),
  KEY `article_category_id` (`article_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_article`
--

LOCK TABLES `cms_article` WRITE;
/*!40000 ALTER TABLE `cms_article` DISABLE KEYS */;
INSERT INTO `cms_article` VALUES (1,'如何注册成为会员',7,'','',1,'<p>如何注册成为会员</p><p>如何注册成为会员</p><p>如何注册成为会员</p><p>如何注册成为会员</p>','[]',0,179,1,1484965691,1534228456),(3,'积分细则',7,'#FF0000','',1,'<p>积分细则</p><p>积分细则</p><p>积分细则</p><p>积分细则</p><p>积分细则</p><p>积分细则</p><p>积分细则</p>','[]',0,38,1,1484985139,1534228496),(4,'积分兑换说明',17,'','',1,'<p>积分兑换说明</p><p>积分兑换说明</p><p>积分兑换说明</p><p>积分兑换说明</p><p>积分兑换说明</p><p>积分兑换说明</p>','[]',0,45,1,1484989903,1534228520),(5,'如何搜索',7,'','',1,'<p>如何搜索</p><p>如何搜索</p><p>如何搜索</p><p>如何搜索</p><p>如何搜索</p><p>如何搜索</p><p>如何搜索</p>','[]',0,30,1,1485064767,1534228544),(6,'忘记密码',17,'','',1,'<p>忘记密码</p><p>忘记密码</p><p>忘记密码</p><p>忘记密码</p><p>忘记密码</p>','[]',0,24,1,1485073500,1534228567),(7,'如何管理店铺',10,'','',1,'<p>如何管理店铺</p><p>如何管理店铺</p><p>如何管理店铺</p><p>如何管理店铺</p><p>如何管理店铺</p><p>如何管理店铺</p>','[]',0,54,1,1487819252,1534228589),(8,'查看售出商品',10,'','',1,'<p>查看售出商品</p><p>查看售出商品</p><p>查看售出商品</p><p>查看售出商品</p><p>查看售出商品</p>','[]',0,53,1,1487819408,1534228614),(9,'如何发货',10,'#CC0066','',1,'<p>如何发货</p><p>如何发货</p><p>如何发货</p><p>如何发货</p><p>如何发货</p>','',0,40,1,1487920130,1545500851),(10,'商城商品推荐',10,'','',1,'<p>商城商品推荐</p><p>商城商品推荐</p><p>商城商品推荐</p><p>商城商品推荐</p><p>商城商品推荐</p>','[]',0,6,1,1534228650,1534228650),(11,'如何申请开店',10,'','',1,'<p>如何申请开店</p><p>如何申请开店</p><p>如何申请开店</p><p>如何申请开店</p>','[]',0,6,1,1534228676,1534228676),(12,'分期付款',16,'','',1,'<p>分期付款</p><p>分期付款</p><p>分期付款</p><p>分期付款</p><p>分期付款</p>','[]',0,4,1,1534228694,1534228694),(13,'邮局汇款',16,'','',1,'<p>邮局汇款</p><p>邮局汇款</p><p>邮局汇款</p><p>邮局汇款</p><p>邮局汇款</p>','[]',0,4,1,1534228710,1534228710),(14,'公司转账',16,'','',1,'<p>公司转账</p><p>公司转账</p><p>公司转账</p><p>公司转账</p><p>公司转账</p>','[]',0,1,1,1534228732,1534228732),(15,'如何注册支付宝',16,'','',1,'<p>如何注册支付宝</p><p>如何注册支付宝</p><p>如何注册支付宝</p><p>如何注册支付宝</p><p>如何注册支付宝</p>','[]',0,1,1,1534228748,1534228748),(16,'在线支付',16,'','',1,'<p>在线支付</p><p>在线支付</p><p>在线支付</p><p>在线支付</p><p>在线支付</p>','[]',0,1,1,1534228764,1534228764),(17,'联系卖家',17,'','',1,'<p>联系卖家</p><p>联系卖家</p><p>联系卖家</p><p>联系卖家</p><p>联系卖家</p><p>联系卖家</p>','[]',0,3,1,1534228781,1534228781),(18,'退换货政策',17,'','',1,'<p>退换货政策</p><p>退换货政策</p><p>退换货政策</p><p>退换货政策</p><p>退换货政策</p>','[]',0,6,1,1534228802,1534228802),(19,'退换货流程',17,'','',1,'<p>退换货流程</p><p>退换货流程</p><p>退换货流程</p><p>退换货流程</p><p>退换货流程</p>','[]',0,1,1,1534228850,1534228850),(20,'返修/退换货',17,'','',1,'<p>返修/退换货</p><p>返修/退换货</p><p>返修/退换货</p><p>返修/退换货</p><p>返修/退换货</p>','[]',0,4,1,1534228867,1534228867),(21,'退款申请',17,'','',1,'<p>退款申请</p><p>退款申请</p><p>退款申请</p><p>退款申请</p><p>退款申请</p>','[]',0,1,1,1534228885,1534228885),(22,'会员修改密码',18,'','',1,'<p>会员修改密码</p><p>会员修改密码</p><p>会员修改密码</p><p>会员修改密码</p>','[]',0,15,1,1534228900,1534228900),(23,'会员修改个人资料',18,'','',1,'<p>会员修改个人资料</p><p>会员修改个人资料</p><p>会员修改个人资料</p><p>会员修改个人资料</p><p>会员修改个人资料</p>','[]',0,5,1,1534228916,1534228916),(24,'商品发布',18,'','',1,'<p>商品发布</p><p>商品发布</p><p>商品发布</p><p>商品发布</p><p>商品发布</p>','[]',0,6,1,1534228931,1534228931),(25,'修改收货地址',18,'','',1,'<p>修改收货地址</p><p>修改收货地址</p><p>修改收货地址</p><p>修改收货地址</p><p>修改收货地址</p>','[]',0,4,1,1534228948,1534228948),(26,'合作及洽谈',24,'','',1,'<p>合作及洽谈</p><p>合作及洽谈</p><p>合作及洽谈</p><p>合作及洽谈</p><p>合作及洽谈</p>','[]',0,18,1,1534228968,1534228968),(27,'招聘英才',24,'','',1,'<h2>PHP工程师</h2><p>岗位描述：</p><p>1.负责项目后端系统的研发和维护工作。</p><p>2.负责跟进平台的运营监控和数据分析工作。</p><p>3.按时保质保量完成项目开发,研究新兴技术，持续优化系统架构，完善基础服务。<br/></p><p>4.思维敏捷,责任心强,能承受工作压力。</p><p><br/></p><p>任职资格：</p><p>1、本科及以上学历，计算机相关专业，3年以上相关开发工作经验。</p><p>2、精通基于LNMP的Web开发技术, 熟悉yii, yaf, ThinkPHP, zend等框架的是用及实现原理。</p><p>3、熟悉mysql、redis等应用开发，精通SQL调优和数据结构设计。</p><p>4、熟悉使用Javascript、Ajax，Html，Div+CSS，Vue等技术。</p><p>5、有大型项目开发经验，系统调优经验者优先。</p><p>6、对LNMP/LAMP架构的部署、搭建、优化、排错等方面有经验者优先。</p><p>7、事业心强，勤奋好学，有团队精神。</p><p><br/></p><h2>前端工程师</h2><p>岗位描述：</p><p>1.配合项目经理和设计师快速实现一流的前端界面，优化代码并保持良好的兼容性，改善用户体验。</p><p>2.根据业务和项目需求，进行技术创新，分析并给出最优的前台技术实现方案。</p><p>3.对前端开发的新技术有敏锐嗅觉，推进前端技术演进。</p><p>4.进行新技术调研，持续对产品前端进行维护和升级。</p><p><br/></p><p>任职资格：</p><p>1、了解Web 标准，熟悉 HTML、CSS、JavaScript 各种前端技术。</p><p>2、熟悉 HTTP 协议。</p><p>3、认真负责，积极主动，有良好的团队合作意识。</p><p>4、了解 Angularjs，前端工程化或者 Node.js 等技术有研究。</p><p>5、有Vue开发经验者优先。</p><p>6、事业心强，勤奋好学，有团队精神。</p><p><br/></p>','[]',0,11,1,1534228987,1534229359),(28,'联系我们',24,'','',1,'<p style=\"padding: 5px; margin-top: 0px; margin-bottom: 0px; clear: both; color: rgb(102, 102, 102); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei&quot;, arial, 宋体, &quot;Helvetica Neue&quot;, Helvetica, STHeiTi, sans-serif; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);\">欢迎您对我们的站点、工作、产品和服务提出自己宝贵的意见或建议。我们将给予您及时答复。同时也欢迎您到我们公司来洽商业务。</p><p style=\"padding: 5px; margin-top: 0px; margin-bottom: 0px; clear: both; color: rgb(102, 102, 102); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei&quot;, arial, 宋体, &quot;Helvetica Neue&quot;, Helvetica, STHeiTi, sans-serif; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);\"><br/><strong style=\"font-size: 1em;\">公司名称</strong>： ShopXO</p><p style=\"padding: 5px; margin-top: 0px; margin-bottom: 0px; clear: both; color: rgb(102, 102, 102); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei&quot;, arial, 宋体, &quot;Helvetica Neue&quot;, Helvetica, STHeiTi, sans-serif; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);\"><strong style=\"font-size: 1em;\">通信地址</strong>： 上海市浦东新区上海市浦东新区盛夏路</p><p style=\"padding: 5px; margin-top: 0px; margin-bottom: 0px; clear: both; color: rgb(102, 102, 102); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei&quot;, arial, 宋体, &quot;Helvetica Neue&quot;, Helvetica, STHeiTi, sans-serif; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);\"><strong style=\"font-size: 1em;\">商务洽谈</strong>： 176-8888-8888<br/></p>','[]',0,19,1,1534229110,1534229110),(29,'关于ShopXO',24,'#FF0000','http://gong.gg/',1,'<p>ShopXO位于上海市浦东新区，是专业从事生产管理信息化领域技术咨询和软件开发的高新技术企业。公司拥有多名技术人才和资深的行业解决方案专家。</p><p><br/></p><p>公司拥有一支勇于开拓、具有战略眼光和敏锐市场判断力的市场营销队伍，一批求实敬业，追求卓越的行政管理人才，一个能征善战，技术优秀，经验丰富的开发团队。公司坚持按现代企业制度和市场规律办事，在扩大经营规模的同时，注重企业经济运行质量，在自主产品研发及承接软件项目方面获得了很强的竞争力。 我公司也积极参与国内传统企业的信息化改造，引进国际化产品开发的标准，规范软件开发流程，通过提升各层面的软件开发人才的技术素质，打造国产软件精品，目前已经开发出具有自主知识产权的网络商城软件，还在积极开发基于电子商务平台高效能、高效益的管理系统。为今后进一步开拓国内市场打下坚实的基础。公司致力于构造一个开放、发展的人才平台，积极营造追求卓越、积极奉献的工作氛围，把“以人为本”的理念落实到每一项具体工作中，为那些锋芒内敛，激情无限的业界精英提供充分的发展空间，优雅自信、从容自得的工作环境，事业雄心与生活情趣两相兼顾的生活方式。并通过每个员工不断提升自我，以自己的独特价值观对工作与生活作最准确的判断，使我们每一个员工彰显出他们出色的自我品位，独有的工作个性和卓越的创新风格，让他们时刻保持振奋、不断鼓舞内心深处的梦想，永远走在时代潮流前端。公司发展趋势 励精图治，展望未来。公司把发展产业策略与发掘人才策略紧密结合，广纳社会精英，挖掘创新潜能，以人为本，凝聚人气，努力营造和谐宽松的工作氛围，为优秀人才的脱颖而出提供机遇。公司将在深入发展软件产业的同时，通过不懈的努力，来塑造大型软件公司的辉煌形象。</p>','',0,32,1,1534229221,1545500386);
/*!40000 ALTER TABLE `cms_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_article_category`
--

DROP TABLE IF EXISTS `cms_article_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_article_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_article_category`
--

LOCK TABLES `cms_article_category` WRITE;
/*!40000 ALTER TABLE `cms_article_category` DISABLE KEYS */;
INSERT INTO `cms_article_category` VALUES (7,0,'帮助中心',1,0,0,1545501262),(10,0,'店主之家',1,0,0,1534228298),(16,0,'支付方式',1,0,1482840545,1534228311),(17,0,'售后服务',1,0,1482840557,1534228324),(18,0,'客服中心',1,0,1482840577,1534228337),(24,0,'关于我们',1,0,1483951541,1545501248);
/*!40000 ALTER TABLE `cms_article_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_brand`
--

DROP TABLE IF EXISTS `cms_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_brand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `brand_category_id` int(11) unsigned DEFAULT '0' COMMENT '品牌分类id',
  `logo` char(255) NOT NULL DEFAULT '' COMMENT 'logo图标',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '名称',
  `website_url` char(255) NOT NULL DEFAULT '' COMMENT '官网地址',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '品牌描述',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='品牌';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_brand`
--

LOCK TABLES `cms_brand` WRITE;
/*!40000 ALTER TABLE `cms_brand` DISABLE KEYS */;
INSERT INTO `cms_brand` VALUES (3,33,'/static/upload/images/brand/2019/03/19/1552975829727553.jpg','展宇光伏','https://www.xxx.com','',1,0,1552975847,1553069830),(4,33,'/static/upload/images/brand/2019/03/19/1552975908448904.jpg','天合光能','','',1,0,1552975911,1553069807),(5,32,'/static/upload/images/brand/2019/03/19/1552975930521837.jpg','特变电工','','',1,0,1552975933,0);
/*!40000 ALTER TABLE `cms_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_brand_category`
--

DROP TABLE IF EXISTS `cms_brand_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_brand_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='品牌分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_brand_category`
--

LOCK TABLES `cms_brand_category` WRITE;
/*!40000 ALTER TABLE `cms_brand_category` DISABLE KEYS */;
INSERT INTO `cms_brand_category` VALUES (31,0,'其他',1,0,1535684797,1536226686),(32,0,'欧洲品牌',1,0,1552975556,1552975598),(33,0,'中国品牌',1,0,1552975613,0),(34,0,'美国品牌',1,0,1552975625,0);
/*!40000 ALTER TABLE `cms_brand_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_cart`
--

DROP TABLE IF EXISTS `cms_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned DEFAULT '0' COMMENT '用户id',
  `goods_id` int(11) unsigned DEFAULT '0' COMMENT '商品id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '标题',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '封面图片',
  `original_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '销售价格',
  `stock` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `spec` char(255) NOT NULL DEFAULT '' COMMENT '规格',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '清空时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`goods_id`),
  KEY `title` (`title`),
  KEY `stock` (`stock`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='购物车';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_cart`
--

LOCK TABLES `cms_cart` WRITE;
/*!40000 ALTER TABLE `cms_cart` DISABLE KEYS */;
INSERT INTO `cms_cart` VALUES (2,90,2,'苹果（Apple）iPhone 6 Plus (A1524)移动联通电信4G手机 金色 16G','/static/upload/images/goods/2019/01/14/1547451274847894.jpg',6800.00,6050.00,1,'[{\"type\":\"\\u5957\\u9910\",\"value\":\"\\u5957\\u9910\\u4e00\"},{\"type\":\"\\u989c\\u8272\",\"value\":\"\\u91d1\\u8272\"},{\"type\":\"\\u5bb9\\u91cf\",\"value\":\"32G\"}]',1552542525,0,0);
/*!40000 ALTER TABLE `cms_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_config`
--

DROP TABLE IF EXISTS `cms_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '基本设置id',
  `value` text COMMENT '值',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '名称',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '描述',
  `error_tips` char(150) NOT NULL DEFAULT '' COMMENT '错误提示',
  `type` char(30) NOT NULL DEFAULT '' COMMENT '类型（admin后台, home前台）',
  `only_tag` char(60) NOT NULL DEFAULT '' COMMENT '唯一的标记',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `only_tag` (`only_tag`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='基本配置参数';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_config`
--

LOCK TABLES `cms_config` WRITE;
/*!40000 ALTER TABLE `cms_config` DISABLE KEYS */;
INSERT INTO `cms_config` VALUES (8,'欢迎来到ShopXO企业级B2C开源电商系统、演示站点请勿发起支付、以免给您带来不必要的财产损失。','商城公告','空则不显示公告','','common','common_shop_notice',1550377653),(11,'0','Excel编码','excel模块编码选择','请选择编码','admin','admin_excel_charset',1549963896),(15,'10','分页数量','分页显示数量','分页不能超过3位数','admin','admin_page_number',1549963896),(16,'ShopXO企业级B2C电商系统提供商 - 演示站点','站点标题','浏览器标题，一般不超过80个字符','站点标题不能为空','home','home_seo_site_title',1546938183),(17,'商城系统,开源电商系统,免费电商系统,PHP电商系统,商城系统,B2C电商系统,B2B2C电商系统','站点关键字','一般不超过100个字符，多个关键字以半圆角逗号 [ , ] 隔开','站点关键字不能为空','home','home_seo_site_keywords',1546938183),(18,'ShopXO是国内领先的商城系统提供商，为企业提供php商城系统、微信商城、小程序。','站点描述','站点描述，一般不超过200个字符','站点描述不能为空','home','home_seo_site_description',1546938183),(19,'黔ICP备15003530号','ICP证书号','ICP域名备案号','','home','home_site_icp',1552528823),(20,'','底部统计代码','支持html，可用于添加流量统计代码','','home','home_statistics_code',0),(21,'1','站点状态','可暂时将站点关闭，其他人无法访问，但不影响管理员访问后台','请选择站点状态','home','home_site_state',1552528823),(22,'升级中...','关闭原因','支持html，当网站处于关闭状态时，关闭原因将显示在前台','','home','home_site_close_reason',1552528823),(23,'Australia/Eucla','默认时区','默认 亚洲/上海 [标准时+8]','请选择默认时区','common','common_timezone',1552528823),(24,'','底部代码','支持html，可用于添加流量统计代码','','home','home_footer_info',1552528823),(25,'2048000','图片最大限制','单位B [上传图片还受到服务器空间PHP配置最大上传 20M 限制]','请填写图片上传最大限制','home','home_max_limit_image',1552528823),(26,'51200000','文件最大限制','单位B [上传文件还受到服务器空间PHP配置最大上传 20M 限制]','请填写文件上传最大限制','home','home_max_limit_file',1552528823),(27,'102400000','视频最大限制','单位B [上传视频还受到服务器空间PHP配置最大上传 20M 限制]','请填写视频上传最大限制','home','home_max_limit_video',1552528823),(28,'有家','站点名称','','站点名称不能为空','home','home_site_name',1552528823),(29,'0','链接模式','详情ThinkPHP官网5.1版本文档 [http://www.thinkphp.cn/]','请选择url模式','home','home_seo_url_model',1546938183),(30,'html','伪静态后缀','链接后面的后缀别名，默认 [ html ]','小写字母，不能超过8个字符','home','home_seo_url_html_suffix',1546938183),(31,'','分享页面规则描述','','','common','common_share_view_desc',1542011644),(32,'/static/upload/images/common/2019/01/14/1547448748316693.png','手机端logo','支持 [jpg, png, gif]','请上传手机端网站logo','home','home_site_logo_wap',1552528823),(33,'/static/upload/images/common/2019/01/14/1547448705165706.png','电脑端logo','支持 [jpg, png, gif]','请上传电脑端网站logo','home','home_site_logo',1552528823),(34,'1200','页面最大宽度','页面最大宽度，单位px，0则100%','请上传桌面图标','home','home_content_max_width',1552528823),(35,'/static/upload/images/common/2019/01/14/1547448728921121.jpg','桌面图标','建议使用png格式','图片比例值格式有误 0~100 之间，小数点后面最大两位','common','home_site_desktop_icon',1552528823),(36,'sms,email','是否开启注册','关闭注册后，前台站点将无法注册，可选择 [ 短信, 邮箱 ]','请选择是否开启注册状态','home','home_user_reg_state',1552528823),(37,'1','是否开启登录','关闭后，前端站点将无法登录','请选择是否开启登录状态','home','home_user_login_state',1552528823),(38,'1','获取验证码-开启图片验证码','防止短信轰炸','请选择是否开启强制图片验证码','home','home_img_verify_state',1552528823),(39,'60','获取验证码时间间隔','防止频繁获取验证码，一般在 30~120 秒之间，单位 [秒]','请填写获取验证码时间间隔','home','common_verify_time_interval',1552528823),(40,'SMS_141025010','用户注册-短信模板ID','验证码code','请填写用户注册短信模板内容','home','home_sms_user_reg',1545099687),(41,'','短信签名','发送短信包含的签名','短信签名 3~8 个的中英文字符','common','common_sms_sign',1546059306),(42,'','短信KeyID','Access Key ID','请填写Access Key ID','common','common_sms_apikey',1546059306),(43,'SMS_141025009','密码找回-短信模板ID','验证码code','请填写密码找回短信模板内容','home','home_sms_user_forget_pwd',1545099687),(44,'600','验证码有效时间','验证码过期时间，一般10分钟左右，单位 [秒]','请填写验证码有效时间','home','common_verify_expire_time',1552528823),(45,'','SMTP服务器','设置SMTP服务器的地址，如 smtp.163.com','请填写SMTP服务器','common','common_email_smtp_host',1546059985),(46,'','SMTP端口','设置SMTP服务器的端口，默认为 25','请填写SMTP端口号','common','common_email_smtp_port',1546059985),(47,'','发信人邮件地址','发信人邮件地址，使用SMTP协议发送的邮件地址，如 shopxo@163.com','请填写发信人邮件地址','common','common_email_smtp_account',1546059985),(48,'','SMTP身份验证用户名','如 ShopXO','请填写SMTP身份验证用户名','common','common_email_smtp_name',1546059985),(49,'','SMTP身份验证密码','shopxo@163.com邮件的密码','请填写SMTP身份验证密码','common','common_email_smtp_pwd',1546059985),(50,'','发件人显示名称','如 ShopXO','','common','common_email_smtp_send_name',1546059985),(51,'3','分享赠送积分次数限制','分享用户注册赠送积分次数限制 [ 0则不赠送，若要不限请加大数值 ]','','common','common_share_giving_integral_frequency',1542011644),(53,'021-88888888','客服电话','','','common','common_customer_service_tel',1549963896),(56,'10','分享赠送积分','分享用户注册后赠送积分 [ 0则不赠送 ]','','common','common_share_giving_integral',1542011644),(57,'default','默认模板','前台默认模板','请填写默认模板','common','common_default_theme',1550113393),(58,'','短信KeySecret','Access Key Secret','请填写Access Key Secret','common','common_sms_apisecret',1546059306),(59,'1','扣减库存规则','需扣减库存开启方可有效，默认订单支付成功','','common','common_deduction_inventory_rules',1549963896),(60,'1','是否扣减库存','建议不要随意修改，以免造成库存数据错乱，关闭不影响库存回滚','','common','common_is_deduction_inventory',1549963896),(61,'用户中心公告文字，后台配置修改。','用户中心公告','空则不显示公告','','common','common_user_center_notice',1550377653),(62,'','百度地图api密钥','百度地图api密钥','请填写百度地图api密钥','common','common_baidu_map_ak',1549963896),(63,'<p>用户注册，你的验证码是&nbsp;&nbsp;#code#</p>','用户注册-邮件模板','验证码变量标识符 [ #code# ]','','home','home_email_user_reg',1533637393),(64,'<p>密码找回，你的验证码是&nbsp;&nbsp;#code#</p>','密码找回-邮件模板','验证码变量标识符 [ #code# ]','','home','home_email_user_forget_pwd',1533637393),(65,'<p style=\"white-space: normal;\">邮箱绑定，你的验证码是&nbsp;&nbsp;#code#</p>','邮箱绑定-邮件模板','验证码变量标识符 [ #code# ]','','home','home_email_user_email_binding',1533637393),(66,'20181012122','css/js版本标记','用于css/js浏览器缓存版本识别','','home','home_static_cache_version',1552528823),(67,'SMS_141025008','手机号码绑定-短信模板ID','验证码code','请填写手机号码绑定短信模板内容','home','home_sms_user_mobile_binding',1545099687),(68,'连衣裙,帐篷,iphone,小米,包包','搜索关键字','搜索框下热门关键字（输入回车）','请填写关键字','home','home_search_keywords',1549963896),(69,'2','搜索关键字类型','自定义需要配置以下关键字','请选择关键字类型','home','home_search_keywords_type',1549963896),(70,'0','订单预约模式','开启后用户提交订单需要管理员确认','请选择是否开启预约模式','common','common_order_is_booking',1549963896),(71,'ShopXO','名称','','请填写名称','common','common_app_mini_alipay_title',1546962547),(72,'国内领先企业级B2C开源电商系统！','描述','','请填写描述','common','common_app_mini_alipay_describe',1546962547),(73,'021-88888888','客服电话','','请填写客服电话','common','common_app_customer_service_tel',1550377653),(74,'','AppID','小程序ID','请填写AppID','common','common_app_mini_alipay_appid',1546962547),(75,'','应用公钥','','请填写应用公钥','common','common_app_mini_alipay_rsa_public',1546962547),(76,'','应用私钥','','请填写应用私钥','common','common_app_mini_alipay_rsa_private',1546962547),(77,'','支付宝公钥','','请填写支付宝公钥','common','common_app_mini_alipay_out_rsa_public',1546962547),(78,'1','是否启用搜索','','','common','common_app_is_enable_search',1550377653),(79,'1','是否启用留言','','','common','common_app_is_enable_answer',1550377653),(80,'3','商品可添加规格最大数量','建议不超过3个规格','请填写谷歌最大数','common','common_spec_add_max_number',1549963896),(81,'-','路由分隔符','建议填写 [ -  或 / ]  默认 [ - ] ，仅PATHINFO模式+短地址模式下有效','请填写路由分隔符','common','common_route_separator',1546938183),(82,'','AppID','小程序ID','请填写appid','common','common_app_mini_weixin_appid',1546962555),(83,'','AppSecret	','小程序密钥','请填写appsecret','common','common_app_mini_weixin_appsecret',1546962555),(84,'ShopXO','名称','','请填写名称','common','common_app_mini_weixin_title',1546962555),(85,'国内领先企业级B2C开源电商系统！','描述','','请填写描述','common','common_app_mini_weixin_describe',1546962555);
/*!40000 ALTER TABLE `cms_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_custom_view`
--

DROP TABLE IF EXISTS `cms_custom_view`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_custom_view` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `is_header` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否包含头部（0否, 1是）',
  `is_footer` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否包含尾部（0否, 1是）',
  `is_full_screen` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否满屏（0否, 1是）',
  `image` text COMMENT '图片数据（一维数组json）',
  `image_count` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文章图片数量',
  `access_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `is_enable` (`is_enable`),
  KEY `access_count` (`access_count`),
  KEY `image_count` (`image_count`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='自定义页面';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_custom_view`
--

LOCK TABLES `cms_custom_view` WRITE;
/*!40000 ALTER TABLE `cms_custom_view` DISABLE KEYS */;
INSERT INTO `cms_custom_view` VALUES (1,'测试自定义页面22','<p><img src=\"/static/upload/images/customview/image/2018/08/09/1533779966550231.jpeg\" title=\"1533779966550231.jpeg\" alt=\"1.jpeg\"/></p><p><span style=\"color: rgb(255, 0, 0);\">ShopXO</span></p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \">秀，身材苗条！</span></p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \"><br/></p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><br/></p>',1,0,0,0,'',0,766,1484965691,1545320526);
/*!40000 ALTER TABLE `cms_custom_view` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_express`
--

DROP TABLE IF EXISTS `cms_express`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_express` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `icon` char(255) NOT NULL DEFAULT '' COMMENT 'icon图标',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='快递公司';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_express`
--

LOCK TABLES `cms_express` WRITE;
/*!40000 ALTER TABLE `cms_express` DISABLE KEYS */;
INSERT INTO `cms_express` VALUES (1,0,'/static/upload/images/express/images/20180917104528_logo.png','顺丰快递',1,0,1526350443,1552542585),(2,0,'/static/upload/images/express/images/20180917104538_logo.png','圆通快递',1,0,1526350453,1537152338),(3,0,'/static/upload/images/express/images/20180917104550_logo.png','申通快递',1,0,1526350461,1537152350),(4,0,'/static/upload/images/express/images/20180917104559_logo.png','中通快递',1,0,1526350469,1537152359),(5,0,'/static/upload/images/express/images/20180917104839_logo.png','EMS速递',1,0,1530429633,1537152519),(6,0,'/static/upload/images/express/images/20180917104631_logo.png','韵达快递',1,0,1530429687,1537152391),(7,0,'/static/upload/images/express/images/20180917104848_logo.png','邮政包裹',1,0,1530429743,1537152528),(8,0,'/static/upload/images/express/images/20180917104816_logo.png','百世汇通',1,0,1530429765,1537152496),(9,0,'/static/upload/images/express/images/20180917104616_logo.png','国通快递',1,0,1530429794,1537152376),(10,0,'/static/upload/images/express/images/20180917104650_logo.png','天天快递',1,0,1530429830,1537152410),(11,0,'/static/upload/images/express/images/20180917104707_logo.png','优速快递',1,0,1530429855,1537152427),(12,0,'/static/upload/images/express/images/20180917104722_logo.png','全峰快递',1,0,1530429873,1537152442),(13,0,'/static/upload/images/express/images/20180917104750_logo.png','宅急送',1,0,1530429907,1537152470),(14,0,'/static/upload/images/express/images/20180917104757_logo.png','京东快递',1,0,1530429926,1537152477);
/*!40000 ALTER TABLE `cms_express` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods`
--

DROP TABLE IF EXISTS `cms_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `brand_id` int(11) unsigned DEFAULT '0' COMMENT '品牌id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '标题',
  `title_color` char(7) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `model` char(30) NOT NULL DEFAULT '' COMMENT '型号',
  `country_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '国家id(0代表中国 其他代表外国)',
  `place_origin` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产地（地区省id）',
  `inventory` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '库存（所有规格库存总和）',
  `inventory_unit` char(15) NOT NULL DEFAULT '' COMMENT '库存单位',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '封面图片',
  `original_price` char(60) NOT NULL DEFAULT '' COMMENT '原价（单值:10, 区间:10.00-20.00）一般用于展示使用',
  `min_original_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最低原价',
  `max_original_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最大原价',
  `price` char(60) NOT NULL DEFAULT '' COMMENT '销售价格（单值:10, 区间:10.00-20.00）一般用于展示使用',
  `min_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最低价格',
  `max_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最高价格',
  `give_integral` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买赠送积分',
  `buy_min_number` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '最低起购数量 （默认1）',
  `buy_max_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最大购买数量（最大数值 100000000, 小于等于0或空则不限）',
  `is_deduction_inventory` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '是否扣减库存（0否, 1是）',
  `is_shelves` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架（下架后用户不可见, 0否, 1是）',
  `is_home_recommended` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页推荐（0否, 1是）',
  `goods_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '商品状态(0审核中,1审核通过,2审核拒绝)',
  `is_seckill` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否秒杀（0否, 1是）',
  `seckill_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '秒杀状态(0审核中,1审核通过,2审核拒绝,3秒杀活动结束)',
  `seckill_stime` int(11) NOT NULL DEFAULT '0' COMMENT '秒杀起止时间',
  `seckill_etime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '秒杀结束时间',
  `content_web` mediumtext NOT NULL COMMENT '电脑端详情内容',
  `photo_count` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '相册图片数量',
  `sales_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `access_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `video` char(255) NOT NULL DEFAULT '' COMMENT '短视频',
  `home_recommended_images` char(255) NOT NULL DEFAULT '' COMMENT '首页推荐图片',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '99' COMMENT '商品排序',
  `is_delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否已删除（0 未删除, 大于0则是删除时间）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `access_count` (`access_count`),
  KEY `photo_count` (`photo_count`),
  KEY `is_shelves` (`is_shelves`),
  KEY `goods_status` (`goods_status`),
  KEY `seckill_status` (`seckill_status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods`
--

LOCK TABLES `cms_goods` WRITE;
/*!40000 ALTER TABLE `cms_goods` DISABLE KEYS */;
INSERT INTO `cms_goods` VALUES (1,1,'MIUI/小米 小米手机4 小米4代 MI4智能4G手机包邮 黑色 D-LTE（4G）/TD-SCD','','',0,0,125,'步','/static/upload/images/goods/2019/01/14/1547450781101144.jpg','3200.00',3200.00,3200.00,'2100.00',2100.00,2100.00,10,1,0,1,1,1,0,0,0,0,0,'<p><img src=\"/static/upload/images/goods/2019/01/14/1547450880620837.png\" title=\"1547450880620837.png\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547450880750687.png\" title=\"1547450880750687.png\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547450880917418.png\" title=\"1547450880917418.png\"/></p><p><br/></p>',2,0,10,'','/static/upload/images/goods/2019/01/14/1547450781101144.jpg',99,0,1547450921,1549959519),(2,2,'苹果（Apple）iPhone 6 Plus (A1524)移动联通电信4G手机 金色 16G','','iPhone 6 Plus',0,0,1711,'步','/static/upload/images/goods/2019/01/14/1547451274847894.jpg','6000.00-7600.00',6000.00,7600.00,'4500.00-6800.00',4500.00,6800.00,30,1,0,1,1,1,0,0,0,0,0,'<p><img src=\"/static/upload/images/goods/2019/01/14/1547451595700972.jpg\" title=\"1547451595700972.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547451595528800.jpg\" title=\"1547451595528800.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547451595616298.jpg\" title=\"1547451595616298.jpg\"/></p><p><br/></p>',2,0,12,'/static/upload/video/goods/2019/01/14/1547458876723311.mp4','/static/upload/images/goods/2019/01/14/1547451274847894.jpg',99,0,1547451624,1547458880),(3,2,'Samsung/三星 SM-G8508S GALAXY Alpha四核智能手机 新品 闪耀白','','',0,0,235,'步','/static/upload/images/goods/2019/01/14/1547451909951171.jpg','6866.00',6866.00,6866.00,'3888.00',3888.00,3888.00,20,1,0,1,1,1,0,0,0,0,0,'<p><img src=\"/static/upload/images/goods/2019/01/14/1547451947383902.jpg\" title=\"1547451947383902.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547451947686990.jpg\" title=\"1547451947686990.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547451947676180.jpg\" title=\"1547451947676180.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547451947791154.jpg\" title=\"1547451947791154.jpg\"/></p><p><br/></p>',2,0,6,'','/static/upload/images/goods/2019/01/14/1547451909951171.jpg',99,0,1547452007,1547452007),(4,1,'Huawei/华为 H60-L01 荣耀6 移动4G版智能手机 安卓','','',0,0,537,'步','/static/upload/images/goods/2019/01/14/1547452474332334.jpg','2300.00',2300.00,2300.00,'1999.00',1999.00,1999.00,19,1,0,1,1,1,0,0,0,0,0,'<p><img src=\"/static/upload/images/goods/2019/01/14/1547452505568604.jpg\" title=\"1547452505568604.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547452505349986.jpg\" title=\"1547452505349986.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/01/14/1547452505184884.jpg\" title=\"1547452505184884.jpg\"/></p><p><br/></p>',2,0,52,'','/static/upload/images/goods/2019/01/14/1547452474332334.jpg',99,0,1547452553,1547452553),(5,3,'太阳能插座8888xx','','88888XX',0,19,888,'个','/static/upload/images/goods/2019/03/19/1552976530589777.jpg','168.00',168.00,168.00,'88.00',88.00,88.00,88,1,0,1,1,0,0,0,0,0,0,'<p><img src=\"/static/upload/images/goods/2019/03/19/1552976550732905.jpg\" title=\"1552976550732905.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/03/19/1552976551956267.jpg\" title=\"1552976551956267.jpg\"/></p><p><img src=\"/static/upload/images/goods/2019/03/19/1552976551523244.jpg\" title=\"1552976551523244.jpg\"/></p><p><br/></p>',1,0,5,'','',99,0,1552976554,1553499031);
/*!40000 ALTER TABLE `cms_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_browse`
--

DROP TABLE IF EXISTS `cms_goods_browse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_browse` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户商品浏览';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_browse`
--

LOCK TABLES `cms_goods_browse` WRITE;
/*!40000 ALTER TABLE `cms_goods_browse` DISABLE KEYS */;
INSERT INTO `cms_goods_browse` VALUES (1,5,90,1552534768,1552546057),(2,6,90,1552535075,1552535075),(3,7,90,1552535128,1552540174),(4,2,90,1552542516,1552548176),(5,4,90,1552545267,1552545267),(6,1,90,1552547836,1552547836);
/*!40000 ALTER TABLE `cms_goods_browse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_category`
--

DROP TABLE IF EXISTS `cms_goods_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `icon` char(255) NOT NULL DEFAULT '' COMMENT 'icon图标',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '名称',
  `vice_name` char(80) NOT NULL DEFAULT '' COMMENT '副标题',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '描述',
  `bg_color` char(30) NOT NULL DEFAULT '' COMMENT 'css背景色值',
  `big_images` char(255) NOT NULL DEFAULT '' COMMENT '大图片',
  `is_home_recommended` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页推荐（0否, 1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `is_enable` (`is_enable`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=895 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_category`
--

LOCK TABLES `cms_goods_category` WRITE;
/*!40000 ALTER TABLE `cms_goods_category` DISABLE KEYS */;
INSERT INTO `cms_goods_category` VALUES (1,0,'/static/upload/images/goods_category/2018/08/20180814174251211789.png','数码办公','天天新品，科技带来快乐！','iphoneX新品发布了','#ffe4ed','/static/upload/images/goods_category/2018/08/20180814180843848554.png',1,0,1,1529042764,1545361721),(58,1,'/static/upload/images/goods_category/2018/11/20/2018112015245128143.jpeg','手机通讯','','','','',1,0,1,1529042764,1542698691),(59,1,'/static/upload/images/goods_category/2018/11/20/2018112015273175122.jpeg','手机配件','','','','',1,0,1,1529042764,1542698851),(60,1,'/static/upload/images/goods_category/2018/11/20/2018112015252193663.jpeg','摄影摄像','','','','',1,0,1,1529042764,1542698721),(61,1,'/static/upload/images/goods_category/2018/11/20/2018112015441996472.jpeg','时尚影音','','','','',1,0,1,1529042764,1542699859),(62,1,'/static/upload/images/goods_category/2018/11/20/2018112015255390903.jpeg','电脑整机','','','','',1,0,1,1529042764,1542698753),(63,1,'','电脑配件','','','','',1,0,1,1529042764,1534240077),(64,1,'','外设产品','','','','',1,0,1,1529042764,1534240077),(65,1,'','网络产品','','','','',1,0,1,1529042764,1534240077),(66,1,'','办公打印','','','','',1,0,1,1529042764,1534240077),(67,1,'','办公文仪','','','','',1,0,1,1529042764,1534240077),(68,58,'','手机','','','','',1,0,1,1529042764,0),(69,58,'','合约机','','','','',1,0,1,1529042764,0),(70,58,'','对讲机','','','','',1,0,1,1529042764,0),(71,59,'','手机电池','','','','',1,0,1,1529042764,0),(72,59,'','蓝牙耳机','','','','',1,0,1,1529042764,0),(73,59,'','充电器/数据线','','','','',1,0,1,1529042764,0),(74,59,'','手机耳机','','','','',1,0,1,1529042764,0),(75,59,'','手机贴膜','','','','',1,0,1,1529042764,0),(76,59,'','手机存储卡','','','','',1,0,1,1529042764,0),(77,59,'','手机保护套','','','','',1,0,1,1529042764,0),(78,59,'','车载配件','','','','',1,0,1,1529042764,0),(79,59,'','iPhone','','','','',1,0,1,1529042764,0),(80,59,'','配件','','','','',1,0,1,1529042764,0),(81,59,'','创意配件','','','','',1,0,1,1529042764,0),(82,59,'','便携/无线音响','','','','',1,0,1,1529042764,0),(83,59,'','手机饰品','','','','',1,0,1,1529042764,0),(84,60,'','数码相机','','','','',1,0,1,1529042764,0),(85,60,'','单电/微单相机','','','','',1,0,1,1529042764,0),(86,60,'','单反相机','','','','',1,0,1,1529042764,0),(87,60,'','摄像机','','','','',1,0,1,1529042764,0),(88,60,'','拍立得','','','','',1,0,1,1529042764,0),(89,60,'','镜头','','','','',1,0,1,1529042764,0),(90,102,'','存储卡','','','','',1,0,1,1529042764,0),(91,102,'','读卡器','','','','',1,0,1,1529042764,0),(92,102,'','滤镜','','','','',1,0,1,1529042764,0),(93,102,'','闪光灯/手柄','','','','',1,0,1,1529042764,0),(94,102,'','相机包','','','','',1,0,1,1529042764,0),(95,102,'','三脚架/云台','','','','',1,0,1,1529042764,0),(96,102,'','相机清洁','','','','',1,0,1,1529042764,0),(97,102,'','相机贴膜','','','','',1,0,1,1529042764,0),(98,102,'','机身附件','','','','',1,0,1,1529042764,0),(99,102,'','镜头附件','','','','',1,0,1,1529042764,0),(100,102,'','电池/充电器','','','','',1,0,1,1529042764,0),(101,102,'','移动电源','','','','',1,0,1,1529042764,0),(102,1,'','数码配件','','','','',1,0,1,1529042764,0),(103,61,'','MP3/MP4','','','','',1,0,1,1529042764,0),(104,61,'','智能设备','','','','',1,0,1,1529042764,0),(105,61,'','耳机/耳麦','','','','',1,0,1,1529042764,0),(106,61,'','音箱','','','','',1,0,1,1529042764,0),(107,61,'','高清播放器','','','','',1,0,1,1529042764,0),(108,61,'','电子书','','','','',1,0,1,1529042764,0),(109,61,'','电子词典','','','','',1,0,1,1529042764,0),(110,61,'','MP3/MP4配件','','','','',1,0,1,1529042764,0),(111,61,'','录音笔','','','','',1,0,1,1529042764,0),(112,61,'','麦克风','','','','',1,0,1,1529042764,0),(113,61,'','专业音频','','','','',1,0,1,1529042764,0),(114,61,'','电子教育','','','','',1,0,1,1529042764,0),(115,61,'','数码相框','','','','',1,0,1,1529042764,0),(116,62,'','笔记本','','','','',1,0,1,1529042764,0),(117,62,'','超极本','','','','',1,0,1,1529042764,0),(118,62,'','游戏本','','','','',1,0,1,1529042764,0),(119,62,'','平板电脑','','','','',1,0,1,1529042764,0),(120,62,'','平板电脑配件','','','','',1,0,1,1529042764,0),(121,62,'','台式机','','','','',1,0,1,1529042764,0),(122,62,'','服务器','','','','',1,0,1,1529042764,0),(123,62,'','笔记本配件','','','','',1,0,1,1529042764,0),(124,63,'','CPU','','','','',1,0,1,1529042764,0),(125,63,'','主板','','','','',1,0,1,1529042764,0),(126,63,'','显卡','','','','',1,0,1,1529042764,0),(127,63,'','硬盘','','','','',1,0,1,1529042764,0),(128,63,'','SSD固态硬盘','','','','',1,0,1,1529042764,0),(129,63,'','内存','','','','',1,0,1,1529042764,0),(130,63,'','机箱','','','','',1,0,1,1529042764,0),(131,63,'','电源','','','','',1,0,1,1529042764,0),(132,63,'','显示器','','','','',1,0,1,1529042764,0),(133,63,'','刻录机/光驱','','','','',1,0,1,1529042764,0),(134,63,'','散热器','','','','',1,0,1,1529042764,0),(135,63,'','声卡/扩展卡','','','','',1,0,1,1529042764,0),(136,63,'','装机配件','','','','',1,0,1,1529042764,0),(137,64,'','鼠标','','','','',1,0,1,1529042764,0),(138,64,'','键盘','','','','',1,0,1,1529042764,0),(139,64,'','移动硬盘','','','','',1,0,1,1529042764,0),(140,64,'','U盘','','','','',1,0,1,1529042764,0),(141,64,'','摄像头','','','','',1,0,1,1529042764,0),(142,64,'','外置盒','','','','',1,0,1,1529042764,0),(143,64,'','游戏设备','','','','',1,0,1,1529042764,0),(144,64,'','电视盒','','','','',1,0,1,1529042764,0),(145,64,'','手写板','','','','',1,0,1,1529042764,0),(146,64,'','鼠标垫','','','','',1,0,1,1529042764,0),(147,64,'','插座','','','','',1,0,1,1529042764,0),(148,64,'','UPS电源','','','','',1,0,1,1529042764,0),(149,64,'','线缆','','','','',1,0,1,1529042764,0),(150,64,'','电脑工具','','','','',1,0,1,1529042764,0),(151,64,'','电脑清洁','','','','',1,0,1,1529042764,0),(152,65,'','路由器','','','','',1,0,1,1529042764,0),(153,65,'','网卡','','','','',1,0,1,1529042764,0),(154,65,'','交换机','','','','',1,0,1,1529042764,0),(155,65,'','网络存储','','','','',1,0,1,1529042764,0),(156,65,'','3G上网','','','','',1,0,1,1529042764,0),(157,65,'','网络盒子','','','','',1,0,1,1529042764,0),(158,66,'','打印机','','','','',1,0,1,1529042764,0),(159,66,'','一体机','','','','',1,0,1,1529042764,0),(160,66,'','投影机','','','','',1,0,1,1529042764,0),(161,66,'','投影配件','','','','',1,0,1,1529042764,0),(162,66,'','传真机','','','','',1,0,1,1529042764,0),(163,66,'','复合机','','','','',1,0,1,1529042764,0),(164,66,'','碎纸机','','','','',1,0,1,1529042764,0),(165,66,'','扫描仪','','','','',1,0,1,1529042764,0),(166,66,'','墨盒','','','','',1,0,1,1529042764,0),(167,66,'','硒鼓','','','','',1,0,1,1529042764,0),(168,66,'','墨粉','','','','',1,0,1,1529042764,0),(169,66,'','色带','','','','',1,0,1,1529042764,0),(170,67,'','办公文具','','','','',1,0,1,1529042764,0),(171,67,'','文件管理','','','','',1,0,1,1529042764,0),(172,67,'','笔类','','','','',1,0,1,1529042764,0),(173,67,'','纸类','','','','',1,0,1,1529042764,0),(174,67,'','本册/便签','','','','',1,0,1,1529042764,0),(175,67,'','学生文具','','','','',1,0,1,1529042764,0),(176,67,'','财务用品','','','','',1,0,1,1529042764,0),(177,67,'','计算器','','','','',1,0,1,1529042764,0),(178,67,'','激光笔','','','','',1,0,1,1529042764,0),(179,67,'','白板/封装','','','','',1,0,1,1529042764,0),(180,67,'','考勤机','','','','',1,0,1,1529042764,0),(181,67,'','刻录碟片/附件','','','','',1,0,1,1529042764,0),(182,67,'','点钞机','','','','',1,0,1,1529042764,0),(183,67,'','支付设备/POS机','','','','',1,0,1,1529042764,0),(184,67,'','安防监控','','','','',1,0,1,1529042764,0),(185,67,'','呼叫/会议设备','','','','',1,0,1,1529042764,0),(186,67,'','保险柜','','','','',1,0,1,1529042764,0),(187,67,'','办公家具','','','','',1,0,1,1529042764,0),(893,0,'/static/upload/images/goods_category/2019/03/19/1552975952623547.jpg','再生能源','太阳能','用阳光','','/static/upload/images/goods_category/2019/03/19/1552975961250405.jpg',0,0,1,1552976072,0),(894,893,'','太阳能系列','','','','',0,0,1,1552976308,0);
/*!40000 ALTER TABLE `cms_goods_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_category_join`
--

DROP TABLE IF EXISTS `cms_goods_category_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_category_join` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `add_time` int(11) unsigned DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分类关联';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_category_join`
--

LOCK TABLES `cms_goods_category_join` WRITE;
/*!40000 ALTER TABLE `cms_goods_category_join` DISABLE KEYS */;
INSERT INTO `cms_goods_category_join` VALUES (6,3,68,1547452007),(7,3,69,1547452007),(8,4,68,1547452553),(9,4,69,1547452553),(14,6,68,1547453157),(15,6,69,1547453157),(18,8,195,1547454269),(19,8,198,1547454269),(21,9,363,1547454828),(22,10,304,1547455375),(23,10,318,1547455375),(24,10,446,1547455375),(25,11,304,1547455700),(26,11,318,1547455700),(29,2,68,1547458880),(30,2,69,1547458880),(37,1,68,1547485917),(42,7,194,1547540607),(43,7,196,1547540607),(56,12,304,1551064315),(57,12,318,1551064315),(59,5,894,1552979058);
/*!40000 ALTER TABLE `cms_goods_category_join` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_content_app`
--

DROP TABLE IF EXISTS `cms_goods_content_app`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_content_app` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '图片',
  `content` text COMMENT '内容',
  `sort` tinyint(3) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品手机详情';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_content_app`
--

LOCK TABLES `cms_goods_content_app` WRITE;
/*!40000 ALTER TABLE `cms_goods_content_app` DISABLE KEYS */;
INSERT INTO `cms_goods_content_app` VALUES (10,3,'/static/upload/images/goods/2019/01/14/1547451947383902.jpg','',0,1547452007),(11,3,'/static/upload/images/goods/2019/01/14/1547451947686990.jpg','',1,1547452007),(12,3,'/static/upload/images/goods/2019/01/14/1547451947676180.jpg','',2,1547452007),(13,3,'/static/upload/images/goods/2019/01/14/1547451947791154.jpg','',3,1547452007),(14,4,'/static/upload/images/goods/2019/01/14/1547452505568604.jpg','',0,1547452553),(15,4,'/static/upload/images/goods/2019/01/14/1547452505349986.jpg','',1,1547452553),(16,4,'/static/upload/images/goods/2019/01/14/1547452505184884.jpg','',2,1547452553),(46,2,'/static/upload/images/goods/2019/01/14/1547451595700972.jpg','',0,1547458880),(47,2,'/static/upload/images/goods/2019/01/14/1547451595528800.jpg','',1,1547458880),(48,2,'/static/upload/images/goods/2019/01/14/1547451595616298.jpg','',2,1547458880),(61,1,'/static/upload/images/goods/2019/01/14/1547450880620837.png','',0,1547485917),(62,1,'/static/upload/images/goods/2019/01/14/1547450880750687.png','',1,1547485917),(63,1,'/static/upload/images/goods/2019/01/14/1547450880917418.png','',2,1547485917);
/*!40000 ALTER TABLE `cms_goods_content_app` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_coupon`
--

DROP TABLE IF EXISTS `cms_goods_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '优惠券名称',
  `pirce` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠券价格',
  `full_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '满xx元可以用 0代表无限制',
  `number` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '优惠券数量',
  `effective_time` int(11) DEFAULT '0' COMMENT '有效时间',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_coupon`
--

LOCK TABLES `cms_goods_coupon` WRITE;
/*!40000 ALTER TABLE `cms_goods_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_goods_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_favor`
--

DROP TABLE IF EXISTS `cms_goods_favor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_favor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户商品收藏';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_favor`
--

LOCK TABLES `cms_goods_favor` WRITE;
/*!40000 ALTER TABLE `cms_goods_favor` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_goods_favor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_in_storage`
--

DROP TABLE IF EXISTS `cms_goods_in_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_in_storage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `storage_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入库仓库id',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入库人id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '入库商品标题',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '入库商品描述',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品入库表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_in_storage`
--

LOCK TABLES `cms_goods_in_storage` WRITE;
/*!40000 ALTER TABLE `cms_goods_in_storage` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_goods_in_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_in_storage_detail`
--

DROP TABLE IF EXISTS `cms_goods_in_storage_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_in_storage_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `storage_in_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属商品出入库id',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `region_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '国家id(0代表中国，其他代表国外)',
  `brand_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '商品名称',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `price` char(60) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '商品描述',
  `number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品总数量',
  `remark` char(255) NOT NULL DEFAULT '' COMMENT '备注',
  `is_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '是否已删除（0 未删除, 大于0则是删除时间）',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期',
  `updtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新日期',
  PRIMARY KEY (`id`),
  KEY `storage_id` (`storage_in_id`),
  KEY `region_id` (`region_id`),
  KEY `brand_id` (`brand_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品入库调拨明细表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_in_storage_detail`
--

LOCK TABLES `cms_goods_in_storage_detail` WRITE;
/*!40000 ALTER TABLE `cms_goods_in_storage_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_goods_in_storage_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_out_storage`
--

DROP TABLE IF EXISTS `cms_goods_out_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_out_storage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `storage_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出库仓库id',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出库操作人id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '出库商品标题',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '出库商品描述',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品出库表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_out_storage`
--

LOCK TABLES `cms_goods_out_storage` WRITE;
/*!40000 ALTER TABLE `cms_goods_out_storage` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_goods_out_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_out_storage_detail`
--

DROP TABLE IF EXISTS `cms_goods_out_storage_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_out_storage_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `storage_in_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属商品出入库id',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `region_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '国家id(0代表中国，其他代表国外)',
  `brand_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '商品名称',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `price` char(60) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '商品描述',
  `number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品总数量',
  `remark` char(255) NOT NULL DEFAULT '' COMMENT '备注',
  `is_delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '是否已删除（0 未删除, 大于0则是删除时间）',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期',
  `updtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新日期',
  PRIMARY KEY (`id`),
  KEY `storage_id` (`storage_in_id`),
  KEY `region_id` (`region_id`),
  KEY `brand_id` (`brand_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品出库调拨明细表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_out_storage_detail`
--

LOCK TABLES `cms_goods_out_storage_detail` WRITE;
/*!40000 ALTER TABLE `cms_goods_out_storage_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_goods_out_storage_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_photo`
--

DROP TABLE IF EXISTS `cms_goods_photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_photo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '图片',
  `is_show` tinyint(3) unsigned DEFAULT '1' COMMENT '是否显示（0否, 1是）',
  `sort` tinyint(3) unsigned DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`),
  KEY `is_show` (`is_show`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品相册图片';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_photo`
--

LOCK TABLES `cms_goods_photo` WRITE;
/*!40000 ALTER TABLE `cms_goods_photo` DISABLE KEYS */;
INSERT INTO `cms_goods_photo` VALUES (7,3,'/static/upload/images/goods/2019/01/14/1547451909951171.jpg',1,0,1547452007),(8,3,'/static/upload/images/goods/2019/01/14/1547451936230948.jpg',1,1,1547452007),(9,4,'/static/upload/images/goods/2019/01/14/1547452474332334.jpg',1,0,1547452553),(10,4,'/static/upload/images/goods/2019/01/14/1547452496713777.jpg',1,1,1547452553),(35,2,'/static/upload/images/goods/2019/01/14/1547451274847894.jpg',1,0,1547458880),(36,2,'/static/upload/images/goods/2019/01/14/1547451576558478.jpg',1,1,1547458880),(48,1,'/static/upload/images/goods/2019/01/14/1547450781101144.jpg',1,0,1547485917),(49,1,'/static/upload/images/goods/2019/01/14/1547450818141662.jpg',1,1,1547485917),(51,5,'/static/upload/images/goods/2019/03/19/1552976530589777.jpg',1,0,1552979058);
/*!40000 ALTER TABLE `cms_goods_photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_recommend`
--

DROP TABLE IF EXISTS `cms_goods_recommend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_recommend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '推荐商品标题',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '推荐商品图片地址',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '推荐商品链接地址',
  `sort` tinyint(3) DEFAULT '0' COMMENT '排序',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品推荐表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_recommend`
--

LOCK TABLES `cms_goods_recommend` WRITE;
/*!40000 ALTER TABLE `cms_goods_recommend` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_goods_recommend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_spec_base`
--

DROP TABLE IF EXISTS `cms_goods_spec_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_spec_base` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价格',
  `inventory` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `weight` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '重量（kg） ',
  `coding` char(80) NOT NULL DEFAULT '' COMMENT '编码',
  `barcode` char(80) NOT NULL DEFAULT '' COMMENT '条形码',
  `original_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `attribute_type_id` (`price`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品规格基础';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_spec_base`
--

LOCK TABLES `cms_goods_spec_base` WRITE;
/*!40000 ALTER TABLE `cms_goods_spec_base` DISABLE KEYS */;
INSERT INTO `cms_goods_spec_base` VALUES (21,3,3888.00,235,0.00,'','',6866.00,1547452007),(22,4,1999.00,537,0.00,'','',2300.00,1547452553),(53,2,6050.00,100,0.00,'','',6800.00,1547458880),(54,2,6600.00,200,0.00,'','',7200.00,1547458880),(55,2,6800.00,300,0.00,'','',7600.00,1547458880),(56,2,6050.00,300,0.00,'','',6800.00,1547458880),(57,2,6600.00,300,0.00,'','',7200.00,1547458880),(58,2,6800.00,300,0.00,'','',7600.00,1547458880),(59,2,4500.00,100,0.00,'','',6800.00,1547458880),(60,2,4800.00,50,0.00,'','',6600.00,1547458880),(61,2,5500.00,61,0.00,'','',6000.00,1547458880),(71,1,2100.00,125,0.00,'','',3200.00,1547485917),(73,5,88.00,888,0.30,'654321','13215531031313',168.00,1552979058);
/*!40000 ALTER TABLE `cms_goods_spec_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_spec_type`
--

DROP TABLE IF EXISTS `cms_goods_spec_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_spec_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `value` text NOT NULL COMMENT '类型值（json字符串存储）',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '类型名称',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品规格类型';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_spec_type`
--

LOCK TABLES `cms_goods_spec_type` WRITE;
/*!40000 ALTER TABLE `cms_goods_spec_type` DISABLE KEYS */;
INSERT INTO `cms_goods_spec_type` VALUES (13,2,'[{\"name\":\"\\u5957\\u9910\\u4e00\",\"images\":\"\"},{\"name\":\"\\u5957\\u9910\\u4e8c\",\"images\":\"\"}]','套餐',1547458880),(14,2,'[{\"name\":\"\\u91d1\\u8272\",\"images\":\"\\/static\\/upload\\/images\\/goods\\/2019\\/01\\/14\\/1547451274847894.jpg\"},{\"name\":\"\\u94f6\\u8272\",\"images\":\"\\/static\\/upload\\/images\\/goods\\/2019\\/01\\/14\\/1547451576558478.jpg\"}]','颜色',1547458880),(15,2,'[{\"name\":\"32G\",\"images\":\"\"},{\"name\":\"64G\",\"images\":\"\"},{\"name\":\"128G\",\"images\":\"\"}]','容量',1547458880);
/*!40000 ALTER TABLE `cms_goods_spec_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_spec_value`
--

DROP TABLE IF EXISTS `cms_goods_spec_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_spec_value` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_spec_base_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格基础id',
  `value` char(60) NOT NULL DEFAULT '' COMMENT '规格值',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`) USING BTREE,
  KEY `goods_spec_base_id` (`goods_spec_base_id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='商品规格值';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_spec_value`
--

LOCK TABLES `cms_goods_spec_value` WRITE;
/*!40000 ALTER TABLE `cms_goods_spec_value` DISABLE KEYS */;
INSERT INTO `cms_goods_spec_value` VALUES (104,2,53,'套餐一',1547458880),(105,2,53,'金色',1547458880),(106,2,53,'32G',1547458880),(107,2,54,'套餐一',1547458880),(108,2,54,'金色',1547458880),(109,2,54,'64G',1547458880),(110,2,55,'套餐一',1547458880),(111,2,55,'金色',1547458880),(112,2,55,'128G',1547458880),(113,2,56,'套餐一',1547458880),(114,2,56,'银色',1547458880),(115,2,56,'32G',1547458880),(116,2,57,'套餐一',1547458880),(117,2,57,'银色',1547458880),(118,2,57,'64G',1547458880),(119,2,58,'套餐一',1547458880),(120,2,58,'银色',1547458880),(121,2,58,'128G',1547458880),(122,2,59,'套餐二',1547458880),(123,2,59,'金色',1547458880),(124,2,59,'32G',1547458880),(125,2,60,'套餐二',1547458880),(126,2,60,'金色',1547458880),(127,2,60,'128G',1547458880),(128,2,61,'套餐二',1547458880),(129,2,61,'银色',1547458880),(130,2,61,'64G',1547458880);
/*!40000 ALTER TABLE `cms_goods_spec_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_goods_storage_spec`
--

DROP TABLE IF EXISTS `cms_goods_storage_spec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_goods_storage_spec` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `storage_detail_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对于出入库明细表id',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价格',
  `inventory` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `weight` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '重量（kg） ',
  `coding` char(80) NOT NULL DEFAULT '' COMMENT '编码',
  `barcode` char(80) NOT NULL DEFAULT '' COMMENT '条形码',
  `original_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `price` (`price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='出入库商品规格基础表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_goods_storage_spec`
--

LOCK TABLES `cms_goods_storage_spec` WRITE;
/*!40000 ALTER TABLE `cms_goods_storage_spec` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_goods_storage_spec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_link`
--

DROP TABLE IF EXISTS `cms_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '导航名称',
  `url` char(255) NOT NULL DEFAULT '' COMMENT 'url地址',
  `describe` char(60) NOT NULL DEFAULT '' COMMENT '描述',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `is_new_window_open` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否新窗口打开（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='友情链接';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_link`
--

LOCK TABLES `cms_link` WRITE;
/*!40000 ALTER TABLE `cms_link` DISABLE KEYS */;
INSERT INTO `cms_link` VALUES (1,'SchoolCMS','http://schoolcms.org/','SchoolCMS学校教务管理系统',1,1,1,1486292373,0),(12,'AmazeUI','http://amazeui.org/','AmazeUI国内首个HTML5框架',4,1,1,1486353476,0),(13,'龚哥哥的博客','http://gong.gg/','龚哥哥的博客',2,1,1,1486353528,0),(14,'ThinkPHP','http://www.thinkphp.cn/','ThinkPHP',3,1,1,1487919160,0),(15,'ShopXO','http://shopxo.net','ShopXO企业级B2C免费开源电商系统',0,1,1,1533711881,1547450275),(16,'码云','https://gitee.com/','代码托管平台',0,1,1,1547450105,0),(17,'GitHub','https://github.com/','代码托管平台',0,1,1,1547450145,0);
/*!40000 ALTER TABLE `cms_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_message`
--

DROP TABLE IF EXISTS `cms_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '标题',
  `detail` char(255) NOT NULL DEFAULT '' COMMENT '详情',
  `business_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '业务id',
  `business_type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '业务类型（0默认, 1订单, ...）',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '消息类型（0普通通知, ...）',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否已读（0否, 1是）',
  `is_delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否已删除（0否, 大于0删除时间）',
  `user_is_delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否已删除（0否, 大于0删除时间）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='消息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_message`
--

LOCK TABLES `cms_message` WRITE;
/*!40000 ALTER TABLE `cms_message` DISABLE KEYS */;
INSERT INTO `cms_message` VALUES (1,90,'积分变动','登录奖励积分积分增加5',0,0,0,1,0,0,1552534767),(2,90,'订单取消','订单取消成功',2,1,0,0,0,0,1552893652),(3,90,'积分变动','管理员操作积分增加950',0,0,0,0,0,0,1553055728),(4,77,'积分变动','管理员操作积分增加9018',0,0,0,0,0,0,1553060998),(5,90,'积分变动','管理员操作积分减少999',0,0,0,0,0,0,1553061666),(6,77,'积分变动','管理员操作积分减少9000',0,0,0,0,0,0,1553062119),(7,90,'积分变动','管理员操作积分增加999',0,0,0,0,0,0,1553063879),(8,93,'积分变动','管理员操作积分增加1000',0,0,0,0,0,0,1553064903),(9,93,'积分变动','管理员操作积分减少1',0,0,0,0,0,0,1553072975),(10,93,'积分变动','管理员操作积分增加51203',0,0,0,0,0,0,1553075995),(11,77,'积分变动','管理员操作积分减少989',0,0,0,0,0,0,1553076005),(12,77,'积分变动','管理员操作积分增加18',0,0,0,0,0,0,1553134328),(13,90,'订单取消','订单取消成功',1,1,0,0,0,0,1553240177);
/*!40000 ALTER TABLE `cms_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_navigation`
--

DROP TABLE IF EXISTS `cms_navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_navigation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '导航名称',
  `url` char(255) NOT NULL DEFAULT '' COMMENT 'url地址',
  `value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `data_type` char(30) NOT NULL DEFAULT '' COMMENT '数据类型（custom:自定义导航, article_class:文章分类, customview:自定义页面）',
  `nav_type` char(30) NOT NULL DEFAULT '' COMMENT '导航类型（header:顶部导航, footer:底部导航）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示（0否，1是）',
  `is_new_window_open` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否新窗口打开（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `is_show` (`is_show`),
  KEY `sort` (`sort`),
  KEY `nav_type` (`nav_type`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='导航';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_navigation`
--

LOCK TABLES `cms_navigation` WRITE;
/*!40000 ALTER TABLE `cms_navigation` DISABLE KEYS */;
INSERT INTO `cms_navigation` VALUES (8,0,'自定义页面test','',1,'customview','header',0,1,0,1486352254,1545116379),(17,0,'ShopXO','http://shopxo.net/',0,'custom','header',10,1,1,1487923617,1533873171),(24,0,'数码办公','',1,'goods_category','header',0,1,0,1539150026,0),(27,0,'龚哥哥','http://gong.gg',0,'custom','footer',0,1,1,1539966837,1545117171),(28,0,'关于ShopXO','',29,'article','footer',0,1,0,1539966874,1539967033),(29,0,'联系我们','',28,'article','footer',0,1,0,1539966890,1539967042),(30,0,'合作及洽谈','',26,'article','footer',0,1,0,1539967020,1539967049),(31,0,'招聘英才','',27,'article','footer',0,1,0,1539967076,0);
/*!40000 ALTER TABLE `cms_navigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order`
--

DROP TABLE IF EXISTS `cms_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_no` char(60) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `shop_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `receive_address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收件地址id',
  `receive_name` char(60) NOT NULL DEFAULT '' COMMENT '收件人-姓名',
  `receive_tel` char(15) NOT NULL DEFAULT '' COMMENT '收件人-电话',
  `receive_province` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收件人-省',
  `receive_city` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收件人-市',
  `receive_county` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收件人-县/区',
  `receive_address` char(200) NOT NULL DEFAULT '' COMMENT '收件人-详细地址',
  `user_note` char(255) NOT NULL DEFAULT '' COMMENT '用户备注',
  `express_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '快递id',
  `express_number` char(60) NOT NULL DEFAULT '' COMMENT '快递单号',
  `payment_id` int(11) unsigned DEFAULT '0' COMMENT '支付方式id',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态（0待确认, 1已确认/待支付, 2已支付/待发货, 3已发货/待收货, 4已完成, 5已取消, 6已关闭, 7退货中,8换货中）',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态（0未支付, 1已支付, 2已退款）',
  `preferential_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单单价',
  `total_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总价(订单最终价格)',
  `pay_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已支付金额',
  `pay_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `confirm_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '确认时间',
  `delivery_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `cancel_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '取消时间',
  `collect_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货时间',
  `close_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关闭时间',
  `comments_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `is_comments` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家是否已评论（0否, 大于0评论时间）',
  `user_is_comments` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否已评论（0否, 大于0评论时间）',
  `is_delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家是否已删除（0否, 大于0删除时间）',
  `user_is_delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否已删除（0否, 大于0删除时间）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `user_id` (`user_id`),
  KEY `shop_id` (`shop_id`),
  KEY `status` (`status`),
  KEY `pay_status` (`pay_status`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order`
--

LOCK TABLES `cms_order` WRITE;
/*!40000 ALTER TABLE `cms_order` DISABLE KEYS */;
INSERT INTO `cms_order` VALUES (1,'20190314131309163206',90,0,1,'袁久林','13612923031',19,291,3059,'12312312','',0,'',1,4,0,0.00,168.00,168.00,0.00,0,1552540389,0,1553240177,0,0,0,0,0,0,0,1552540389,1521946097),(2,'20190314143512293364',90,0,1,'袁久林','13612923031',19,291,3059,'12312312','12312312312',0,'',1,4,0,0.00,1999.00,1999.00,0.00,0,1552545312,0,1552893652,0,0,0,0,0,0,0,1552545312,1521946097),(3,'20190314143512293365',90,0,1,'袁久林','13612923031',19,291,3059,'12312312','13212312310',0,'',1,4,0,0.00,1998.00,1998.00,0.00,0,1552545312,0,1552893654,0,0,0,0,0,0,0,1553184000,1553184000),(4,'20190314143512293369',0,0,0,'','',0,0,0,'','',0,'',0,4,0,0.00,0.00,200.00,0.00,0,0,0,1552893654,0,0,0,0,0,0,0,1553184000,1553483942),(5,'',0,0,0,'','',0,0,0,'','',0,'',0,4,0,0.00,0.00,150.00,0.00,0,0,0,0,0,0,0,0,0,0,0,1553084000,1553483942);
/*!40000 ALTER TABLE `cms_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_comments`
--

DROP TABLE IF EXISTS `cms_order_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `shop_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `content` char(255) NOT NULL DEFAULT '' COMMENT '评价内容',
  `rating` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '评价级别（默认0 1~5）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `shop_id` (`shop_id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单评价';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_comments`
--

LOCK TABLES `cms_order_comments` WRITE;
/*!40000 ALTER TABLE `cms_order_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_order_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_detail`
--

DROP TABLE IF EXISTS `cms_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `shop_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '标题',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '封面图片',
  `original_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单价格',
  `spec` char(255) NOT NULL DEFAULT '' COMMENT '规格',
  `buy_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `spec_weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '重量（kg）',
  `spec_coding` char(80) NOT NULL DEFAULT '' COMMENT '编码',
  `spec_barcode` char(80) NOT NULL DEFAULT '' COMMENT '条形码',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单详情';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_detail`
--

LOCK TABLES `cms_order_detail` WRITE;
/*!40000 ALTER TABLE `cms_order_detail` DISABLE KEYS */;
INSERT INTO `cms_order_detail` VALUES (1,90,1,7,0,'纽芝兰包包女士2018新款潮百搭韩版时尚单肩斜挎包少女小挎包链条','/static/upload/images/goods/2019/01/14/1547453895416529.jpg',760.00,168.00,'',1,0,'','',1552540389,0),(2,90,2,4,0,'Huawei/华为 H60-L01 荣耀6 移动4G版智能手机 安卓','/static/upload/images/goods/2019/01/14/1547452474332334.jpg',2300.00,1999.00,'',1,0,'','',1552545312,0);
/*!40000 ALTER TABLE `cms_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_exchange`
--

DROP TABLE IF EXISTS `cms_order_exchange`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_exchange` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_no` char(60) NOT NULL DEFAULT '' COMMENT '订单号',
  `refund_no` char(60) NOT NULL DEFAULT '' COMMENT '换货单号码',
  `cause` char(255) NOT NULL DEFAULT '' COMMENT '换货原因',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0申请中,1已通过,2已拒绝,3用户寄件中,4商家已收货,5商家寄件,6用户收货,5已完成,6已关闭',
  `application_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '申请时间',
  `audit_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核通过/拒绝时间',
  `reject_cause` char(255) NOT NULL DEFAULT '' COMMENT '拒绝原因',
  `delivery_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `collect_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收货时间',
  `close_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `express_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递id',
  `express_number` char(60) NOT NULL DEFAULT '' COMMENT '快递单号',
  `total_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总价格',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='换货单列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_exchange`
--

LOCK TABLES `cms_order_exchange` WRITE;
/*!40000 ALTER TABLE `cms_order_exchange` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_order_exchange` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_exchange_detail`
--

DROP TABLE IF EXISTS `cms_order_exchange_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_exchange_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `exchange_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '换货订单id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '商品标题',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '封面图片',
  `original_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单价格',
  `spec` char(255) NOT NULL DEFAULT '' COMMENT '规格',
  `buy_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '换货数量',
  `spec_weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '重量（kg）',
  `spec_coding` char(80) NOT NULL DEFAULT '' COMMENT '编码',
  `spec_barcode` char(80) NOT NULL DEFAULT '' COMMENT '条形码',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `exchange_id` (`exchange_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='换货单详情';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_exchange_detail`
--

LOCK TABLES `cms_order_exchange_detail` WRITE;
/*!40000 ALTER TABLE `cms_order_exchange_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_order_exchange_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_goods_inventory_log`
--

DROP TABLE IF EXISTS `cms_order_goods_inventory_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_goods_inventory_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `order_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态（0待确认, 1已确认/待支付, 2已支付/待发货, 3已发货/待收货, 4已完成, 5已取消, 6已关闭）',
  `original_inventory` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '原库存',
  `new_inventory` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最新库存',
  `is_rollback` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否回滚（0否, 1是）',
  `rollback_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回滚时间',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`),
  KEY `order_status` (`order_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单商品库存变更日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_goods_inventory_log`
--

LOCK TABLES `cms_order_goods_inventory_log` WRITE;
/*!40000 ALTER TABLE `cms_order_goods_inventory_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_order_goods_inventory_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_images`
--

DROP TABLE IF EXISTS `cms_order_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对应换货/退货id',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '图片url',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退换货对应单图片表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_images`
--

LOCK TABLES `cms_order_images` WRITE;
/*!40000 ALTER TABLE `cms_order_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_order_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_refund`
--

DROP TABLE IF EXISTS `cms_order_refund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_refund` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_no` char(60) NOT NULL DEFAULT '' COMMENT '订单号',
  `refund_no` char(60) NOT NULL DEFAULT '' COMMENT '退货单号码',
  `cause` char(255) NOT NULL DEFAULT '' COMMENT '退货原因',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0申请中,1已通过,2已拒绝,3用户寄件中,4商家已收货,5已完成,6已关闭',
  `application_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '申请时间',
  `audit_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核通过/拒绝时间',
  `reject_cause` char(255) NOT NULL DEFAULT '' COMMENT '拒绝原因',
  `delivery_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `collect_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收货时间',
  `close_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `express_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递id',
  `express_number` char(60) NOT NULL DEFAULT '' COMMENT '快递单号',
  `total_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总价格',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退款单列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_refund`
--

LOCK TABLES `cms_order_refund` WRITE;
/*!40000 ALTER TABLE `cms_order_refund` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_order_refund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_refund_detail`
--

DROP TABLE IF EXISTS `cms_order_refund_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_refund_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `refund_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退货订单id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '商品标题',
  `images` char(255) NOT NULL DEFAULT '' COMMENT '封面图片',
  `original_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单价格',
  `spec` char(255) NOT NULL DEFAULT '' COMMENT '规格',
  `buy_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退货数量',
  `spec_weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '重量（kg）',
  `spec_coding` char(80) NOT NULL DEFAULT '' COMMENT '编码',
  `spec_barcode` char(80) NOT NULL DEFAULT '' COMMENT '条形码',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `refund_id` (`refund_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='退货单详情';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_refund_detail`
--

LOCK TABLES `cms_order_refund_detail` WRITE;
/*!40000 ALTER TABLE `cms_order_refund_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_order_refund_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_order_status_history`
--

DROP TABLE IF EXISTS `cms_order_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_order_status_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `original_status` varchar(60) NOT NULL DEFAULT '' COMMENT '原始状态',
  `new_status` varchar(60) NOT NULL DEFAULT '' COMMENT '最新状态',
  `msg` varchar(255) NOT NULL DEFAULT '' COMMENT '操作描述',
  `creator` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建-用户id',
  `creator_name` varchar(60) NOT NULL DEFAULT '' COMMENT '创建人-姓名',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `original_status` (`original_status`),
  KEY `new_status` (`new_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单状态历史纪录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_order_status_history`
--

LOCK TABLES `cms_order_status_history` WRITE;
/*!40000 ALTER TABLE `cms_order_status_history` DISABLE KEYS */;
INSERT INTO `cms_order_status_history` VALUES (1,2,'1','5','取消[待付款-已取消]',1,'admin',1552893652),(2,1,'1','5','取消[待付款-已取消]',1,'admin',1553240177);
/*!40000 ALTER TABLE `cms_order_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_pay_log`
--

DROP TABLE IF EXISTS `cms_pay_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_pay_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '支付日志id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_id` int(11) unsigned NOT NULL COMMENT '订单id',
  `trade_no` char(100) NOT NULL DEFAULT '' COMMENT '支付平台交易号',
  `buyer_user` char(60) NOT NULL DEFAULT '' COMMENT '支付平台用户帐号',
  `pay_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单实际金额',
  `subject` char(255) NOT NULL DEFAULT '' COMMENT '订单名称',
  `payment` char(60) NOT NULL DEFAULT '' COMMENT '支付方式标记',
  `payment_name` char(60) NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `business_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '业务类型（0默认, 1订单, ...）',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `pay_type` (`payment`),
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='支付日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_pay_log`
--

LOCK TABLES `cms_pay_log` WRITE;
/*!40000 ALTER TABLE `cms_pay_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_pay_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_payment`
--

DROP TABLE IF EXISTS `cms_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_payment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` char(30) NOT NULL COMMENT '名称',
  `payment` char(60) NOT NULL DEFAULT '' COMMENT '唯一标记',
  `logo` char(255) NOT NULL DEFAULT '' COMMENT 'logo',
  `version` char(255) NOT NULL DEFAULT '' COMMENT '插件版本',
  `apply_version` char(255) NOT NULL DEFAULT '' COMMENT '适用系统版本',
  `desc` char(255) NOT NULL DEFAULT '' COMMENT '插件描述',
  `author` char(255) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` char(255) NOT NULL DEFAULT '' COMMENT '作者主页',
  `element` text COMMENT '配置项规则',
  `config` text COMMENT '配置数据',
  `apply_terminal` char(255) NOT NULL COMMENT '适用终端 php一维数组json字符串存储（pc, wap, app, alipay, weixin, baidu）',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `is_open_user` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否对用户开放',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment` (`payment`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='支付方式';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_payment`
--

LOCK TABLES `cms_payment` WRITE;
/*!40000 ALTER TABLE `cms_payment` DISABLE KEYS */;
INSERT INTO `cms_payment` VALUES (1,'微信','Weixin','','0.0.1','不限','适用微信web/h5(非微信环境)/小程序，即时到帐支付方式，买家的交易资金直接打入卖家账户，快速回笼交易资金。 <a href=\"https://pay.weixin.qq.com/\" target=\"_blank\">立即申请</a>','Devil','http://shopxo.net/','[{\"element\":\"input\",\"type\":\"text\",\"default\":\"\",\"name\":\"appid\",\"placeholder\":\"\\u516c\\u4f17\\u53f7ID\",\"title\":\"\\u516c\\u4f17\\u53f7ID (\\u7528\\u4e8eweb\\/h5)\",\"is_required\":0,\"message\":\"\\u8bf7\\u586b\\u5199\\u5fae\\u4fe1\\u5206\\u914d\\u7684\\u516c\\u4f17\\u53f7ID\"},{\"element\":\"input\",\"type\":\"text\",\"default\":\"\",\"name\":\"mini_appid\",\"placeholder\":\"\\u5c0f\\u7a0b\\u5e8fID\",\"title\":\"\\u5c0f\\u7a0b\\u5e8fID\",\"is_required\":0,\"message\":\"\\u8bf7\\u586b\\u5199\\u5fae\\u4fe1\\u5206\\u914d\\u7684\\u5c0f\\u7a0b\\u5e8fID\"},{\"element\":\"input\",\"type\":\"text\",\"default\":\"\",\"name\":\"mch_id\",\"placeholder\":\"\\u5fae\\u4fe1\\u652f\\u4ed8\\u5546\\u6237\\u53f7\",\"title\":\"\\u5fae\\u4fe1\\u652f\\u4ed8\\u5546\\u6237\\u53f7\",\"is_required\":0,\"message\":\"\\u8bf7\\u586b\\u5199\\u5fae\\u4fe1\\u652f\\u4ed8\\u5206\\u914d\\u7684\\u5546\\u6237\\u53f7\"},{\"element\":\"input\",\"type\":\"text\",\"default\":\"\",\"name\":\"key\",\"placeholder\":\"\\u5bc6\\u94a5\",\"title\":\"\\u5bc6\\u94a5\",\"is_required\":0,\"message\":\"\\u8bf7\\u586b\\u5199\\u5bc6\\u94a5\"}]','{\"appid\":\"\",\"mini_appid\":\"\",\"mch_id\":\"\",\"key\":\"\"}','[\"pc\",\"h5\",\"weixin\"]',1,1,0,1552540225,1552540380);
/*!40000 ALTER TABLE `cms_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_plugins`
--

DROP TABLE IF EXISTS `cms_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `plugins` char(60) NOT NULL DEFAULT '' COMMENT '唯一标记',
  `data` text COMMENT '应用数据',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `plugins` (`plugins`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='应用';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_plugins`
--

LOCK TABLES `cms_plugins` WRITE;
/*!40000 ALTER TABLE `cms_plugins` DISABLE KEYS */;
INSERT INTO `cms_plugins` VALUES (1,'commontopmaxpicture','{\"images\":\"\\/static\\/upload\\/images\\/plugins_commontopmaxpicture\\/2019\\/02\\/09\\/1549671733978860.jpg\",\"bg_color\":\"#ce0000\",\"url\":\"https:\\/\\/shopxo.net\\/\",\"is_new_window_open\":\"1\",\"is_overall\":\"1\",\"time_start\":\"\",\"time_end\":\"\",\"pluginsname\":\"commontopmaxpicture\",\"pluginscontrol\":\"admin\",\"pluginsaction\":\"save\"}',1,1550145321,1550461322),(2,'commontopnotice','{\"content\":\"\\u6b22\\u8fce\\u6765\\u5230ShopXO\\u4f01\\u4e1a\\u7ea7B2C\\u5f00\\u6e90\\u7535\\u5546\\u7cfb\\u7edf\\u3001\\u6f14\\u793a\\u7ad9\\u70b9\\u8bf7\\u52ff\\u53d1\\u8d77\\u652f\\u4ed8\\u3001\\u4ee5\\u514d\\u7ed9\\u60a8\\u5e26\\u6765\\u4e0d\\u5fc5\\u8981\\u7684\\u8d22\\u4ea7\\u635f\\u5931\\u3002\",\"is_overall\":\"1\",\"time_start\":\"\",\"time_end\":\"\",\"pluginsname\":\"commontopnotice\",\"pluginscontrol\":\"admin\",\"pluginsaction\":\"save\"}',1,1550156571,1550461635),(3,'usercentertopnotice','{\"content\":\"\\u7528\\u6237\\u4e2d\\u5fc3\\u516c\\u544a\",\"time_start\":\"\",\"time_end\":\"\",\"pluginsname\":\"usercentertopnotice\",\"pluginscontrol\":\"admin\",\"pluginsaction\":\"save\"}',1,1550157860,1550461859),(14,'userloginrewardintegral','{\"give_integral\":\"1\",\"is_day_once\":\"0\",\"time_start\":\"2019-03-18 17:44:17\",\"time_end\":\"2019-03-18 17:44:20\",\"pluginsname\":\"userloginrewardintegral\",\"pluginscontrol\":\"admin\",\"pluginsaction\":\"save\"}',1,1550151175,1552902266),(15,'commongobacktop','{\"images\":\"\\/static\\/upload\\/images\\/plugins_commongobacktop\\/2019\\/02\\/15\\/1550210425433304.png\",\"is_overall\":\"1\",\"pluginsname\":\"commongobacktop\",\"pluginscontrol\":\"admin\",\"pluginsaction\":\"save\"}',0,1550200998,1550468447),(16,'commonrightnavigation','{\"weixin_mini_qrcode_images\":\"\\/static\\/upload\\/images\\/plugins_commonrightnavigation\\/2019\\/02\\/17\\/1550375588899802.jpeg\",\"is_new_window_open\":\"0\",\"is_overall\":\"1\",\"is_goods_page_show_cart\":\"1\",\"pluginsname\":\"commonrightnavigation\",\"pluginscontrol\":\"admin\",\"pluginsaction\":\"save\"}',1,1550222925,1550464997),(17,'commononlineservice','{\"title\":\"ShopXO\\u5728\\u7ebf\\u5ba2\\u670d\",\"online_service\":\"\\u552e\\u524d|386392432\\n\\u552e\\u540e|386392432\",\"tel\":\"021-88888888\",\"is_overall\":\"1\",\"bg_color\":\"\",\"distance_top\":\"3\",\"pluginsname\":\"commononlineservice\",\"pluginscontrol\":\"admin\",\"pluginsaction\":\"save\"}',1,1550393304,1550544406);
/*!40000 ALTER TABLE `cms_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_power`
--

DROP TABLE IF EXISTS `cms_power`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_power` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限父级id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '权限名称',
  `control` char(30) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action` char(30) NOT NULL DEFAULT '' COMMENT '方法名称',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示（0否，1是）',
  `icon` char(60) DEFAULT '' COMMENT '图标class',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=407 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='权限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_power`
--

LOCK TABLES `cms_power` WRITE;
/*!40000 ALTER TABLE `cms_power` DISABLE KEYS */;
INSERT INTO `cms_power` VALUES (1,222,'权限管理','Power','Index',13,1,'',1481612301),(4,222,'角色管理','Power','Role',9,1,'',1481639037),(13,222,'权限管理','Power','Index',6,1,'',1482156143),(15,222,'权限添加/编辑','Power','PowerSave',99,0,'',1482243750),(16,222,'权限删除','Power','PowerDelete',99,0,'',1482243797),(17,222,'角色组添加/编辑页面','Power','RoleSaveInfo',99,0,'',1482243855),(18,222,'角色组添加/编辑','Power','RoleSave',99,0,'',1482243888),(19,222,'管理员添加/编辑页面','Admin','SaveInfo',99,0,'',1482244637),(20,222,'管理员添加/编辑','Admin','Save',99,0,'',1482244666),(21,222,'管理员删除','Admin','Delete',99,0,'',1482244688),(22,222,'账号管理','Admin','Index',2,1,'',1482568868),(23,222,'角色删除','Power','RoleDelete',99,0,'',1482569155),(38,0,'商品管理','Goods','Index',1,1,'icon-shangpin',1483283430),(39,38,'商品维护','Goods','Index',1,1,'',1483283546),(42,222,'配置保存','Config','Save',99,0,'',1483432335),(57,38,'商品添加/编辑页面','Goods','SaveInfo',99,0,'',1483616439),(58,38,'商品添加/编辑','Goods','Save',99,0,'',1483616492),(59,38,'商品删除','Goods','Delete',99,0,'',1483616569),(81,0,'生态管理','Site','Index',7,1,'icon-zhandianpeizhi',1486182943),(103,81,'站点设置','Site','Index',99,0,'',1486561470),(104,81,'短信设置','Zoology','sms',4,1,'',1486561615),(105,81,'站点设置编辑','Site','Save',99,0,'',1486561780),(107,81,'短信设置编辑','Sms','Save',99,0,'',1486562011),(118,0,'工具','Tool','Index',99,0,'icon-tools',1488108044),(119,118,'缓存管理','Cache','Index',1,1,'',1488108107),(120,118,'站点缓存更新','Cache','StatusUpdate',2,0,'',1488108235),(121,118,'模板缓存更新','Cache','TemplateUpdate',2,0,'',1488108390),(122,118,'模块缓存更新','Cache','ModuleUpdate',3,0,'',1488108436),(126,0,'CRM管理','User','Index',2,1,'icon-yonghuguanli',1490794162),(127,126,'客户列表','User','Index',1,1,'',1490794316),(128,126,'用户编辑/添加页面','User','SaveInfo',99,0,'',1490794458),(129,126,'用户添加/编辑','User','Save',99,0,'',1490794510),(130,126,'用户删除','User','Delete',99,0,'',1490794585),(146,126,'Excel导出','User','ExcelExport',99,0,'',1522223773),(153,222,'地区管理','Region','Index',80,0,'',1526304473),(154,222,'地区添加/编辑','Region','Save',99,0,'',1526304503),(155,222,'地区删除','Region','Delete',99,0,'',1526304531),(156,222,'物流设置','Express','Index',10,1,'',1526304473),(157,222,'快递添加/编辑','Express','Save',99,0,'',1526304473),(158,222,'快递删除','Express','Delete',99,0,'',1526304473),(172,222,'首页轮播','Slide','Index',99,0,'',1527149117),(173,222,'轮播添加/编辑页面','Slide','SaveInfo',99,0,'',1527149152),(174,222,'轮播添加/编辑','Slide','Save',99,0,'',1527149186),(175,222,'轮播状态更新','Slide','StatusUpdate',99,0,'',1527156980),(176,222,'轮播删除','Slide','Delete',99,0,'',1527157260),(177,0,'订单管理','Order','Index',3,1,'icon-dingdan',1522229870),(178,177,'订单维护','Order','Index',1,1,'',1522317898),(179,177,'订单删除','Order','Delete',99,0,'',1522317917),(180,177,'订单取消','Order','Cancel',99,0,'',1527497803),(181,38,'商品上下架','Goods','StatusShelves',99,0,'',1528080200),(182,0,'数据管理','Data','Index',13,1,'icon-shuju',1528096661),(183,182,'消息管理','Message','Index',0,1,'',1528080200),(184,182,'消息删除','Message','Delete',1,0,'',1528080200),(185,182,'支付日志','PayLog','Index',10,1,'',1528080200),(186,182,'积分日志','IntegralLog','Index',20,1,'',1528103067),(193,222,'筛选价格','ScreeningPrice','Index',99,0,'',1528708578),(194,222,'筛选价格添加/编辑','ScreeningPrice','Save',99,0,'',1528708609),(199,81,'SEO设置','Seo','Index',99,0,'',1528771081),(200,81,'SEO设置编辑','Seo','Save',99,0,'',1528771105),(201,38,'商品类别','GoodsCategory','Index',2,0,'',1529041901),(202,38,'商品分类添加/编辑','GoodsCategory','Save',99,0,'',1529041928),(203,38,'商品分类删除','GoodsCategory','Delete',99,0,'',1529041949),(204,0,'文章管理','Article','Index',12,1,'icon-wenzhang',1530360560),(205,204,'文章管理','Article','Index',0,1,'',1530360593),(206,204,'文章添加/编辑页面','Article','SaveInfo',1,0,'',1530360625),(207,204,'文章添加/编辑','Article','Save',2,0,'',1530360663),(208,204,'文章删除','Article','Delete',3,0,'',1530360692),(209,204,'文章状态更新','Article','StatusUpdate',4,0,'',1530360730),(210,204,'文章分类','ArticleCategory','Index',10,1,'',1530361071),(211,204,'文章分类编辑/添加','ArticleCategory','Save',11,0,'',1530361101),(212,204,'文章分类删除','ArticleCategory','Delete',12,0,'',1530361126),(213,0,'问答留言','Answer','Index',99,0,'icon-wenda',1533112421),(214,213,'问答留言','Answer','Index',0,1,'',1533112443),(215,213,'问答留言回复','Answer','Reply',1,0,'',1533119660),(216,213,'问答留言删除','Answer','Delete',2,0,'',1533119680),(217,213,'问答留言状态更新','Answer','StatusUpdate',3,0,'',1533119704),(218,38,'商品首页推荐','Goods','StatusHomeRecommended',99,0,'',1533564476),(219,81,'邮件管理','Zoology','Email',2,1,'',1533636067),(220,81,'邮箱添加/编辑','Email','Save',99,0,'',1533636109),(221,81,'邮件发送测试','Email','EmailTest',99,0,'',1533636157),(222,0,'系统管理','AdminLog','Index',6,1,'icon-wangzhanguanli',1533692051),(223,222,'导航管理','Navigation','Index',99,0,'',1486183114),(226,222,'导航添加/编辑','Navigation','Save',99,0,'',1486183367),(228,222,'导航状态更新','Navigation','StatusUpdate',99,0,'',1486183462),(234,222,'自定义页面','CustomView','Index',99,0,'',1486193400),(235,222,'自定义页面添加/编辑页面','CustomView','SaveInfo',99,0,'',1486193449),(236,222,'自定义页面添加/编辑','CustomView','Save',99,0,'',1486193473),(237,222,'自定义页面删除','CustomView','Delete',99,0,'',1486193516),(238,222,'自定义页面状态更新','CustomView','StatusUpdate',99,0,'',1486193582),(239,222,'友情链接','Link','Index',99,0,'',1486194358),(240,222,'友情链接添加/编辑页面','Link','SaveInfo',99,0,'',1486194392),(241,222,'友情链接添加/编辑','Link','Save',99,0,'',1486194413),(242,222,'友情链接删除','Link','Delete',99,0,'',1486194435),(243,222,'友情链接状态更新','Link','StatusUpdate',99,0,'',1486194479),(244,222,'主题管理','Theme','Index',99,0,'',1494381693),(245,222,'主题管理添加/编辑','Theme','Save',99,0,'',1494398194),(246,222,'主题上传安装','Theme','Upload',99,0,'',1494405096),(247,222,'主题删除','Theme','Delete',99,0,'',1494410655),(248,204,'商品首页推荐','Article','StatusHomeRecommended',5,0,'',1534156400),(252,0,'品牌管理','Brand','Index',99,0,'icon-ico-pinpaiguanli',1535684308),(258,222,'筛选价格删除','ScreeningPrice','Delete',99,0,'',1536227071),(267,177,'订单发货','Order','Delivery',99,0,'',1538413499),(268,177,'订单收货','Order','Collect',99,0,'',1538414034),(269,177,'订单支付','Order','Pay',99,0,'',1538757043),(310,177,'订单确认','Order','Confirm',99,0,'',1542011799),(311,222,'角色状态更新','Power','RoleStatusUpdate',99,0,'',1542102071),(313,312,'基础配置','AppMiniAlipayConfig','Index',0,1,'',1542558297),(314,319,'首页导航','AppHomeNav','Index',10,1,'',1542558318),(315,319,'首页导航添加/编辑页面','AppHomeNav','SaveInfo',11,0,'',1542558686),(316,319,'首页导航添加/编辑','AppHomeNav','Save',12,0,'',1542558706),(317,319,'首页导航状态更新','AppHomeNav','StatusUpdate',13,0,'',1542558747),(318,319,'首页导航删除','AppHomeNav','Delete',14,0,'',1542558767),(325,312,'基础配置保存','AppMiniAlipayConfig','Save',1,0,'',1542596647),(326,319,'基础配置','AppConfig','Index',0,1,'',1543206359),(327,319,'基础配置保存','AppConfig','Save',1,0,'',1543206402),(328,312,'小程序','AppMiniAlipayList','Index',10,1,'',1543304094),(329,312,'小程序生成','AppMiniAlipayList','Created',11,0,'',1543305528),(330,312,'小程序删除','AppMiniAlipayList','Delete',12,0,'',1543305609),(331,118,'日志删除','Cache','LogDelete',4,0,'',1545642163),(333,332,'基础配置','AppMiniWeixinConfig','Index',0,1,'',1546935090),(334,332,'基础配置保存','AppMiniWeixinConfig','Save',1,0,'',1546935118),(335,332,'小程序','AppMiniWeixinList','Index',10,1,'',1546935153),(336,332,'小程序生成','AppMiniWeixinList','Created',11,0,'',1546935187),(337,332,'小程序删除','AppMiniWeixinList','Delete',12,0,'',1546935212),(338,177,'Excel导出','Order','ExcelExport',99,0,'',1548054782),(339,369,'PC端配置','Operation','Index',3,1,'',1722317917),(341,81,'第三方插件管理','Pluginsadmin','Index',99,0,'',1549497306),(343,81,'应用调用管理','Plugins','Index',99,0,'',1549958187),(345,81,'应用添加/编辑页面','Pluginsadmin','SaveInfo',99,0,'',1549977925),(349,118,'SQL控制台','Sqlconsole','Index',10,1,'',1550476002),(350,118,'SQL执行','Sqlconsole','Implement',11,0,'',1550476023),(351,38,'商品品牌','Brand','Index',3,1,'',1552892118),(352,38,'品牌类别','BrandCategory','Index',4,1,'',1552892149),(354,38,'品牌添加/编辑页面','Brand','SaveInfo',99,0,'',1552892947),(355,38,'品牌添加/编辑','Brand','Save',99,0,'',1552892990),(356,38,'品牌状态更新','Brand','StatusUpdate',99,0,'',1552893032),(357,38,'品牌删除','Brand','Delete',99,0,'',1552893078),(358,38,'品牌分类添加/编辑','BrandCategory','Save',99,0,'',1552893116),(359,38,'品牌分类删除','BrandCategory','Delete',99,0,'',1552893170),(361,177,'快递删除','Express','Delete',99,0,'',1552893849),(362,177,'换货列表','OrderExchange','Index',30,1,'',1552894030),(363,177,'退货列表','OrderRefund','Index',40,1,'',1552894117),(364,0,'财务管理','Finance','Index',4,1,'icon-shuju',1552894935),(365,364,'收款管理','PayLog','Index',1,1,'',1552896896),(366,364,'付款管理','Payment','Index',2,1,'',1552896965),(367,364,'报表管理','PayReport','Index',3,1,'',1552897064),(368,364,'供应链管理','Supply','Index',4,1,'',1552897151),(369,0,'运营管理','Operation','Index',5,1,'icon-peizhi',1552897383),(370,222,'操作日志','System','LogList',0,1,'',1552897977),(371,369,'促销管理','Operation','Index',1,1,'',1722317917),(372,369,'活动管理','Operation','Index',2,1,'',1722317917),(373,369,'手机商城配置','Operation','Index',4,1,'',1722317917),(374,369,'APP配置','Operation','Index',5,1,'',1722317917),(375,369,'优惠券管理','Operation','Index',6,1,'',1722317917),(376,222,'仓库设置','Storage','Storage_list',11,1,'',1552900205),(377,222,'数据备份','System','Backups',3,1,'',1552900284),(378,222,'数据恢复','System','Recover',5,1,'',1552900362),(380,38,'全选删除','goods','all_del',99,0,'',1552902400),(381,81,'流量统计','Zoology','Index',6,1,'',1552902699),(382,81,'第三方ERP','Zoology','Index',8,1,'',1552903395),(383,81,'生态供应链','Zoology','Index',9,1,'',1552903460),(384,222,'流程管理','System','In',4,1,'',1552906463),(385,38,'多选删除','Goods','Alldel',99,0,'',1552893170),(386,38,'库存管理','Goods','Repertory',5,1,'',1552892149),(387,126,'客户等级','User','Rank',2,1,'',1490794316),(388,126,'客户积分','User','Integral',3,1,'',1490794316),(389,177,'发货管理','Order','Deliver',2,1,'',1522317917),(390,177,'物流跟踪','Order','logistics',3,1,'',1522317917),(391,177,'配送管理','Order','Delivery',4,1,'',1522317917),(392,177,'云POS','Order','Cloud',5,1,'',1522317917),(393,177,'售后服务','Order','Service',6,1,'',1522317917),(394,177,'评论管理','Order','Comment',7,1,'',1522317917),(395,364,'资金账户','Finance','Account',0,1,'',1722317917),(396,81,'物流配置','Zoology','Logistics',1,1,'',1733636067),(397,81,'第三方电商平台接入','Zoology','Merchant',3,1,'',1733636067),(398,81,'支付管理','Zoology','Pay',5,1,'',1733636067),(399,81,'IM管理(即时通讯)','Zoology','Chat',7,1,'',1733636067),(400,222,'数据初始','System','Initialize',1,1,'',1733636067),(401,222,'服务器端设置','System','Setting',7,1,'',1733636067),(402,222,'网络管理','System','Network',8,1,'',1733636067),(403,222,'组织管理','System','Tissue',12,1,'',1733636067),(404,126,'用户等级编辑','User','UpdateRank',99,0,'',0),(405,222,'数据导出','System','Orders',99,0,'',0),(406,222,'数据恢复','System','Getord',99,0,'',0);
/*!40000 ALTER TABLE `cms_power` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_region`
--

DROP TABLE IF EXISTS `cms_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `level` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '级别类型（1:一级[所有省], 2：二级[所有市], 3:三级[所有区县], 4:街道[所有街道]）',
  `letters` char(3) NOT NULL DEFAULT '' COMMENT '城市首字母',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `is_enable` (`is_enable`),
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=45058 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='地区';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_region`
--

LOCK TABLES `cms_region` WRITE;
/*!40000 ALTER TABLE `cms_region` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_role`
--

DROP TABLE IF EXISTS `cms_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色组id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '角色名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='角色组';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_role`
--

LOCK TABLES `cms_role` WRITE;
/*!40000 ALTER TABLE `cms_role` DISABLE KEYS */;
INSERT INTO `cms_role` VALUES (1,'超级管理员',1,1481350313,'2019-03-18 09:52:50'),(13,'管理员',1,1484402362,'2018-11-13 09:43:30'),(14,'财务',1,1552543182,'2019-03-14 05:59:42');
/*!40000 ALTER TABLE `cms_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_role_power`
--

DROP TABLE IF EXISTS `cms_role_power`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_role_power` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关联id',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `power_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `power_id` (`power_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3019 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='角色与权限管理';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_role_power`
--

LOCK TABLES `cms_role_power` WRITE;
/*!40000 ALTER TABLE `cms_role_power` DISABLE KEYS */;
INSERT INTO `cms_role_power` VALUES (2612,14,38,1552893308),(2613,14,39,1552893308),(2614,14,351,1552893308),(2615,14,126,1552893308),(2616,14,127,1552893308),(2617,14,177,1552893308),(2618,14,178,1552893308),(2619,14,213,1552893308),(2620,14,214,1552893308),(2621,13,38,1552902525),(2622,13,380,1552902525),(2623,13,39,1552902525),(2624,13,201,1552902525),(2625,13,126,1552902525),(2626,13,127,1552902525),(2627,13,177,1552902525),(2628,13,178,1552902525),(2629,13,180,1552902525),(2630,13,267,1552902525),(2631,13,268,1552902525),(2632,13,269,1552902525),(2633,13,310,1552902525),(2634,13,222,1552902525),(2635,13,339,1552902525),(2636,13,223,1552902525),(2637,13,234,1552902525),(2638,13,236,1552902525),(2639,13,238,1552902525),(2640,13,239,1552902525),(2641,13,241,1552902525),(2642,13,244,1552902525),(2643,13,172,1552902525),(2644,13,175,1552902525),(2645,13,193,1552902525),(2646,13,153,1552902525),(2647,13,156,1552902525),(2648,13,259,1552902525),(2649,13,261,1552902525),(2650,13,81,1552902525),(2651,13,103,1552902525),(2652,13,104,1552902525),(2653,13,219,1552902525),(2654,13,199,1552902525),(2655,13,252,1552902525),(2656,13,249,1552902525),(2657,13,253,1552902525),(2658,13,213,1552902525),(2659,13,214,1552902525),(2660,13,319,1552902525),(2661,13,326,1552902525),(2662,13,314,1552902525),(2663,13,312,1552902525),(2664,13,313,1552902525),(2665,13,328,1552902525),(2666,13,329,1552902525),(2667,13,332,1552902525),(2668,13,333,1552902525),(2669,13,335,1552902525),(2670,13,336,1552902525),(2671,13,204,1552902525),(2672,13,205,1552902525),(2673,13,210,1552902525),(2674,13,212,1552902525),(2675,13,182,1552902525),(2676,13,183,1552902525),(2677,13,185,1552902525),(2678,13,186,1552902525),(2679,13,1,1552902525),(2680,13,22,1552902525),(2681,13,4,1552902525),(2682,13,13,1552902525),(2683,13,340,1552902525),(2684,13,341,1552902525),(2685,13,118,1552902525),(2686,13,119,1552902525),(2687,13,120,1552902525),(2688,13,121,1552902525),(2689,13,122,1552902525),(2690,13,331,1552902525),(2691,13,349,1552902525),(2864,1,38,1553475716),(2865,1,39,1553475716),(2866,1,201,1553475716),(2867,1,351,1553475716),(2868,1,352,1553475716),(2869,1,386,1553475716),(2870,1,385,1553475716),(2871,1,380,1553475716),(2872,1,359,1553475716),(2873,1,358,1553475716),(2874,1,357,1553475716),(2875,1,356,1553475716),(2876,1,355,1553475716),(2877,1,354,1553475716),(2878,1,57,1553475716),(2879,1,58,1553475716),(2880,1,218,1553475716),(2881,1,203,1553475716),(2882,1,202,1553475716),(2883,1,59,1553475716),(2884,1,181,1553475716),(2885,1,126,1553475716),(2886,1,127,1553475716),(2887,1,128,1553475716),(2888,1,129,1553475716),(2889,1,130,1553475716),(2890,1,146,1553475716),(2891,1,404,1553475716),(2892,1,177,1553475716),(2893,1,178,1553475716),(2894,1,362,1553475716),(2895,1,363,1553475716),(2896,1,338,1553475716),(2897,1,179,1553475716),(2898,1,180,1553475716),(2899,1,267,1553475716),(2900,1,268,1553475716),(2901,1,269,1553475716),(2902,1,310,1553475716),(2903,1,361,1553475716),(2904,1,364,1553475716),(2905,1,365,1553475716),(2906,1,366,1553475716),(2907,1,367,1553475716),(2908,1,368,1553475716),(2909,1,369,1553475716),(2910,1,371,1553475716),(2911,1,372,1553475716),(2912,1,339,1553475716),(2913,1,373,1553475716),(2914,1,374,1553475716),(2915,1,375,1553475716),(2916,1,222,1553475716),(2917,1,370,1553475716),(2918,1,400,1553475716),(2919,1,22,1553475716),(2920,1,377,1553475716),(2921,1,384,1553475716),(2922,1,378,1553475716),(2923,1,13,1553475716),(2924,1,401,1553475716),(2925,1,402,1553475716),(2926,1,4,1553475716),(2927,1,156,1553475716),(2928,1,376,1553475716),(2929,1,403,1553475716),(2930,1,1,1553475716),(2931,1,153,1553475716),(2932,1,242,1553475716),(2933,1,241,1553475716),(2934,1,240,1553475716),(2935,1,239,1553475716),(2936,1,238,1553475716),(2937,1,237,1553475716),(2938,1,243,1553475716),(2939,1,244,1553475716),(2940,1,245,1553475716),(2941,1,247,1553475716),(2942,1,258,1553475716),(2943,1,311,1553475716),(2944,1,18,1553475716),(2945,1,246,1553475716),(2946,1,236,1553475716),(2947,1,235,1553475716),(2948,1,234,1553475716),(2949,1,155,1553475716),(2950,1,154,1553475716),(2951,1,42,1553475716),(2952,1,23,1553475716),(2953,1,21,1553475716),(2954,1,20,1553475716),(2955,1,19,1553475716),(2956,1,17,1553475716),(2957,1,16,1553475716),(2958,1,157,1553475716),(2959,1,158,1553475716),(2960,1,172,1553475716),(2961,1,228,1553475716),(2962,1,226,1553475716),(2963,1,223,1553475716),(2964,1,194,1553475716),(2965,1,193,1553475716),(2966,1,176,1553475716),(2967,1,175,1553475716),(2968,1,174,1553475716),(2969,1,173,1553475716),(2970,1,15,1553475716),(2971,1,81,1553475716),(2972,1,219,1553475716),(2973,1,104,1553475716),(2974,1,381,1553475716),(2975,1,399,1553475716),(2976,1,382,1553475716),(2977,1,383,1553475716),(2978,1,345,1553475716),(2979,1,343,1553475716),(2980,1,341,1553475716),(2981,1,221,1553475716),(2982,1,220,1553475716),(2983,1,200,1553475716),(2984,1,199,1553475716),(2985,1,107,1553475716),(2986,1,105,1553475716),(2987,1,103,1553475716),(2988,1,204,1553475716),(2989,1,205,1553475716),(2990,1,206,1553475716),(2991,1,207,1553475716),(2992,1,208,1553475716),(2993,1,209,1553475716),(2994,1,248,1553475716),(2995,1,210,1553475716),(2996,1,211,1553475716),(2997,1,212,1553475716),(2998,1,182,1553475716),(2999,1,183,1553475716),(3000,1,184,1553475716),(3001,1,185,1553475716),(3002,1,186,1553475716),(3003,1,118,1553475716),(3004,1,119,1553475716),(3005,1,120,1553475716),(3006,1,121,1553475716),(3007,1,122,1553475716),(3008,1,331,1553475716),(3009,1,349,1553475716),(3010,1,350,1553475716),(3011,1,213,1553475716),(3012,1,214,1553475716),(3013,1,215,1553475716),(3014,1,216,1553475716),(3015,1,217,1553475716),(3016,1,252,1553475716),(3017,1,405,1552893308),(3018,1,406,1552893308);
/*!40000 ALTER TABLE `cms_role_power` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_screening_price`
--

DROP TABLE IF EXISTS `cms_screening_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_screening_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `min_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最小价格',
  `max_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最大价格',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='筛选价格';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_screening_price`
--

LOCK TABLES `cms_screening_price` WRITE;
/*!40000 ALTER TABLE `cms_screening_price` DISABLE KEYS */;
INSERT INTO `cms_screening_price` VALUES (7,0,'100以下',0,100,1,0,0,1545321887),(10,0,'100-300',100,300,1,0,0,1536285074),(16,0,'300-600',300,600,1,0,1482840545,1536284623),(17,0,'600-1000',600,1000,1,0,1482840557,1536284638),(18,0,'1000-1500',1000,1500,1,0,1482840577,1536284653),(24,0,'1500-2000',1500,2000,1,0,1483951541,1536284667),(25,0,'2000-3000',2000,3000,1,0,1535684676,1536284683),(26,0,'3000-5000',3000,5000,1,0,1535684688,1536284701),(27,0,'5000-8000',5000,8000,1,0,1535684701,1536284736),(28,0,'8000-12000',8000,12000,1,0,1535684707,1536284767),(29,0,'12000-16000',12000,16000,1,0,1535684729,1536284787),(30,0,'16000-20000',16000,20000,1,0,1535684745,1536284805),(31,0,'20000以上',20000,0,1,0,1535684797,1536284828);
/*!40000 ALTER TABLE `cms_screening_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_search_history`
--

DROP TABLE IF EXISTS `cms_search_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_search_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `brand_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `keywords` char(80) NOT NULL DEFAULT '' COMMENT '搜索关键字',
  `screening_price` char(80) NOT NULL DEFAULT '' COMMENT '搜索价格区间',
  `order_by_field` char(60) NOT NULL DEFAULT '' COMMENT '排序类型（字段名称）',
  `order_by_type` char(60) NOT NULL DEFAULT '' COMMENT '排序方式（asc, desc）',
  `ymd` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '日期 ymd',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='搜索日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_search_history`
--

LOCK TABLES `cms_search_history` WRITE;
/*!40000 ALTER TABLE `cms_search_history` DISABLE KEYS */;
INSERT INTO `cms_search_history` VALUES (1,0,0,68,'','0-0','default','asc',20190314,1552527802),(2,0,0,318,'','0-0','default','asc',20190314,1552528601),(3,0,0,1,'','0-0','default','asc',20190314,1552533237),(4,0,0,2,'','0-0','default','asc',20190314,1552533321),(5,0,0,1,'','0-0','default','asc',20190314,1552533326),(6,90,0,68,'','0-0','default','asc',20190314,1552540951),(7,90,0,359,'','0-0','default','asc',20190314,1552540956),(8,90,0,480,'','0-0','default','asc',20190314,1552540959),(9,90,0,480,'','0-0','default','asc',20190314,1552540965),(10,90,0,312,'','0-0','default','asc',20190314,1552543872),(11,90,0,56,'','0-0','default','asc',20190314,1552543916),(12,90,0,68,'','0-0','default','asc',20190314,1552546683),(13,90,1,68,'','0-0','default','asc',20190314,1552546687),(14,90,0,68,'','0-0','default','asc',20190314,1552546689),(15,90,1,68,'','0-0','default','asc',20190314,1552546692),(16,90,2,68,'','0-0','default','asc',20190314,1552546696),(17,90,1,68,'','0-0','default','asc',20190314,1552546697),(18,90,2,68,'','0-0','default','asc',20190314,1552546701),(19,90,1,68,'','0-0','default','asc',20190314,1552546702),(20,90,0,1,'','0-0','default','asc',20190314,1552549288),(21,90,0,1,'','0-100','default','asc',20190314,1552549317),(22,90,0,1,'','0-0','default','asc',20190314,1552549318),(23,0,0,59,'','0-0','default','asc',20190320,1553061161),(24,0,0,59,'','0-0','default','asc',20190320,1553061179),(25,0,0,894,'','0-0','default','asc',20190321,1553136258),(26,0,0,894,'','0-0','sales_count','desc',20190321,1553136266),(27,0,0,61,'','0-0','default','asc',20190322,1553242286),(28,0,0,0,'手机','0-0','default','asc',20190322,1553248406),(29,0,0,0,'手机','5000-8000','default','asc',20190322,1553248443),(30,0,0,0,'手机','0-100','default','asc',20190322,1553248445),(31,0,0,0,'手机','0-0','default','asc',20190322,1553248456),(32,0,0,1,'','0-0','default','asc',20190322,1553248462),(33,0,0,0,'连衣裙','0-0','default','asc',20190322,1553248534),(34,0,0,1,'','0-0','default','asc',20190325,1553498276),(35,0,0,59,'','0-0','default','asc',20190325,1553498279),(36,0,0,59,'','16000-20000','default','asc',20190325,1553498280),(37,0,0,1,'','16000-20000','default','asc',20190325,1553498282),(38,0,0,1,'','0-0','default','asc',20190325,1553498284),(39,0,0,1,'','16000-20000','default','asc',20190325,1553498290),(40,0,0,1,'','0-100','default','asc',20190325,1553498291),(41,0,0,1,'','1500-2000','default','asc',20190325,1553498295),(42,0,0,1,'','2000-3000','default','asc',20190325,1553498301),(43,0,0,1,'','3000-5000','default','asc',20190325,1553498302),(44,0,0,1,'','5000-8000','default','asc',20190325,1553498306),(45,0,0,1,'','8000-12000','default','asc',20190325,1553498308),(46,0,0,58,'','8000-12000','default','asc',20190325,1553498312),(47,0,0,58,'','0-0','default','asc',20190325,1553498315);
/*!40000 ALTER TABLE `cms_search_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_slide`
--

DROP TABLE IF EXISTS `cms_slide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_slide` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `platform` char(30) NOT NULL DEFAULT 'pc' COMMENT '所属平台（pc PC网站, h5 H5手机网站, alipay 支付宝小程序, weixin 微信小程序, baidu 百度小程序）',
  `event_type` tinyint(2) NOT NULL DEFAULT '-1' COMMENT '事件类型（0 WEB页面, 1 内部页面(小程序或APP内部地址), 2 外部小程序(同一个主体下的小程序appid), 3 打开地图, 4 拨打电话）',
  `event_value` char(255) NOT NULL DEFAULT '' COMMENT '事件值',
  `images_url` char(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '别名',
  `bg_color` char(30) NOT NULL DEFAULT '' COMMENT 'css背景色值',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `is_enable` (`is_enable`),
  KEY `sort` (`sort`),
  KEY `platform` (`platform`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='轮播图片';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_slide`
--

LOCK TABLES `cms_slide` WRITE;
/*!40000 ALTER TABLE `cms_slide` DISABLE KEYS */;
INSERT INTO `cms_slide` VALUES (6,'weixin',0,'https://shopxo.net','/static/upload/images/slide/2018/08/20180810094402044087.jpeg','浪漫七夕','#080718',1,7,1533865442,1546281334),(7,'weixin',1,'/pages/goods-detail/goods-detail?goods_id=12','/static/upload/images/slide/2018/08/20180810095910423687.jpeg','海洋的未来','#016bcc',1,6,1533866350,1546281301),(8,'alipay',-1,'','/static/upload/images/slide/2018/08/20180810100811853567.jpeg','大闸蟹','#f2efe6',1,5,1533866891,1542618684),(9,'alipay',-1,'','/static/upload/images/slide/2018/08/20180810101045451156.jpeg','情定七夕','#7ddcf3',1,4,1533867045,1542618679),(10,'pc',0,'http://ask.shopxo.net','/static/upload/images/slide/2018/08/20180810101106984022.jpeg','美酒','#f4bccb',1,3,1533867066,1547458393),(11,'alipay',3,'ShopXO|上海浦东新区张江高科技园区XXX号|121.626444|31.20843','/static/upload/images/slide/2018/08/20180810101154662873.jpeg','助力七夕','#85c8c7',1,2,1533867114,1543212317),(12,'pc',0,'https://shopxo.net','/static/upload/images/slide/2018/08/20180810101224227323.jpeg','爱在厨房','#efc6c4',1,1,1533867144,1545290041),(13,'alipay',1,'/pages/goods-detail/goods-detail?goods_id=1','/static/upload/images/slide/2018/08/20180810101305611263.jpeg','预享甜蜜','#f6f6f4',1,0,1533867185,1545290030);
/*!40000 ALTER TABLE `cms_slide` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_storage`
--

DROP TABLE IF EXISTS `cms_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_storage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `region_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属地id',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '仓库名称',
  `address` char(255) NOT NULL DEFAULT '' COMMENT '仓库地址',
  `adtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_storage`
--

LOCK TABLES `cms_storage` WRITE;
/*!40000 ALTER TABLE `cms_storage` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_storage_category`
--

DROP TABLE IF EXISTS `cms_storage_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_storage_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `srorage_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '仓库id',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作管理员id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='仓库对应多个操作管理员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_storage_category`
--

LOCK TABLES `cms_storage_category` WRITE;
/*!40000 ALTER TABLE `cms_storage_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_storage_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_talk`
--

DROP TABLE IF EXISTS `cms_talk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_talk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `post` varchar(80) NOT NULL COMMENT '发送者',
  `receive` varchar(80) NOT NULL COMMENT '接受者',
  `class` varchar(60) NOT NULL DEFAULT 'text' COMMENT '内容类型',
  `content` varchar(255) NOT NULL COMMENT '发送内容',
  `status` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '0(未读)  1(已读)',
  `add_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_talk`
--

LOCK TABLES `cms_talk` WRITE;
/*!40000 ALTER TABLE `cms_talk` DISABLE KEYS */;
INSERT INTO `cms_talk` VALUES (1,'张三','客服','text','gdsgsdgsd',0,1),(2,'李四','客服','text','顺光电公司概述',0,1),(3,'张三','客服','text','送到公司帝国时代',0,2),(4,'客服','张三','text',' 公司的根深蒂固三个',0,3),(5,'客服','李四','text','搜的各地身高多少',0,3),(6,'张三','客服','text','公司感受到',0,4),(7,'李四','客服','text','公司十多个施工队三个',0,5),(8,'老五','客服','text','该死的郭德纲',1,1),(9,'张三','客服','text','测试测试',0,1553233476),(10,'客服','张三','text','再来啊',0,1553233770),(11,'客服','张三','text','正在',0,1553234802),(12,'客服','张三','text','嗨、你好吗？',0,1553235983),(13,'客服','李四','text','小黄鸭',0,1553236148),(14,'客服','李四','text','感受到广东省',0,1553236274),(15,'客服','李四','text','高度',0,1553240938),(16,'客服','老五','text','施工队三个是',0,1553240985),(17,'客服','老五','text','让我去若群无',0,1553241049),(18,'客服','老五','text','加不进去？？',0,1553241248),(19,'客服','老五','text','收到',0,1553241494),(20,'客服','用户1553243098135','text','您好！再生能源公司，有什么可以帮到您？',0,1553248592),(26,'客服','用户1553243098135','text','啥啥啥',0,1553497779),(24,'用户1553243098135','客服','text','特色休闲鞋',0,1553483784),(25,'用户1553243098135','客服','text','test测试',0,1553483989);
/*!40000 ALTER TABLE `cms_talk` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `cms_user` VALUES (77,'2088502175420842-','','',0,'430953','13ee29b2b06000b088a07cf36e7062f7','李四','李大牛','13250814883','fuxiang.gong@qq.com',2,'https://tfs.alipayobjects.com/images/partner/T10d8lXm4dXXXXXXXX','上海','上海市',1540915200,'',0.00,2,1000,0,0,0,0,1553134335),(90,'2088502175420842','','',0,'081377','354c9ea986fbdaec110d310c324dbcab','张三','魔鬼','17688888888','',2,'','上海','上海市',666201600,'',0.00,2,50,0,0,0,1539167253,1553475867);
/*!40000 ALTER TABLE `cms_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_user_access`
--

DROP TABLE IF EXISTS `cms_user_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_user_access` (
  `ip` int(11) NOT NULL COMMENT '对应访问表的ID',
  `add_time` int(11) NOT NULL COMMENT '加入时间'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_user_access`
--

LOCK TABLES `cms_user_access` WRITE;
/*!40000 ALTER TABLE `cms_user_access` DISABLE KEYS */;
INSERT INTO `cms_user_access` VALUES (5,1553282946),(5,1553486547),(3,1553482949),(4,1553490148),(5,1553486547),(2,1553497516),(10,1553498352),(10,1553318033);
/*!40000 ALTER TABLE `cms_user_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_user_access_schedule`
--

DROP TABLE IF EXISTS `cms_user_access_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_user_access_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增Id',
  `ip` varchar(15) NOT NULL COMMENT '用户Ip',
  `number` tinyint(255) DEFAULT NULL COMMENT '用户访问次数（暂时无用）',
  `add_time` int(11) NOT NULL COMMENT '访问时间',
  `upd_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_user_access_schedule`
--

LOCK TABLES `cms_user_access_schedule` WRITE;
/*!40000 ALTER TABLE `cms_user_access_schedule` DISABLE KEYS */;
INSERT INTO `cms_user_access_schedule` VALUES (1,'127.0.0.1',1,1553493551,1553493498),(2,'127.0.0.2',1,1553493551,1553498010),(3,'127.0.0.3',1,1553493551,0),(4,'127.0.0.4',1,1553493551,0),(5,'127.0.0.5',1,1553493551,1553493885),(6,'127.0.0.7',1,1553493551,0),(7,'127.0.0.6',1,1553493551,1553493820),(10,'127.0.0.8',2,1553498033,1553498352);
/*!40000 ALTER TABLE `cms_user_access_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_user_address`
--

DROP TABLE IF EXISTS `cms_user_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_user_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '站点id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '站点所属用户id',
  `alias` char(60) NOT NULL DEFAULT '' COMMENT '别名',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '姓名',
  `tel` char(15) NOT NULL DEFAULT '' COMMENT '电话',
  `province` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在省',
  `city` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在市',
  `county` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在县/区',
  `address` char(80) NOT NULL DEFAULT '' COMMENT '详细地址',
  `lng` decimal(13,10) unsigned NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lat` decimal(13,10) unsigned NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `is_default` tinyint(1) unsigned DEFAULT '0' COMMENT '是否默认地址（0否, 1是）',
  `is_delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除（0否，1删除时间戳）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_enable` (`is_delete_time`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户地址';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_user_address`
--

LOCK TABLES `cms_user_address` WRITE;
/*!40000 ALTER TABLE `cms_user_address` DISABLE KEYS */;
INSERT INTO `cms_user_address` VALUES (1,90,'','袁久林','13612923031',19,291,3059,'12312312',113.9300130000,22.7074330000,1,0,1552540355,0);
/*!40000 ALTER TABLE `cms_user_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_user_integral_log`
--

DROP TABLE IF EXISTS `cms_user_integral_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_user_integral_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型（0减少, 1增加）',
  `original_integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '原始积分',
  `new_integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最新积分',
  `msg` char(255) DEFAULT '' COMMENT '操作原因',
  `operation_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作人员id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户积分日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_user_integral_log`
--

LOCK TABLES `cms_user_integral_log` WRITE;
/*!40000 ALTER TABLE `cms_user_integral_log` DISABLE KEYS */;
INSERT INTO `cms_user_integral_log` VALUES (1,90,1,45,50,'登录奖励积分',0,1552534767),(2,77,1,982,1000,'管理员操作',1,1553134328);
/*!40000 ALTER TABLE `cms_user_integral_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_user_recharge_log`
--

DROP TABLE IF EXISTS `cms_user_recharge_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_user_recharge_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `recharge_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `trade_no` char(100) NOT NULL DEFAULT '' COMMENT '支付平台交易号',
  `buyer_user` char(60) NOT NULL DEFAULT '' COMMENT '支付平台用户帐号',
  `payment` char(60) NOT NULL DEFAULT '' COMMENT '支付方式标记',
  `payment_name` char(60) DEFAULT '' COMMENT '支付方式名称',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户余额充值记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_user_recharge_log`
--

LOCK TABLES `cms_user_recharge_log` WRITE;
/*!40000 ALTER TABLE `cms_user_recharge_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_user_recharge_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_user_withdraw_log`
--

DROP TABLE IF EXISTS `cms_user_withdraw_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_user_withdraw_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `withdraw_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `min_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最低提现金额',
  `max_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最大提现金额',
  `
trade_no` char(100) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '支付平台交易号',
  `buyer_user` char(60) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '支付平台用户帐号',
  `payment` char(60) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '支付方式标记',
  `payment_name` char(60) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0提现中,1完成',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现成功时间',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户余额提现记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_user_withdraw_log`
--

LOCK TABLES `cms_user_withdraw_log` WRITE;
/*!40000 ALTER TABLE `cms_user_withdraw_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_user_withdraw_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-25 17:20:18
