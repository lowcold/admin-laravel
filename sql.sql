-- MySQL dump 10.13  Distrib 5.7.26, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: admin_cold_com
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `cold_admin`
--

DROP TABLE IF EXISTS `cold_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cold_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL COMMENT '用户名',
  `password` varchar(60) DEFAULT NULL COMMENT '密码',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cold_admin_id_uindex` (`id`),
  UNIQUE KEY `cold_admin_username_uindex` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cold_admin`
--

LOCK TABLES `cold_admin` WRITE;
/*!40000 ALTER TABLE `cold_admin` DISABLE KEYS */;
INSERT INTO `cold_admin` VALUES (1,0,'admin','$2y$10$u/p9adJF3M2VfdM0QrfbD.2OkK2KVQv7rsBGHfxW/WvS.NMw1BdaW',1666150391,1666150391,NULL);
/*!40000 ALTER TABLE `cold_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cold_admin_group`
--

DROP TABLE IF EXISTS `cold_admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cold_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '分组名称',
  `rule` text COMMENT '分组规则',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cold_admin_group_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员分组';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cold_admin_group`
--

LOCK TABLES `cold_admin_group` WRITE;
/*!40000 ALTER TABLE `cold_admin_group` DISABLE KEYS */;
INSERT INTO `cold_admin_group` VALUES (1,'超级管理员','1,2,3,4,5,6,7,8,9,10,11,12',0,1666230687,NULL);
/*!40000 ALTER TABLE `cold_admin_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cold_admin_rule`
--

DROP TABLE IF EXISTS `cold_admin_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cold_admin_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL COMMENT '上级路由',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `title` varchar(20) DEFAULT NULL COMMENT '路由标题',
  `name` varchar(255) DEFAULT NULL COMMENT '路由名称',
  `path` varchar(255) DEFAULT NULL COMMENT '路由地址',
  `component` varchar(255) DEFAULT NULL COMMENT '页面地址',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `admin` varchar(255) DEFAULT NULL COMMENT '对应后台控制器方法',
  `show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '路由显示：1显示，2不显示',
  `menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '菜单显示：1显示，2不显示',
  `layout` tinyint(1) DEFAULT '1' COMMENT 'layout布局：1使用，2不使用',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cold_admin_rule_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='权限规则表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cold_admin_rule`
--

LOCK TABLES `cold_admin_rule` WRITE;
/*!40000 ALTER TABLE `cold_admin_rule` DISABLE KEYS */;
INSERT INTO `cold_admin_rule` VALUES (1,0,0,'图表','Home','Home','Layout','bar-chart',NULL,1,1,1,1666160964,1666230423,NULL),(2,1,0,'echarts','HomeEcharts','/','/views/echarts/index.vue','bar-chart',NULL,1,1,1,1666160964,1666160964,NULL),(3,0,0,'图标','Icon','Icon','Layout','fonticons',NULL,1,1,1,1666160964,1666160964,NULL),(4,3,0,'icon图标库','IconIndex','/icon','/views/icon/index.vue','fonticons',NULL,1,1,1,1666160964,1666160964,NULL),(5,0,0,'ELP','ELP','ELP','Layout','etsy',NULL,1,1,1,1666160964,1666160964,NULL),(6,5,0,'Form表单','ELPForm','/form','/views/elp/form.vue','wpforms',NULL,1,1,1,1666160964,1666160964,NULL),(7,5,0,'Table表格','ELPTable','/table','/views/elp/table.vue','table',NULL,1,1,1,1666160964,1666160964,NULL),(8,5,0,'Tabs标签','ELPTabs','/tabs','/views/elp/tabs.vue','window-restore',NULL,1,1,1,1666160964,1666160964,NULL);
/*!40000 ALTER TABLE `cold_admin_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cold_admin_rule_button`
--

DROP TABLE IF EXISTS `cold_admin_rule_button`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cold_admin_rule_button` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) DEFAULT NULL COMMENT '对应权限规则id',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `title` varchar(20) DEFAULT NULL COMMENT '标题',
  `icon` int(11) DEFAULT NULL COMMENT '图表',
  `component` int(11) DEFAULT NULL COMMENT '页面地址',
  `admin` varchar(255) DEFAULT NULL COMMENT '后端控制器方法',
  `show` tinyint(1) DEFAULT NULL COMMENT '1显示，2不显示',
  `type` tinyint(1) DEFAULT '2' COMMENT '按钮分类：1顶部，2右侧操作',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `deleted_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cold_rules_button_id_uindex` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限规则按钮表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cold_admin_rule_button`
--

LOCK TABLES `cold_admin_rule_button` WRITE;
/*!40000 ALTER TABLE `cold_admin_rule_button` DISABLE KEYS */;
/*!40000 ALTER TABLE `cold_admin_rule_button` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cold_config`
--

DROP TABLE IF EXISTS `cold_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cold_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '配置名称',
  `value` varchar(255) DEFAULT NULL COMMENT '配置内容',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_at` int(11) DEFAULT NULL,
  `update_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cold_config_id_uindex` (`id`),
  UNIQUE KEY `cold_config_name_uindex` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='配置信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cold_config`
--

LOCK TABLES `cold_config` WRITE;
/*!40000 ALTER TABLE `cold_config` DISABLE KEYS */;
INSERT INTO `cold_config` VALUES (1,'wechat_follow_reply','您好，欢迎关注测试！','公众号关注回复消息',NULL,NULL,NULL);
/*!40000 ALTER TABLE `cold_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cold_member`
--

DROP TABLE IF EXISTS `cold_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cold_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(6) DEFAULT NULL COMMENT '用户唯一UID',
  `gid` tinyint(4) DEFAULT NULL COMMENT '用户等级id',
  `parent` int(11) DEFAULT NULL COMMENT '上级用户ID',
  `password` varchar(60) DEFAULT NULL COMMENT '用户密码',
  `username` varchar(20) DEFAULT NULL COMMENT '用户名称',
  `nikename` varchar(50) DEFAULT NULL COMMENT '用户昵称',
  `realname` varchar(10) DEFAULT NULL COMMENT '真实姓名',
  `money` decimal(10,2) DEFAULT '0.00',
  `integral` decimal(10,2) DEFAULT '0.00',
  `consume` decimal(10,2) DEFAULT '0.00' COMMENT '累计消费金额',
  `direct_kpi` decimal(10,2) DEFAULT '0.00' COMMENT '直推业绩',
  `team_kpi` decimal(10,2) DEFAULT '0.00' COMMENT '团队业绩',
  `created_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cold_member_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cold_member`
--

LOCK TABLES `cold_member` WRITE;
/*!40000 ALTER TABLE `cold_member` DISABLE KEYS */;
INSERT INTO `cold_member` VALUES (1,NULL,1,0,'123456','cold',NULL,NULL,0.00,0.00,0.00,0.00,0.00,1666236412,1666236729,NULL),(2,NULL,1,1,'cold1','cold1',NULL,NULL,0.00,0.00,0.00,0.00,0.00,1666238338,1666238338,NULL),(3,NULL,1,1,'cold2','cold2',NULL,NULL,0.00,0.00,0.00,0.00,0.00,1666238355,1666238355,NULL);
/*!40000 ALTER TABLE `cold_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cold_member_closure`
--

DROP TABLE IF EXISTS `cold_member_closure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cold_member_closure` (
  `ancestor` int(11) DEFAULT NULL COMMENT '祖先：上级节点的id',
  `descendant` int(11) DEFAULT NULL COMMENT '子代：下级节点的id',
  `distance` int(11) DEFAULT NULL COMMENT '距离：子代到祖先中间隔了几级'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关系表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cold_member_closure`
--

LOCK TABLES `cold_member_closure` WRITE;
/*!40000 ALTER TABLE `cold_member_closure` DISABLE KEYS */;
INSERT INTO `cold_member_closure` VALUES (1,1,0),(1,2,1),(2,2,0),(1,3,1),(3,3,0);
/*!40000 ALTER TABLE `cold_member_closure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cold_member_grade`
--

DROP TABLE IF EXISTS `cold_member_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cold_member_grade` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `push` int(11) DEFAULT NULL COMMENT '升级推荐人数',
  `direct_kpi` decimal(10,2) DEFAULT NULL COMMENT '升级直推业绩',
  `team_kpi` decimal(10,2) DEFAULT NULL COMMENT '升级团队业绩',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cold_member_grade_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户等级表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cold_member_grade`
--

LOCK TABLES `cold_member_grade` WRITE;
/*!40000 ALTER TABLE `cold_member_grade` DISABLE KEYS */;
INSERT INTO `cold_member_grade` VALUES (1,'一级用户',NULL,NULL,NULL,1666234972,1666235181,NULL);
/*!40000 ALTER TABLE `cold_member_grade` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-25 10:22:05
