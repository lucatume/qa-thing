-- MySQL dump 10.13  Distrib 5.7.15, for osx10.11 (x86_64)
--
-- Host: 127.0.0.1    Database: wp
-- ------------------------------------------------------
-- Server version	5.7.15

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
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_commentmeta`
--

LOCK TABLES `wp_commentmeta` WRITE;
/*!40000 ALTER TABLE `wp_commentmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_commentmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_comments`
--

LOCK TABLES `wp_comments` WRITE;
/*!40000 ALTER TABLE `wp_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_links`
--

LOCK TABLES `wp_links` WRITE;
/*!40000 ALTER TABLE `wp_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1289 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_options`
--

LOCK TABLES `wp_options` WRITE;
/*!40000 ALTER TABLE `wp_options` DISABLE KEYS */;
INSERT INTO `wp_options` VALUES (1,'siteurl','http://wp.dev','yes'),(2,'home','http://wp.dev','yes'),(3,'blogname','WP-Dev','yes'),(4,'blogdescription','Just another WordPress site','yes'),(5,'users_can_register','0','yes'),(6,'admin_email','admin@wp.dev','yes'),(7,'start_of_week','1','yes'),(8,'use_balanceTags','0','yes'),(9,'use_smilies','1','yes'),(10,'require_name_email','1','yes'),(11,'comments_notify','1','yes'),(12,'posts_per_rss','10','yes'),(13,'rss_use_excerpt','0','yes'),(14,'mailserver_url','mail.example.com','yes'),(15,'mailserver_login','login@example.com','yes'),(16,'mailserver_pass','password','yes'),(17,'mailserver_port','110','yes'),(18,'default_category','1','yes'),(19,'default_comment_status','open','yes'),(20,'default_ping_status','open','yes'),(21,'default_pingback_flag','0','yes'),(22,'posts_per_page','10','yes'),(23,'date_format','F j, Y','yes'),(24,'time_format','g:i a','yes'),(25,'links_updated_date_format','F j, Y g:i a','yes'),(26,'comment_moderation','0','yes'),(27,'moderation_notify','1','yes'),(28,'permalink_structure','/%year%/%monthnum%/%day%/%postname%/','yes'),(29,'rewrite_rules','a:90:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:58:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:68:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:88:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:64:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:53:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$\";s:91:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:77:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:65:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:61:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:47:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:53:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:51:\"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:38:\"([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}','yes'),(30,'hack_file','0','yes'),(31,'blog_charset','UTF-8','yes'),(32,'moderation_keys','','no'),(33,'active_plugins','a:1:{i:0;s:21:\"qa-thing/qa-thing.php\";}','yes'),(34,'category_base','','yes'),(35,'ping_sites','http://rpc.pingomatic.com/','yes'),(36,'comment_max_links','2','yes'),(37,'gmt_offset','0','yes'),(38,'default_email_category','1','yes'),(39,'recently_edited','','no'),(40,'template','twentysixteen','yes'),(41,'stylesheet','twentysixteen','yes'),(42,'comment_whitelist','1','yes'),(43,'blacklist_keys','','no'),(44,'comment_registration','0','yes'),(45,'html_type','text/html','yes'),(46,'use_trackback','0','yes'),(47,'default_role','subscriber','yes'),(48,'db_version','38590','yes'),(49,'uploads_use_yearmonth_folders','1','yes'),(50,'upload_path','','yes'),(51,'blog_public','0','yes'),(52,'default_link_category','2','yes'),(53,'show_on_front','posts','yes'),(54,'tag_base','','yes'),(55,'show_avatars','1','yes'),(56,'avatar_rating','G','yes'),(57,'upload_url_path','','yes'),(58,'thumbnail_size_w','150','yes'),(59,'thumbnail_size_h','150','yes'),(60,'thumbnail_crop','1','yes'),(61,'medium_size_w','300','yes'),(62,'medium_size_h','300','yes'),(63,'avatar_default','mystery','yes'),(64,'large_size_w','1024','yes'),(65,'large_size_h','1024','yes'),(66,'image_default_link_type','none','yes'),(67,'image_default_size','','yes'),(68,'image_default_align','','yes'),(69,'close_comments_for_old_posts','0','yes'),(70,'close_comments_days_old','14','yes'),(71,'thread_comments','1','yes'),(72,'thread_comments_depth','5','yes'),(73,'page_comments','0','yes'),(74,'comments_per_page','50','yes'),(75,'default_comments_page','newest','yes'),(76,'comment_order','asc','yes'),(77,'sticky_posts','a:0:{}','yes'),(78,'widget_categories','a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),(79,'widget_text','a:0:{}','yes'),(80,'widget_rss','a:0:{}','yes'),(81,'uninstall_plugins','a:0:{}','no'),(82,'timezone_string','','yes'),(83,'page_for_posts','0','yes'),(84,'page_on_front','0','yes'),(85,'default_post_format','0','yes'),(86,'link_manager_enabled','0','yes'),(87,'finished_splitting_shared_terms','1','yes'),(88,'site_icon','0','yes'),(89,'medium_large_size_w','768','yes'),(90,'medium_large_size_h','0','yes'),(91,'initial_db_version','36686','yes'),(92,'wp_user_roles','a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:61:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}','yes'),(93,'widget_search','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),(94,'widget_recent-posts','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),(95,'widget_recent-comments','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),(96,'widget_archives','a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),(97,'widget_meta','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),(98,'sidebars_widgets','a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"array_version\";i:3;}','yes'),(99,'widget_pages','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(100,'widget_calendar','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(101,'widget_tag_cloud','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(102,'widget_nav_menu','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(103,'cron','a:5:{i:1482526480;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1482534487;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1482536599;a:1:{s:20:\"wp_stream_auto_purge\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1482569719;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}s:7:\"version\";i:2;}','yes'),(125,'recently_activated','a:3:{s:21:\"qa-thing/qa-thing.php\";i:1482493713;s:40:\"wordpress-beta-tester/wp-beta-tester.php\";i:1482493688;s:17:\"stream/stream.php\";i:1482417207;}','yes'),(146,'wp_beta_tester_stream','unstable','yes'),(150,'db_upgraded','','yes'),(153,'can_compress_scripts','1','no'),(164,'auto_core_update_notified','a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:12:\"admin@wp.dev\";s:7:\"version\";s:15:\"4.8-alpha-39626\";s:9:\"timestamp\";i:1482398482;}','no'),(166,'theme_mods_twentysixteen','a:1:{s:18:\"custom_css_post_id\";i:-1;}','yes'),(271,'qa_issue_number','','yes'),(313,'qa-status-qa-thing:','done','yes'),(1265,'_site_transient_timeout_browser_55ae8ef8628e0f8d24166d0eb8f0f156','1483011592','no'),(1266,'_site_transient_browser_55ae8ef8628e0f8d24166d0eb8f0f156','a:9:{s:8:\"platform\";s:9:\"Macintosh\";s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:12:\"54.0.2840.98\";s:10:\"update_url\";s:28:\"http://www.google.com/chrome\";s:7:\"img_src\";s:49:\"http://s.wordpress.org/images/browsers/chrome.png\";s:11:\"img_src_ssl\";s:48:\"https://wordpress.org/images/browsers/chrome.png\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;}','no'),(1267,'_transient_timeout_plugin_slugs','1482503607','no'),(1268,'_transient_plugin_slugs','a:52:{i:0;s:25:\"aaa-plugin/aaa-plugin.php\";i:1;s:22:\"acme-plugin/plugin.php\";i:2;s:31:\"airplane-mode/airplane-mode.php\";i:3;s:19:\"akismet/akismet.php\";i:4;s:13:\"cmb2/init.php\";i:5;s:35:\"cmb2-meta-split/cmb2-meta-split.php\";i:6;s:25:\"CMB2-Pipes/cmb2-pipes.php\";i:7;s:35:\"cmb2-tad-fields/cmb2-tad-fields.php\";i:8;s:30:\"codeception-beta-22/plugin.php\";i:9;s:23:\"developer/developer.php\";i:10;s:23:\"dhvc-form/dhvc-form.php\";i:11;s:35:\"easy-tables-vc/vc-table-manager.php\";i:12;s:41:\"etsy-little-helper/etsy-little-helper.php\";i:13;s:25:\"fakerpress/fakerpress.php\";i:14;s:41:\"tad-featured-image/tad-featured-image.php\";i:15;s:31:\"front-to-back/front-to-back.php\";i:16;s:25:\"idlikethis/idlikethis.php\";i:17;s:19:\"intense/intense.php\";i:18;s:30:\"wp-intercooler/intercooler.php\";i:19;s:53:\"ic-lazy-loading/intercooler_js_image_lazy_loading.php\";i:20;s:25:\"italystrap/italystrap.php\";i:21;s:27:\"LayerSlider/layerslider.php\";i:22;s:49:\"log-deprecated-notices/log-deprecated-notices.php\";i:23;s:25:\"log-viewer/log-viewer.php\";i:24;s:45:\"minimum-requirements/minimum-requirements.php\";i:25;s:33:\"monster-widget/monster-widget.php\";i:26;s:50:\"multi-image-control/multi-image-custom-control.php\";i:27;s:21:\"piglatin/piglatin.php\";i:28;s:33:\"posts-to-posts/posts-to-posts.php\";i:29;s:21:\"qa-thing/qa-thing.php\";i:30;s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";i:31;s:33:\"tad-reschedule/tad-reschedule.php\";i:32;s:59:\"resize-images-before-upload/resize-images-before-upload.php\";i:33;s:25:\"rest-query/rest-query.php\";i:34;s:51:\"rewrite-rules-inspector/rewrite-rules-inspector.php\";i:35;s:17:\"stream/stream.php\";i:36;s:49:\"tad-restricted-content/tad-restricted-content.php\";i:37;s:21:\"tad-post/tad_post.php\";i:38;s:31:\"tad-validator/tad_validator.php\";i:39;s:33:\"tad-meta-boxes/tad-meta-boxes.php\";i:40;s:43:\"the-events-calendar/the-events-calendar.php\";i:41;s:41:\"Ultimate_VC_Addons/Ultimate_VC_Addons.php\";i:42;s:27:\"user-groups/user-groups.php\";i:43;s:67:\"user-groups-content-restriction/user-groups-content-restriction.php\";i:44;s:63:\"user-role-content-restriction/user-role-content-restriciton.php\";i:45;s:33:\"user-switching/user-switching.php\";i:46;s:27:\"wonderloops/wonderloops.php\";i:47;s:40:\"wordpress-beta-tester/wp-beta-tester.php\";i:48;s:27:\"js_composer/js_composer.php\";i:49;s:15:\"acme/plugin.php\";i:50;s:19:\"rest-api/plugin.php\";i:51;s:23:\"wp-routes/wp-routes.php\";}','no'),(1269,'_transient_timeout_dash_88ae138922fe95674369b1cb3d215a2b','1482449996','no'),(1270,'_transient_dash_88ae138922fe95674369b1cb3d215a2b','<div class=\"rss-widget\"><p><strong>RSS Error:</strong> WP HTTP Error: cURL error 51: SSL: certificate verification failed (result: 0)</p></div><div class=\"rss-widget\"><p><strong>RSS Error:</strong> WP HTTP Error: cURL error 51: SSL: certificate verification failed (result: 0)</p></div><div class=\"rss-widget\"><ul></ul></div>','no'),(1276,'_site_transient_update_themes','O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1482493695;s:7:\"checked\";a:17:{s:12:\"Parallax-One\";s:8:\"2.1.0.13\";s:12:\"Parallax-Two\";s:5:\"0.1.0\";s:12:\"childsixteen\";s:5:\"0.1.0\";s:4:\"lazy\";s:5:\"1.0.0\";s:7:\"oblique\";s:5:\"2.0.2\";s:21:\"rest-infra-demo-theme\";s:3:\"1.0\";s:21:\"rest-query-demo-theme\";s:3:\"1.0\";s:8:\"todo-mvc\";s:0:\"\";s:12:\"twentyeleven\";s:3:\"2.5\";s:13:\"twentyfifteen\";s:3:\"1.7\";s:14:\"twentyfourteen\";s:3:\"1.9\";s:15:\"twentyseventeen\";s:3:\"1.0\";s:13:\"twentysixteen\";s:3:\"1.3\";s:9:\"twentyten\";s:3:\"2.2\";s:14:\"twentythirteen\";s:3:\"2.1\";s:12:\"twentytwelve\";s:3:\"2.2\";s:9:\"ultimatum\";s:5:\"2.8.4\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}}','no'),(1278,'_site_transient_update_plugins','O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1482493707;s:7:\"checked\";a:52:{s:25:\"aaa-plugin/aaa-plugin.php\";s:5:\"0.1.0\";s:22:\"acme-plugin/plugin.php\";s:3:\"1.0\";s:31:\"airplane-mode/airplane-mode.php\";s:5:\"0.0.3\";s:19:\"akismet/akismet.php\";s:3:\"3.2\";s:13:\"cmb2/init.php\";s:7:\"2.2.3.1\";s:35:\"cmb2-meta-split/cmb2-meta-split.php\";s:3:\"1.0\";s:25:\"CMB2-Pipes/cmb2-pipes.php\";s:3:\"1.0\";s:35:\"cmb2-tad-fields/cmb2-tad-fields.php\";s:3:\"1.0\";s:30:\"codeception-beta-22/plugin.php\";s:3:\"1.0\";s:23:\"developer/developer.php\";s:5:\"1.2.6\";s:23:\"dhvc-form/dhvc-form.php\";s:5:\"1.3.7\";s:35:\"easy-tables-vc/vc-table-manager.php\";s:5:\"1.0.5\";s:41:\"etsy-little-helper/etsy-little-helper.php\";s:3:\"1.0\";s:25:\"fakerpress/fakerpress.php\";s:5:\"0.4.7\";s:41:\"tad-featured-image/tad-featured-image.php\";s:3:\"1.0\";s:31:\"front-to-back/front-to-back.php\";s:3:\"1.0\";s:25:\"idlikethis/idlikethis.php\";s:3:\"1.0\";s:19:\"intense/intense.php\";s:5:\"2.5.7\";s:30:\"wp-intercooler/intercooler.php\";s:5:\"0.1.0\";s:53:\"ic-lazy-loading/intercooler_js_image_lazy_loading.php\";s:5:\"0.1.0\";s:25:\"italystrap/italystrap.php\";s:5:\"2.2.1\";s:27:\"LayerSlider/layerslider.php\";s:5:\"5.5.0\";s:49:\"log-deprecated-notices/log-deprecated-notices.php\";s:3:\"0.3\";s:25:\"log-viewer/log-viewer.php\";s:8:\"14.05.04\";s:45:\"minimum-requirements/minimum-requirements.php\";s:5:\"1.0.0\";s:33:\"monster-widget/monster-widget.php\";s:3:\"0.3\";s:50:\"multi-image-control/multi-image-custom-control.php\";s:3:\"1.0\";s:21:\"piglatin/piglatin.php\";s:3:\"0.2\";s:33:\"posts-to-posts/posts-to-posts.php\";s:5:\"1.6.5\";s:21:\"qa-thing/qa-thing.php\";s:3:\"1.0\";s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";s:5:\"2.2.6\";s:33:\"tad-reschedule/tad-reschedule.php\";s:3:\"1.0\";s:59:\"resize-images-before-upload/resize-images-before-upload.php\";s:3:\"1.8\";s:25:\"rest-query/rest-query.php\";s:3:\"1.0\";s:51:\"rewrite-rules-inspector/rewrite-rules-inspector.php\";s:5:\"1.2.1\";s:17:\"stream/stream.php\";s:5:\"3.1.1\";s:49:\"tad-restricted-content/tad-restricted-content.php\";s:3:\"1.0\";s:21:\"tad-post/tad_post.php\";s:5:\"0.1.0\";s:31:\"tad-validator/tad_validator.php\";s:5:\"0.1.0\";s:33:\"tad-meta-boxes/tad-meta-boxes.php\";s:3:\"1.0\";s:43:\"the-events-calendar/the-events-calendar.php\";s:7:\"4.4dev1\";s:41:\"Ultimate_VC_Addons/Ultimate_VC_Addons.php\";s:6:\"3.13.2\";s:27:\"user-groups/user-groups.php\";s:5:\"1.3.1\";s:67:\"user-groups-content-restriction/user-groups-content-restriction.php\";s:9:\"0.1-alpha\";s:63:\"user-role-content-restriction/user-role-content-restriciton.php\";s:9:\"0.1-alpha\";s:33:\"user-switching/user-switching.php\";s:5:\"1.0.9\";s:27:\"wonderloops/wonderloops.php\";s:5:\"2.0.0\";s:40:\"wordpress-beta-tester/wp-beta-tester.php\";s:5:\"1.0.2\";s:27:\"js_composer/js_composer.php\";s:6:\"4.6.2a\";s:15:\"acme/plugin.php\";s:5:\"0.1.0\";s:19:\"rest-api/plugin.php\";s:10:\"2.0-beta15\";s:23:\"wp-routes/wp-routes.php\";s:3:\"1.0\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:20:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:2:\"15\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:3:\"3.2\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:54:\"https://downloads.wordpress.org/plugin/akismet.3.2.zip\";}s:13:\"cmb2/init.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"53754\";s:4:\"slug\";s:4:\"cmb2\";s:6:\"plugin\";s:13:\"cmb2/init.php\";s:11:\"new_version\";s:7:\"2.2.3.1\";s:3:\"url\";s:35:\"https://wordpress.org/plugins/cmb2/\";s:7:\"package\";s:47:\"https://downloads.wordpress.org/plugin/cmb2.zip\";}s:23:\"developer/developer.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"24908\";s:4:\"slug\";s:9:\"developer\";s:6:\"plugin\";s:23:\"developer/developer.php\";s:11:\"new_version\";s:5:\"1.2.6\";s:3:\"url\";s:40:\"https://wordpress.org/plugins/developer/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/plugin/developer.1.2.6.zip\";}s:25:\"fakerpress/fakerpress.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"51295\";s:4:\"slug\";s:10:\"fakerpress\";s:6:\"plugin\";s:25:\"fakerpress/fakerpress.php\";s:11:\"new_version\";s:5:\"0.4.7\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/fakerpress/\";s:7:\"package\";s:53:\"https://downloads.wordpress.org/plugin/fakerpress.zip\";}s:25:\"italystrap/italystrap.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"56599\";s:4:\"slug\";s:10:\"italystrap\";s:6:\"plugin\";s:25:\"italystrap/italystrap.php\";s:11:\"new_version\";s:5:\"2.2.1\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/italystrap/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/plugin/italystrap.2.2.1.zip\";}s:49:\"log-deprecated-notices/log-deprecated-notices.php\";O:8:\"stdClass\":7:{s:2:\"id\";s:5:\"15700\";s:4:\"slug\";s:22:\"log-deprecated-notices\";s:6:\"plugin\";s:49:\"log-deprecated-notices/log-deprecated-notices.php\";s:11:\"new_version\";s:3:\"0.3\";s:3:\"url\";s:53:\"https://wordpress.org/plugins/log-deprecated-notices/\";s:7:\"package\";s:69:\"https://downloads.wordpress.org/plugin/log-deprecated-notices.0.3.zip\";s:14:\"upgrade_notice\";s:60:\"Updated to handle a new deprecated message in WordPress 4.0.\";}s:25:\"log-viewer/log-viewer.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"35109\";s:4:\"slug\";s:10:\"log-viewer\";s:6:\"plugin\";s:25:\"log-viewer/log-viewer.php\";s:11:\"new_version\";s:8:\"14.05.04\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/log-viewer/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/log-viewer.14.05.04.zip\";}s:33:\"monster-widget/monster-widget.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"31537\";s:4:\"slug\";s:14:\"monster-widget\";s:6:\"plugin\";s:33:\"monster-widget/monster-widget.php\";s:11:\"new_version\";s:3:\"0.3\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/monster-widget/\";s:7:\"package\";s:57:\"https://downloads.wordpress.org/plugin/monster-widget.zip\";}s:21:\"piglatin/piglatin.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:4:\"8842\";s:4:\"slug\";s:8:\"piglatin\";s:6:\"plugin\";s:21:\"piglatin/piglatin.php\";s:11:\"new_version\";s:3:\"0.2\";s:3:\"url\";s:39:\"https://wordpress.org/plugins/piglatin/\";s:7:\"package\";s:51:\"https://downloads.wordpress.org/plugin/piglatin.zip\";}s:33:\"posts-to-posts/posts-to-posts.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"14657\";s:4:\"slug\";s:14:\"posts-to-posts\";s:6:\"plugin\";s:33:\"posts-to-posts/posts-to-posts.php\";s:11:\"new_version\";s:5:\"1.6.5\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/posts-to-posts/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/posts-to-posts.1.6.5.zip\";}s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:4:\"4437\";s:4:\"slug\";s:21:\"regenerate-thumbnails\";s:6:\"plugin\";s:47:\"regenerate-thumbnails/regenerate-thumbnails.php\";s:11:\"new_version\";s:5:\"2.2.6\";s:3:\"url\";s:52:\"https://wordpress.org/plugins/regenerate-thumbnails/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/regenerate-thumbnails.zip\";}s:59:\"resize-images-before-upload/resize-images-before-upload.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"26463\";s:4:\"slug\";s:27:\"resize-images-before-upload\";s:6:\"plugin\";s:59:\"resize-images-before-upload/resize-images-before-upload.php\";s:11:\"new_version\";s:3:\"1.8\";s:3:\"url\";s:58:\"https://wordpress.org/plugins/resize-images-before-upload/\";s:7:\"package\";s:74:\"https://downloads.wordpress.org/plugin/resize-images-before-upload.1.8.zip\";}s:51:\"rewrite-rules-inspector/rewrite-rules-inspector.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"31263\";s:4:\"slug\";s:23:\"rewrite-rules-inspector\";s:6:\"plugin\";s:51:\"rewrite-rules-inspector/rewrite-rules-inspector.php\";s:11:\"new_version\";s:5:\"1.2.1\";s:3:\"url\";s:54:\"https://wordpress.org/plugins/rewrite-rules-inspector/\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/plugin/rewrite-rules-inspector.1.2.1.zip\";}s:17:\"stream/stream.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"46159\";s:4:\"slug\";s:6:\"stream\";s:6:\"plugin\";s:17:\"stream/stream.php\";s:11:\"new_version\";s:5:\"3.1.1\";s:3:\"url\";s:37:\"https://wordpress.org/plugins/stream/\";s:7:\"package\";s:55:\"https://downloads.wordpress.org/plugin/stream.3.1.1.zip\";}s:43:\"the-events-calendar/the-events-calendar.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"11861\";s:4:\"slug\";s:19:\"the-events-calendar\";s:6:\"plugin\";s:43:\"the-events-calendar/the-events-calendar.php\";s:11:\"new_version\";s:5:\"4.3.5\";s:3:\"url\";s:50:\"https://wordpress.org/plugins/the-events-calendar/\";s:7:\"package\";s:68:\"https://downloads.wordpress.org/plugin/the-events-calendar.4.3.5.zip\";}s:27:\"user-groups/user-groups.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"32737\";s:4:\"slug\";s:11:\"user-groups\";s:6:\"plugin\";s:27:\"user-groups/user-groups.php\";s:11:\"new_version\";s:5:\"1.3.1\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/user-groups/\";s:7:\"package\";s:54:\"https://downloads.wordpress.org/plugin/user-groups.zip\";}s:33:\"user-switching/user-switching.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:4:\"6923\";s:4:\"slug\";s:14:\"user-switching\";s:6:\"plugin\";s:33:\"user-switching/user-switching.php\";s:11:\"new_version\";s:5:\"1.0.9\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/user-switching/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/user-switching.1.0.9.zip\";}s:40:\"wordpress-beta-tester/wp-beta-tester.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:4:\"8693\";s:4:\"slug\";s:21:\"wordpress-beta-tester\";s:6:\"plugin\";s:40:\"wordpress-beta-tester/wp-beta-tester.php\";s:11:\"new_version\";s:5:\"1.0.2\";s:3:\"url\";s:52:\"https://wordpress.org/plugins/wordpress-beta-tester/\";s:7:\"package\";s:70:\"https://downloads.wordpress.org/plugin/wordpress-beta-tester.1.0.2.zip\";}s:19:\"rest-api/plugin.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:4:\"7769\";s:4:\"slug\";s:8:\"rest-api\";s:6:\"plugin\";s:19:\"rest-api/plugin.php\";s:11:\"new_version\";s:10:\"2.0-beta15\";s:3:\"url\";s:39:\"https://wordpress.org/plugins/rest-api/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/rest-api.2.0-beta15.zip\";}s:23:\"wp-routes/wp-routes.php\";O:8:\"stdClass\":6:{s:2:\"id\";s:5:\"22252\";s:4:\"slug\";s:9:\"wp-routes\";s:6:\"plugin\";s:23:\"wp-routes/wp-routes.php\";s:11:\"new_version\";s:3:\"0.4\";s:3:\"url\";s:40:\"https://wordpress.org/plugins/wp-routes/\";s:7:\"package\";s:52:\"https://downloads.wordpress.org/plugin/wp-routes.zip\";}}}','no'),(1279,'wp_stream_db','3.1.1','no'),(1281,'fresh_site','0','yes'),(1283,'_transient_is_multi_author','0','yes'),(1284,'_transient_twentysixteen_categories','1','yes'),(1287,'_site_transient_timeout_theme_roots','1482495489','no'),(1288,'_site_transient_theme_roots','a:17:{s:12:\"Parallax-One\";s:7:\"/themes\";s:12:\"Parallax-Two\";s:7:\"/themes\";s:12:\"childsixteen\";s:7:\"/themes\";s:4:\"lazy\";s:7:\"/themes\";s:7:\"oblique\";s:7:\"/themes\";s:21:\"rest-infra-demo-theme\";s:7:\"/themes\";s:21:\"rest-query-demo-theme\";s:7:\"/themes\";s:8:\"todo-mvc\";s:7:\"/themes\";s:12:\"twentyeleven\";s:7:\"/themes\";s:13:\"twentyfifteen\";s:7:\"/themes\";s:14:\"twentyfourteen\";s:7:\"/themes\";s:15:\"twentyseventeen\";s:7:\"/themes\";s:13:\"twentysixteen\";s:7:\"/themes\";s:9:\"twentyten\";s:7:\"/themes\";s:14:\"twentythirteen\";s:7:\"/themes\";s:12:\"twentytwelve\";s:7:\"/themes\";s:9:\"ultimatum\";s:7:\"/themes\";}','no');
/*!40000 ALTER TABLE `wp_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_postmeta`
--

LOCK TABLES `wp_postmeta` WRITE;
/*!40000 ALTER TABLE `wp_postmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_postmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_posts`
--

LOCK TABLES `wp_posts` WRITE;
/*!40000 ALTER TABLE `wp_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_stream`
--

DROP TABLE IF EXISTS `wp_stream`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_stream` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint(20) unsigned NOT NULL DEFAULT '1',
  `blog_id` bigint(20) unsigned NOT NULL DEFAULT '1',
  `object_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_role` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `summary` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `connector` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `context` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `ip` varchar(39) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `site_id` (`site_id`),
  KEY `blog_id` (`blog_id`),
  KEY `object_id` (`object_id`),
  KEY `user_id` (`user_id`),
  KEY `created` (`created`),
  KEY `connector` (`connector`),
  KEY `context` (`context`),
  KEY `action` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_stream`
--

LOCK TABLES `wp_stream` WRITE;
/*!40000 ALTER TABLE `wp_stream` DISABLE KEYS */;
INSERT INTO `wp_stream` VALUES (1,1,1,2,1,'administrator','\"Post 001 - updated title\" scheduled post published','2016-12-22 11:43:39','posts','post','updated','127.0.0.1'),(2,1,1,NULL,1,'administrator','\"Stream\" plugin deactivated ','2016-12-22 12:12:21','installer','plugins','deactivated','127.0.0.1'),(3,1,1,NULL,1,'administrator','\"Stream\" plugin deactivated ','2016-12-22 14:20:48','installer','plugins','deactivated','127.0.0.1'),(4,1,1,NULL,1,'administrator','\"Stream\" plugin deactivated ','2016-12-22 14:33:27','installer','plugins','deactivated','127.0.0.1');
/*!40000 ALTER TABLE `wp_stream` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_stream_meta`
--

