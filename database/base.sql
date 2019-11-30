-- MySQL dump 10.13  Distrib 8.0.16, for macos10.14 (x86_64)
--
-- Host: 127.0.0.1    Database: wali
-- ------------------------------------------------------
-- Server version	5.7.18-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(45) NOT NULL COMMENT '系统编号',
  `child_name` varchar(45) NOT NULL COMMENT '孩子姓名',
  `parten_name` varchar(45) DEFAULT NULL COMMENT '家长姓名',
  `child_age` tinyint(2) NOT NULL COMMENT '孩子年龄',
  `child_sex` tinyint(1) NOT NULL COMMENT '性别（1男2女0未知）',
  `mobile` varchar(45) DEFAULT NULL COMMENT '电话',
  `phone` int(11) NOT NULL COMMENT '手机',
  `channel` varchar(45) NOT NULL COMMENT '渠道',
  `channel_detail` varchar(45) DEFAULT NULL COMMENT '渠道详情',
  `explain` varchar(45) DEFAULT NULL COMMENT '情况说明',
  `child_area` varchar(45) DEFAULT NULL COMMENT '孩子小区',
  `child_school` varchar(45) DEFAULT NULL COMMENT '孩子学校',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型（0、潜在信息，1、约访信息）',
  `describe_source` varchar(500) DEFAULT NULL COMMENT '资源描述',
  `describe_sales` varchar(500) DEFAULT NULL COMMENT '销售描述',
  `responer` int(11) DEFAULT NULL COMMENT '负责人',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时回见',
  `created_by` int(11) NOT NULL COMMENT '创建人',
  `collect_at` date DEFAULT NULL COMMENT '收集日期',
  `visit_at` date DEFAULT NULL COMMENT '回访日期',
  `part_number` varchar(45) DEFAULT NULL COMMENT '兼职编号',
  `status_hidden` tinyint(1) DEFAULT NULL COMMENT '潜在信息状态（0、还没拨打，1、没有确认，2、无效信息，3、有效信息）',
  `status_describe` varchar(500) DEFAULT NULL COMMENT '状态说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客户信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_icons`
--

DROP TABLE IF EXISTS `sys_icons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_icons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unicode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'unicode 字符',
  `class` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '类名',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_icons`
--