DROP TABLE IF EXISTS `wp_stream_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_stream_meta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `record_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `meta_value` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `record_id` (`record_id`),
  KEY `meta_key` (`meta_key`),
  KEY `meta_value` (`meta_value`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_stream_meta`
--

LOCK TABLES `wp_stream_meta` WRITE;
/*!40000 ALTER TABLE `wp_stream_meta` DISABLE KEYS */;
INSERT INTO `wp_stream_meta` VALUES (1,1,'post_title','Post 001 - updated title'),(2,1,'singular_name','post'),(3,1,'post_date','2016-12-18 23:08:07'),(4,1,'post_date_gmt','2016-12-18 23:08:07'),(5,1,'new_status','publish'),(6,1,'old_status','future'),(7,1,'revision_id','3'),(8,1,'user_meta','s:169:\"a:5:{s:10:\"user_email\";s:12:\"admin@wp.dev\";s:12:\"display_name\";s:5:\"admin\";s:10:\"user_login\";s:5:\"admin\";s:15:\"user_role_label\";s:13:\"Administrator\";s:5:\"agent\";s:0:\"\";}\";'),(9,2,'name','Stream'),(10,2,'user_meta','s:169:\"a:5:{s:10:\"user_email\";s:12:\"admin@wp.dev\";s:12:\"display_name\";s:5:\"admin\";s:10:\"user_login\";s:5:\"admin\";s:15:\"user_role_label\";s:13:\"Administrator\";s:5:\"agent\";s:0:\"\";}\";'),(11,3,'name','Stream'),(12,3,'user_meta','s:169:\"a:5:{s:10:\"user_email\";s:12:\"admin@wp.dev\";s:12:\"display_name\";s:5:\"admin\";s:10:\"user_login\";s:5:\"admin\";s:15:\"user_role_label\";s:13:\"Administrator\";s:5:\"agent\";s:0:\"\";}\";'),(13,4,'name','Stream'),(14,4,'user_meta','s:169:\"a:5:{s:10:\"user_email\";s:12:\"admin@wp.dev\";s:12:\"display_name\";s:5:\"admin\";s:10:\"user_login\";s:5:\"admin\";s:15:\"user_role_label\";s:13:\"Administrator\";s:5:\"agent\";s:0:\"\";}\";');
/*!40000 ALTER TABLE `wp_stream_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_relationships`
--

LOCK TABLES `wp_term_relationships` WRITE;
/*!40000 ALTER TABLE `wp_term_relationships` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_taxonomy`
--

LOCK TABLES `wp_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `wp_term_taxonomy` DISABLE KEYS */;
INSERT INTO `wp_term_taxonomy` VALUES (1,1,'category','',0,1);
/*!40000 ALTER TABLE `wp_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_termmeta`
--

DROP TABLE IF EXISTS `wp_termmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_termmeta`
--

LOCK TABLES `wp_termmeta` WRITE;
/*!40000 ALTER TABLE `wp_termmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_termmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_terms`
--

LOCK TABLES `wp_terms` WRITE;
/*!40000 ALTER TABLE `wp_terms` DISABLE KEYS */;
INSERT INTO `wp_terms` VALUES (1,'Uncategorized','uncategorized',0);
/*!40000 ALTER TABLE `wp_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_usermeta`
--

LOCK TABLES `wp_usermeta` WRITE;
/*!40000 ALTER TABLE `wp_usermeta` DISABLE KEYS */;
INSERT INTO `wp_usermeta` VALUES (1,1,'nickname','admin'),(2,1,'first_name',''),(3,1,'last_name',''),(4,1,'description',''),(5,1,'rich_editing','true'),(6,1,'comment_shortcuts','false'),(7,1,'admin_color','fresh'),(8,1,'use_ssl','0'),(9,1,'show_admin_bar_front','true'),(10,1,'wp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(11,1,'wp_user_level','10'),(12,1,'dismissed_wp_pointers',''),(13,1,'show_welcome_panel','1'),(14,1,'session_tokens','a:1:{s:64:\"0b201cc1fb7ab680a46c2b6bb9316a39ca9343506eb9c9afc11b365825d4cd11\";a:4:{s:10:\"expiration\";i:1482497738;s:2:\"ip\";s:9:\"127.0.0.1\";s:2:\"ua\";s:120:\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.98 Safari/537.36\";s:5:\"login\";i:1482324938;}}'),(15,1,'wp_user-settings','editor=tinymce&libraryContent=browse&posts_list_mode=list'),(16,1,'wp_user-settings-time','1481100886'),(17,1,'wp_dashboard_quick_press_last_post_id','1'),(18,1,'managetoplevel_page_wp_streamcolumnshidden','a:1:{i:0;s:2:\"id\";}');
/*!40000 ALTER TABLE `wp_usermeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_users`
--

LOCK TABLES `wp_users` WRITE;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;
INSERT INTO `wp_users` VALUES (1,'admin','$P$BsitzAQsUhduAZg/4dNvteKarbN00h.','admin','admin@wp.dev','','2016-12-07 08:54:40','',0,'admin');
/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-23 12:48:34