LOCK TABLES `sys_icons` WRITE;
/*!40000 ALTER TABLE `sys_icons` DISABLE KEYS */;
INSERT INTO `sys_icons` VALUES (1,'&#xe6c9;','layui-icon-rate-half','半星',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(2,'&#xe67b;','layui-icon-rate','星星-空心',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(3,'&#xe67a;','layui-icon-rate-solid','星星-实心',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(4,'&#xe678;','layui-icon-cellphone','手机',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(5,'&#xe679;','layui-icon-vercode','验证码',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(6,'&#xe677;','layui-icon-login-wechat','微信',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(7,'&#xe676;','layui-icon-login-qq','QQ',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(8,'&#xe675;','layui-icon-login-weibo','微博',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(9,'&#xe673;','layui-icon-password','密码',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(10,'&#xe66f;','layui-icon-username','用户名',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(11,'&#xe9aa;','layui-icon-refresh-3','刷新-粗',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(12,'&#xe672;','layui-icon-auz','授权',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(13,'&#xe66b;','layui-icon-spread-left','左向右伸缩菜单',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(14,'&#xe668;','layui-icon-shrink-right','右向左伸缩菜单',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(15,'&#xe6b1;','layui-icon-snowflake','雪花',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(16,'&#xe702;','layui-icon-tips','提示说明',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(17,'&#xe66e;','layui-icon-note','便签',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(18,'&#xe68e;','layui-icon-home','主页',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(19,'&#xe674;','layui-icon-senior','高级',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(20,'&#xe669;','layui-icon-refresh','刷新',0,'2018-11-12 10:40:18','2018-11-12 10:40:18'),(21,'&#xe666;','layui-icon-refresh-1','刷新',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(22,'&#xe66c;','layui-icon-flag','旗帜',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(23,'&#xe66a;','layui-icon-theme','主题',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(24,'&#xe667;','layui-icon-notice','消息-通知',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(25,'&#xe7ae;','layui-icon-website','网站',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(26,'&#xe665;','layui-icon-console','控制台',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(27,'&#xe664;','layui-icon-face-surprised','表情-惊讶',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(28,'&#xe716;','layui-icon-set','设置-空心',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(29,'&#xe656;','layui-icon-template-1','模板',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(30,'&#xe653;','layui-icon-app','应用',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(31,'&#xe663;','layui-icon-template','模板',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(32,'&#xe6c6;','layui-icon-praise','赞',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(33,'&#xe6c5;','layui-icon-tread','踩',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(34,'&#xe662;','layui-icon-male','男',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(35,'&#xe661;','layui-icon-female','女',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(36,'&#xe660;','layui-icon-camera','相机-空心',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(37,'&#xe65d;','layui-icon-camera-fill','相机-实心',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(38,'&#xe65f;','layui-icon-more','菜单-水平',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(39,'&#xe671;','layui-icon-more-vertical','菜单-垂直',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(40,'&#xe65e;','layui-icon-rmb','金额-人民币',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(41,'&#xe659;','layui-icon-dollar','金额-美元',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(42,'&#xe735;','layui-icon-diamond','钻石-等级',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(43,'&#xe756;','layui-icon-fire','火',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(44,'&#xe65c;','layui-icon-return','返回',0,'2018-11-12 10:40:19','2018-11-12 10:40:19'),(45,'&#xe715;','layui-icon-location','位置-地图',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(46,'&#xe705;','layui-icon-read','办公-阅读',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(47,'&#xe6b2;','layui-icon-survey','调查',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(48,'&#xe6af;','layui-icon-face-smile','表情-微笑',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(49,'&#xe69c;','layui-icon-face-cry','表情-哭泣',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(50,'&#xe698;','layui-icon-cart-simple','购物车',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(51,'&#xe657;','layui-icon-cart','购物车',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(52,'&#xe65b;','layui-icon-next','下一页',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(53,'&#xe65a;','layui-icon-prev','上一页',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(54,'&#xe681;','layui-icon-upload-drag','上传-空心-拖拽',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(55,'&#xe67c;','layui-icon-upload','上传-实心',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(56,'&#xe601;','layui-icon-download-circle','下载-圆圈',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(57,'&#xe857;','layui-icon-component','组件',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(58,'&#xe655;','layui-icon-file-b','文件-粗',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(59,'&#xe770;','layui-icon-user','用户',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(60,'&#xe670;','layui-icon-find-fill','发现-实心',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(61,'&#xe63d;','layui-icon-loading','loading',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(62,'&#xe63e;','layui-icon-loading-1','loading',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(63,'&#xe654;','layui-icon-add-1','添加',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(64,'&#xe652;','layui-icon-play','播放',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(65,'&#xe651;','layui-icon-pause','暂停',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(66,'&#xe6fc;','layui-icon-headset','音频-耳机',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(67,'&#xe6ed;','layui-icon-video','视频',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(68,'&#xe688;','layui-icon-voice','语音-声音',0,'2018-11-12 10:40:20','2018-11-12 10:40:20'),(69,'&#xe645;','layui-icon-speaker','消息-通知-喇叭',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(70,'&#xe64f;','layui-icon-fonts-del','删除线',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(71,'&#xe64e;','layui-icon-fonts-code','代码',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(72,'&#xe64b;','layui-icon-fonts-html','HTML',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(73,'&#xe62b;','layui-icon-fonts-strong','字体加粗',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(74,'&#xe64d;','layui-icon-unlink','删除链接',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(75,'&#xe64a;','layui-icon-picture','图片',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(76,'&#xe64c;','layui-icon-link','链接',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(77,'&#xe650;','layui-icon-face-smile-b','表情-笑-粗',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(78,'&#xe649;','layui-icon-align-left','左对齐',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(79,'&#xe648;','layui-icon-align-right','右对齐',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(80,'&#xe647;','layui-icon-align-center','居中对齐',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(81,'&#xe646;','layui-icon-fonts-u','字体-下划线',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(82,'&#xe644;','layui-icon-fonts-i','字体-斜体',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(83,'&#xe62a;','layui-icon-tabs','Tabs 选项卡',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(84,'&#xe643;','layui-icon-radio','单选框-选中',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(85,'&#xe63f;','layui-icon-circle','单选框-候选',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(86,'&#xe642;','layui-icon-edit','编辑',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(87,'&#xe641;','layui-icon-share','分享',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(88,'&#xe640;','layui-icon-delete','删除',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(89,'&#xe63c;','layui-icon-form','表单',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(90,'&#xe63b;','layui-icon-cellphone-fine','手机-细体',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(91,'&#xe63a;','layui-icon-dialogue','聊天 对话 沟通',0,'2018-11-12 10:40:21','2018-11-12 10:40:21'),(92,'&#xe639;','layui-icon-fonts-clear','文字格式化',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(93,'&#xe638;','layui-icon-layer','窗口',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(94,'&#xe637;','layui-icon-date','日期',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(95,'&#xe636;','layui-icon-water','水 下雨',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(96,'&#xe635;','layui-icon-code-circle','代码-圆圈',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(97,'&#xe634;','layui-icon-carousel','轮播组图',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(98,'&#xe633;','layui-icon-prev-circle','翻页',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(99,'&#xe632;','layui-icon-layouts','布局',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(100,'&#xe631;','layui-icon-util','工具',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(101,'&#xe630;','layui-icon-templeate-1','选择模板',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(102,'&#xe62f;','layui-icon-upload-circle','上传-圆圈',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(103,'&#xe62e;','layui-icon-tree','树',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(104,'&#xe62d;','layui-icon-table','表格',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(105,'&#xe62c;','layui-icon-chart','图表',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(106,'&#xe629;','layui-icon-chart-screen','图标 报表 屏幕',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(107,'&#xe628;','layui-icon-engine','引擎',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(108,'&#xe625;','layui-icon-triangle-d','下三角',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(109,'&#xe623;','layui-icon-triangle-r','右三角',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(110,'&#xe621;','layui-icon-file','文件',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(111,'&#xe620;','layui-icon-set-sm','设置-小型',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(112,'&#xe61f;','layui-icon-add-circle','添加-圆圈',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(113,'&#xe61c;','layui-icon-404','404',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(114,'&#xe60b;','layui-icon-about','关于',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(115,'&#xe619;','layui-icon-up','箭头 向上',0,'2018-11-12 10:40:22','2018-11-12 10:40:22'),(116,'&#xe61a;','layui-icon-down','箭头 向下',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(117,'&#xe603;','layui-icon-left','箭头 向左',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(118,'&#xe602;','layui-icon-right','箭头 向右',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(119,'&#xe617;','layui-icon-circle-dot','圆点',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(120,'&#xe615;','layui-icon-search','搜索',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(121,'&#xe614;','layui-icon-set-fill','设置-实心',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(122,'&#xe613;','layui-icon-group','群组',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(123,'&#xe612;','layui-icon-friends','好友',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(124,'&#xe611;','layui-icon-reply-fill','回复 评论 实心',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(125,'&#xe60f;','layui-icon-menu-fill','菜单 隐身 实心',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(126,'&#xe60e;','layui-icon-log','记录',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(127,'&#xe60d;','layui-icon-picture-fine','图片-细体',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(128,'&#xe60c;','layui-icon-face-smile-fine','表情-笑-细体',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(129,'&#xe60a;','layui-icon-list','列表',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(130,'&#xe609;','layui-icon-release','发布 纸飞机',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(131,'&#xe605;','layui-icon-ok','对 OK',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(132,'&#xe607;','layui-icon-help','帮助',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(133,'&#xe606;','layui-icon-chat','客服',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(134,'&#xe604;','layui-icon-top','top 置顶',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(135,'&#xe600;','layui-icon-star','收藏-空心',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(136,'&#xe658;','layui-icon-star-fill','收藏-实心',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(137,'&#x1007;','layui-icon-close-fill','关闭-实心',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(138,'&#x1006;','layui-icon-close','关闭-空心',0,'2018-11-12 10:40:23','2018-11-12 10:40:23'),(139,'&#x1005;','layui-icon-ok-circle','正确',0,'2018-11-12 10:40:24','2018-11-12 10:40:24'),(140,'&#xe608;','layui-icon-add-circle-fine','添加-圆圈-细体',0,'2018-11-12 10:40:24','2018-11-12 10:40:24');
/*!40000 ALTER TABLE `sys_icons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_log`
--

DROP TABLE IF EXISTS `sys_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `module` varchar(255) NOT NULL COMMENT '模块',
  `page` varchar(255) NOT NULL DEFAULT '' COMMENT '页面',
  `type` varchar(45) NOT NULL COMMENT '操作类型',
  `content` varchar(500) DEFAULT '' COMMENT '操作内容\n需要知道对应id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COMMENT='操作日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_log`
--

LOCK TABLES `sys_log` WRITE;
/*!40000 ALTER TABLE `sys_log` DISABLE KEYS */;
INSERT INTO `sys_log` VALUES (1,1,'超级管理员','1','用户管理新增','1','用户id:3','2019-11-30 08:08:33','2019-11-30 08:08:33'),(2,1,'超级管理员','1','用户管理新增','1','用户id:4','2019-11-30 08:09:00','2019-11-30 08:09:00'),(3,1,'超级管理员','1','人员管理编辑','2','人员id:','2019-11-30 08:40:18','2019-11-30 08:40:18'),(4,1,'超级管理员','1','用户管理新增','1','用户id:5','2019-11-30 08:41:09','2019-11-30 08:41:09'),(5,1,'超级管理员','1','用户管理编辑','2','人员id:','2019-11-30 08:41:22','2019-11-30 08:41:22'),(6,1,'超级管理员','1','用户管理编辑','2','人员id:','2019-11-30 08:41:30','2019-11-30 08:41:30'),(7,1,'超级管理员','1','用户管理删除','3','用户id:Array','2019-11-30 08:44:27','2019-11-30 08:44:27'),(8,1,'超级管理员','1','用户管理分配角色','2','用户id:2','2019-11-30 08:47:10','2019-11-30 08:47:10'),(9,1,'超级管理员','1','用户管理分配角色','2','用户id:2','2019-11-30 08:47:15','2019-11-30 08:47:15'),(10,1,'超级管理员','2','角色管理','2','编辑角色：1','2019-11-30 10:50:43','2019-11-30 10:50:43'),(11,1,'超级管理员','2','角色管理','2','编辑角色：1','2019-11-30 10:50:48','2019-11-30 10:50:48'),(12,1,'超级管理员','2','角色管理','1','添加角色：2','2019-11-30 10:51:04','2019-11-30 10:51:04'),(13,1,'超级管理员','2','角色管理','3','删除角色：2','2019-11-30 10:54:58','2019-11-30 10:54:58'),(14,1,'超级管理员','2','角色管理','2','编辑角色权限，角色：1','2019-11-30 10:55:51','2019-11-30 10:55:51'),(15,1,'超级管理员','2','角色管理','2','编辑角色权限，角色：1','2019-11-30 10:55:56','2019-11-30 10:55:56'),(16,1,'超级管理员','2','角色管理','2','编辑角色权限，角色：1','2019-11-30 10:56:01','2019-11-30 10:56:01'),(17,1,'超级管理员','2','角色管理','2','编辑角色：1','2019-11-30 10:56:25','2019-11-30 10:56:25'),(18,1,'超级管理员','3','权限管理','1','添加权限：18','2019-11-30 11:54:26','2019-11-30 11:54:26'),(19,1,'超级管理员','3','权限管理','2','编辑权限：17','2019-11-30 11:55:17','2019-11-30 11:55:17'),(20,1,'超级管理员','3','权限管理','3','删除权限：17','2019-11-30 11:55:20','2019-11-30 11:55:20'),(21,1,'超级管理员','3','权限管理','2','编辑权限：1','2019-11-30 11:58:44','2019-11-30 11:58:44'),(22,1,'超级管理员','3','权限管理','1','添加权限：19','2019-11-30 11:58:50','2019-11-30 11:58:50'),(23,1,'超级管理员','3','权限管理','3','删除权限：19','2019-11-30 11:58:54','2019-11-30 11:58:54');
/*!40000 ALTER TABLE `sys_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_messages`
--

DROP TABLE IF EXISTS `sys_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '消息标题',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '消息内容',
  `read` int(11) NOT NULL DEFAULT '1' COMMENT '1-未读，2-已读',
  `send_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '消息发送者UUID，1表示系统发送',
  `accept_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '消息接收者UUID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `flag` int(11) NOT NULL COMMENT '消息对应关系：1-审核消息，2-打印消息，3-退款消息',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_messages`
--

LOCK TABLES `sys_messages` WRITE;
/*!40000 ALTER TABLE `sys_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_model_has_permissions`
--

DROP TABLE IF EXISTS `sys_model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_model_has_permissions`
--

LOCK TABLES `sys_model_has_permissions` WRITE;
/*!40000 ALTER TABLE `sys_model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_model_has_roles`
--

DROP TABLE IF EXISTS `sys_model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_model_has_roles`
--

LOCK TABLES `sys_model_has_roles` WRITE;
/*!40000 ALTER TABLE `sys_model_has_roles` DISABLE KEYS */;
INSERT INTO `sys_model_has_roles` VALUES (1,1,'App\\Models\\User');
/*!40000 ALTER TABLE `sys_model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_permissions`
--

DROP TABLE IF EXISTS `sys_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '路由名称',
  `icon_id` int(11) DEFAULT NULL COMMENT '图标ID',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_permissions`
--

LOCK TABLES `sys_permissions` WRITE;
/*!40000 ALTER TABLE `sys_permissions` DISABLE KEYS */;
INSERT INTO `sys_permissions` VALUES (1,'system.manage','web','系统管理',NULL,NULL,0,1,'2019-04-02 03:28:00','2019-11-30 11:58:44'),(2,'system.user','web','用户管理','admin.user',NULL,1,0,'2019-04-02 03:28:00','2019-05-31 03:00:00'),(3,'system.user.create','web','添加用户','admin.user.create',1,2,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(4,'system.user.edit','web','编辑用户','admin.user.edit',1,2,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(5,'system.user.destroy','web','删除用户','admin.user.destroy',1,2,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(6,'system.user.role','web','分配角色','admin.user.role',1,2,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(7,'system.user.permission','web','分配权限','admin.user.permission',1,2,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(8,'system.role','web','角色管理','admin.role',121,1,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(9,'system.role.create','web','添加角色','admin.role.create',1,8,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(10,'system.role.edit','web','编辑角色','admin.role.edit',1,8,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(11,'system.role.destroy','web','删除角色','admin.role.destroy',1,8,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(12,'system.role.permission','web','分配权限','admin.role.permission',1,8,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(13,'system.permission','web','权限管理','admin.permission',12,1,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(14,'system.permission.create','web','添加权限','admin.permission.create',1,13,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(15,'system.permission.edit','web','编辑权限','admin.permission.edit',1,13,0,'2019-04-02 03:28:00','2019-04-02 03:28:00'),(16,'system.permission.destroy','web','删除权限','admin.permission.destroy',1,13,0,'2019-04-02 03:28:00','2019-04-02 03:28:00');
/*!40000 ALTER TABLE `sys_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_role_has_permissions`
--

DROP TABLE IF EXISTS `sys_role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_role_has_permissions`
--

LOCK TABLES `sys_role_has_permissions` WRITE;
/*!40000 ALTER TABLE `sys_role_has_permissions` DISABLE KEYS */;
INSERT INTO `sys_role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1);
/*!40000 ALTER TABLE `sys_role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_roles`
--

DROP TABLE IF EXISTS `sys_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_roles`
--

LOCK TABLES `sys_roles` WRITE;
/*!40000 ALTER TABLE `sys_roles` DISABLE KEYS */;
INSERT INTO `sys_roles` VALUES (1,'admin','web','超级管理员','2019-11-20 03:45:00','2019-11-30 10:50:47');
/*!40000 ALTER TABLE `sys_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_users`
--

DROP TABLE IF EXISTS `sys_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sys_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '姓名',
  `mobile` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '手机',
  `usercode` varchar(45) COLLATE utf8mb4_bin NOT NULL COMMENT '登录名',
  `userpass` varchar(128) COLLATE utf8mb4_bin NOT NULL COMMENT '密码',
  `useremail` varchar(128) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '邮箱',
  `userlasttime` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `userlastip` varchar(15) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '最后登录ip',
  `remember_token` varchar(128) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '登录token',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_users`
--

LOCK TABLES `sys_users` WRITE;
/*!40000 ALTER TABLE `sys_users` DISABLE KEYS */;
INSERT INTO `sys_users` VALUES (1,'超级管理员','18301895289','admin','$2y$10$V.sg.b6aMv1PCE/gspeKlO4sqA8a1zz3mnXZbP2dLlVoQOAYJr/H.',NULL,1574821074,'11','oK6fEkvUC3gChz9uDW5YEkQ4U3mQYDDh1nN8nSH4TtTNyicfFvspC8gHlP0T','2019-11-30 08:04:30','2019-11-30 08:47:22'),(2,'刘慧军','18301895289','刘慧军','$2y$10$PZ25GbIO1B5myUdV6eoxBeEaZ60mvwESIBumibBO8wGo.Ii2/jACW','lhj544@sohu.com',NULL,NULL,'xvOq5S09IVyTXm8x5VFwsSD0agbdDILysktz7cNLW95IESWnrnHyTL1T7IGw','2019-11-30 08:04:35','2019-11-30 08:48:24');
/*!40000 ALTER TABLE `sys_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-30 20:22:44
