-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2019-03-10 20:54:27
-- 服务器版本： 5.6.17
-- PHP Version: 5.6.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `o2o`
--

-- --------------------------------------------------------

--
-- 表的结构 `ad`
--

CREATE TABLE IF NOT EXISTS `ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bis_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `bis_id` (`bis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `ad`
--

INSERT INTO `ad` (`id`, `bis_id`, `type`, `title`, `image`, `url`, `status`, `create_time`, `update_time`) VALUES
(9, 19, 0, '千千品牌，值得信赖', '/upload/20170525/0da3724a1b02882a0a8193cab0fbf0bd.jpg', 'http://o2o.com:8888/index/detail/index.html?id=8', 1, 1495644644, 1495645252),
(10, 19, 0, ' 安踏球鞋', '/upload/20170525/adfa708a401885640654be5a551e8fb1.jpg', 'http://www.anta.com', 1, 1495645156, 1495645248),
(11, 19, 0, 'FASHION', '/upload/20170525/b186f38a023a8218864fa84b314353d5.jpg', 'http://www.hao123.com', 1, 1495645186, 1495645244),
(12, 19, 0, '自助餐自助餐', '/upload/20170525/cc1290a4604dbc545d235a4376dac739.jpg', 'http://www.hao123.com', 1, 1495645232, 1495645239),
(14, 19, 1, '美味源', '/upload/20170525/d1d4ec071d2a6d1b3477270f8be063eb.png', 'http://www.hao123.com', 1, 1495646975, 1496211432),
(16, 19, 1, '金龙鱼花生油', '/upload/20170525/a7821f7b0aa04228fcb6fbb3bc57fa27.png', 'http://www.hao123.com', 1, 1495689167, 1495689184),
(17, 19, 1, '美味真传-香香美食', '/upload/20170525/e838a6c50f6cf52bc7e97b6319cd674a.png', 'http://o2o.com:8888/index/detail/index.html?id=4', 1, 1495689319, 1496196435),
(18, 19, 2, '测试1', '/upload/20170602/557f65f2a5c4fcb08fa5c64a33c07847.png', 'http://www.hao123.com', 1, 1496400686, 1496400698),
(19, 19, 2, '测试3', '/upload/20170602/d330b3db6aa9dbff983d92b65933ad9e.png', 'http://www.hao123.com', 1, 1496400721, 1496407033),
(20, 19, 2, '测试2', '/upload/20170602/d0bd618c0511d2e6a825cf32fce5ded9.png', 'http://o2o.com:8888/index/detail/index.html?id=9', 1, 1496402597, 1496402611),
(21, 19, 2, '测试4', '/upload/20170602/49fc7d0a1f30dab15b17446ee87cb25e.png', 'http://o2o.com:8888/index/detail/index.html?id=9', 1, 1496403185, 1496403212),
(24, 19, 2, '测试6', '/upload/20170602/a48db1ffd1146ea1b4570d7d6d6866b7.png', 'http://www.hao123.com', 1, 1496407217, 1496407726),
(26, 19, 2, '测试8', '/upload/20170602/0b7081bde8255b213c7f0661954bed97.png', 'http://www.hao123.com', 1, 1496407243, 1496407318),
(27, 19, 2, '测试9', '/upload/20170602/0f268e29be10133973541c065a0cab9a.png', 'http://www.hao123.com', 1, 1496407258, 1496407314),
(28, 19, 2, '测试10', '/upload/20170602/9d210cddce8fefc80e6a0331b0f468cc.png', 'http://www.hao123.com', 1, 1496407269, 1496407309),
(29, 19, 2, '测试11', '/upload/20170602/1054c73bb50623adf32be0f909cb7ec0.png', 'http://www.hao123.com', 1, 1496407281, 1496407303),
(30, 19, 2, '测试12', '/upload/20170602/e5d496bfc6bd98f8c7f511ccef405705.png', 'http://www.hao123.com', 1, 1496407294, 1496407299),
(31, 0, 1, '1', '', '', 1, 1552209305, 1552209311);

-- --------------------------------------------------------

--
-- 表的结构 `bis`
--

CREATE TABLE IF NOT EXISTS `bis` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bis_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `licence_logo` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `city_id` int(11) unsigned NOT NULL DEFAULT '0',
  `child_city_id` varchar(50) DEFAULT NULL,
  `contractor` varchar(20) NOT NULL DEFAULT '',
  `tel` varchar(20) NOT NULL DEFAULT '',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `child_category_id` varchar(50) DEFAULT NULL,
  `address` varchar(255) NOT NULL DEFAULT '',
  `xpoint` varchar(20) NOT NULL DEFAULT '',
  `ypoint` varchar(20) NOT NULL DEFAULT '',
  `open_time` varchar(14) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `category_id` (`category_id`),
  KEY `name` (`name`),
  KEY `bis_id` (`bis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `bis`
--

INSERT INTO `bis` (`id`, `bis_id`, `name`, `email`, `logo`, `licence_logo`, `description`, `city_id`, `child_city_id`, `contractor`, `tel`, `category_id`, `child_category_id`, `address`, `xpoint`, `ypoint`, `open_time`, `status`, `create_time`, `update_time`) VALUES
(19, 19, '香香美食', '343382140@qq.com', '/upload/20170519/613e98312cdc735deeea084bb67f698f.png', '/upload/20170519/7d59afe1192d18031f28969f1ec08e63.png', '天下美食，尽在香香！香香美食坐落于美丽的广州，历史悠久，是一间不可多得的当地文化鲜明的综合型美食店。主要的美食有：早餐、自助餐、快餐、宵夜等等。环境优美，服务态度友好，物美价廉等都是我们的口号！欢迎来品尝！', 31, '39', '周财', '18135835689', 34, '35', '山西吕梁学院', '111.1534738022', '37.5859795923', '8:00-24:00', 1, 1495160839, 1496165075),
(24, 19, '小白旅游', '343382140@qq.com', '/upload/20170528/e53e7da54c241bcddcd157adf8e6feaa.jpg', '/upload/20170528/9e341e31741a39a782948737d171e390.jpg', '小白旅游，带你游上海。', 35, '45', '周财', '18135835689', 31, '28', '上海迪士尼乐园', '121.67443916', '31.1514740471', '8:00-24:00', 1, 1495910005, 1495910012),
(25, 19, '千千美容', '343382140@qq.com', '/upload/20170531/170ab04d34b86ba37392be99f4e3ed57.jpg', '/upload/20170531/2d8cf3077ca3914deeb7ca20c869579a.jpg', '千千美容，位于上海陆家嘴，是一间很好的美容美发品牌店。来千千美容，让你做最自信的自己。', 35, '45', '周财', '18135835689', 29, '75', '上海东方明珠电视塔', '121.507089088', '31.2444219412', '00：00-24：00', 1, 1496162561, 1496165843),
(26, 19, '万达影院', '343382140@qq.com', '/upload/20170531/94e80b7810df024ce0bb996e21dca10e.png', '/upload/20170531/aa7ebe6098a40beca0b7854bccc12dca.png', '万达电影院线成立于2005年，隶属于万达集团。截至2014年6月30日，在全国80多个城市拥有已开业影院150家，1,315块银幕，其中IMAX银幕94块。2014年万达院线占全国14.5%的票房份额。', 35, '47', '周财', '18135835689', 59, '63', '上海虹桥万达影城', '121.326983325', '31.2459410706', '8:00-24:00', 1, 1496166371, 1496166394),
(27, 19, '浦东机场美食店', '343382140@qq.com', '/upload/20170531/f05967a3292d5251944521316adf07d9.png', '/upload/20170531/1d1b1e6d59889197993c74cd7eb54fdd.png', '浦东机场美食店，值得信赖。', 35, '46', '周财', '18135835689', 34, '58', '上海浦东国际机场', '121.81529669', '31.1564538985', '00：00-24：00', 1, 1496166938, 1496899909),
(28, 19, '虹桥德克士炸鸡汉堡店', '343382140@qq.com', '/upload/20170531/787b898c648ecd264460de93fa981a8b.png', '/upload/20170531/d74a5ea2fa31702548469811c5b186dd.png', '虹桥德克士炸鸡汉堡店！美味不一般！', 35, '47', '周财', '18135835689', 34, '52', '上海虹桥火车站', '121.327070499', '31.200372064', '00：00-24：00', 1, 1496214069, 1496214137),
(29, 19, '静安公园-风味美食城', '343382140@qq.com', '/upload/20170531/3b63b1d4e40a5be9f9e54261b9affec6.png', '/upload/20170531/ae9c51e2ff191b7239775d7d5c71f5a8.png', '静安公园-风味美食城，自助餐、烧烤、快餐、豪华套餐等一应俱全！', 35, '63', '周财', '18135835689', 34, '35', '上海静安区静安公园', '121.453199828', '31.2282860976', '00：00-24：00', 1, 1496215509, 1496451672);

-- --------------------------------------------------------

--
-- 表的结构 `bis_account`
--

CREATE TABLE IF NOT EXISTS `bis_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `bis_id` int(11) unsigned NOT NULL DEFAULT '0',
  `money` decimal(20,2) NOT NULL DEFAULT '0.00',
  `output_money` decimal(20,2) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `bis_id` (`bis_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `bis_account`
--

INSERT INTO `bis_account` (`id`, `username`, `password`, `bis_id`, `money`, `output_money`, `card_number`, `status`, `create_time`, `update_time`) VALUES
(8, 'test', '202cb962ac59075b964b07152d234b70', 19, '11850.50', '0.00', '621700313001505904', 1, 1495160839, 1552221818);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` int(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `parent_id`, `listorder`, `status`, `create_time`, `update_time`) VALUES
(21, '电影', 31, 0, 1, 1494830594, 1494833193),
(22, '自传', 31, 0, 1, 1494830607, 1494830607),
(23, '动作', 31, 0, 1, 1494830618, 1494830618),
(24, '美食', 31, 0, 0, 1494830641, 1495041280),
(25, ' 正餐', 31, 0, 0, 1494830672, 1495041272),
(26, '饮料', 31, 0, 1, 1494830697, 1494831103),
(27, '甜点', 31, 0, 1, 1494830715, 1494830985),
(28, '游乐园', 31, 0, 1, 1494830729, 1495907581),
(29, '丽人', 0, 9, 1, 1494831201, 1495625195),
(30, '鲜花', 29, 0, 1, 1494831209, 1494831209),
(31, '休闲娱乐', 0, 0, 1, 1494831252, 1495907533),
(32, '零食', 0, 7, 1, 1494831328, 1495907852),
(33, '旅游', 0, 8, 1, 1494831371, 1495625240),
(34, '美食', 0, 9, 1, 1495160125, 1495625138),
(35, '正餐', 34, 0, 1, 1495160204, 1495160204),
(36, '甜品饮品', 34, 0, 1, 1495160231, 1495160231),
(37, '酒店', 0, 8, 1, 1495160254, 1495625175),
(38, '快餐', 34, 0, 1, 1495161177, 1495161177),
(39, '自助餐', 34, 0, 1, 1495161191, 1495161191),
(40, '辣鸡', 34, 1, 1, 1495373188, 1495373243),
(41, '特产', 0, 0, 1, 1495479205, 1495479923),
(44, '本地服务', 0, 1, 1, 1495479796, 1495625282),
(45, '男士', 0, 0, 1, 1495479834, 1495625295),
(46, '儿童', 0, 0, 1, 1495479839, 1495625050),
(50, '火锅', 34, 0, 1, 1495559500, 1495559500),
(51, '小吃', 34, 0, 1, 1495559505, 1495559696),
(52, '快餐', 34, 0, 1, 1495559510, 1495559688),
(53, '自助餐', 34, 0, 1, 1495559521, 1495559680),
(54, '海鲜', 34, 0, 1, 1495559525, 1495559670),
(55, '烧烤', 34, 0, 1, 1495559536, 1495559618),
(56, '甜品', 34, 0, 1, 1495559549, 1495559632),
(57, '蛋糕', 34, 0, 1, 1495559554, 1495559659),
(58, '咖啡', 34, 0, 1, 1495559559, 1495559641),
(59, '电影', 0, 8, 1, 1495625225, 1495625246),
(60, '休闲娱乐', 0, 2, -1, 1495625271, 1495908270),
(61, '美甲', 29, 0, 1, 1495625329, 1495625329),
(62, '美发', 29, 0, 1, 1495625339, 1495625339),
(63, '在线订座', 59, 0, 1, 1495625367, 1495625367),
(64, '配镜', 44, 0, 1, 1495625393, 1495625393),
(65, '照片冲印', 44, 0, 1, 1495625410, 1495625410),
(66, '湛江', 37, 0, 1, 1495625424, 1495625424),
(67, '上海', 37, 0, 1, 1495625435, 1495625435),
(68, '北京', 37, 0, 1, 1495625443, 1495625443),
(69, '水上乐园', 60, 0, 1, 1495625455, 1495625455),
(70, '游乐园', 60, 0, 1, 1495625464, 1495625464),
(71, '北京', 33, 0, 1, 1495625494, 1495625494),
(72, '深圳', 33, 0, 1, 1495625516, 1495625516),
(73, '上海', 33, 0, 1, 1495625525, 1495625525),
(74, '早期教育', 46, 0, 1, 1495625882, 1495625882),
(75, '美容', 29, 0, 1, 1496162263, 1496162263),
(76, '山东', 0, 0, -1, 1496390343, 1496390355);

-- --------------------------------------------------------

--
-- 表的结构 `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `listorder` int(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- 转存表中的数据 `city`
--

INSERT INTO `city` (`id`, `name`, `parent_id`, `is_default`, `listorder`, `status`, `create_time`, `update_time`) VALUES
(31, '湛江', 0, 0, 0, 1, 1494831462, 1495160317),
(32, '广州', 0, 0, 0, 1, 1494831467, 1494831467),
(33, '茂名', 0, 0, 0, 1, 1494831473, 1494831473),
(34, '北京', 0, 0, 0, 1, 1494831477, 1494831477),
(35, '上海', 0, 1, 0, 1, 1494831482, 1494831482),
(36, '深圳', 0, 0, 0, 1, 1494831487, 1494831487),
(37, '海南', 0, 0, 0, -1, 1494831511, 1552213328),
(38, '霞山', 31, 0, 0, 1, 1494831544, 1494831544),
(39, '麻章', 31, 0, 0, 1, 1494831550, 1494831550),
(40, '赤坎', 31, 0, 0, 1, 1494831557, 1494831557),
(41, '天河区', 32, 0, 0, 1, 1494831570, 1494831792),
(42, '白云区', 32, 0, 0, 1, 1494831582, 1494831799),
(43, '番禺区', 32, 0, 0, 1, 1494831594, 1494831806),
(44, '海珠区', 32, 0, 0, 1, 1494831603, 1494831812),
(45, '陆家嘴', 35, 0, 0, 1, 1494831622, 1494831622),
(46, '浦东', 35, 0, 0, 1, 1494831641, 1494831641),
(47, '虹桥', 35, 0, 0, 1, 1494831652, 1494831652),
(48, '朝阳区', 34, 0, 0, 1, 1494831683, 1494831773),
(49, '海淀区', 34, 0, 0, 1, 1494831758, 1494831758),
(50, '信宜', 33, 0, 0, 1, 1494831826, 1494831826),
(51, '高州', 33, 0, 0, 1, 1494831834, 1494831834),
(52, '化州', 33, 0, 0, 1, 1494831842, 1494831842),
(53, '茂南区', 33, 0, 0, 1, 1494831852, 1494831852),
(54, '沙井', 36, 0, 0, 1, 1494831861, 1494831861),
(55, '松岗', 36, 0, 0, 1, 1494831870, 1494831870),
(56, '平湖', 36, 0, 0, 1, 1494831884, 1494831884),
(57, '武汉', 0, 0, 0, 1, 1495160274, 1495160274),
(58, '重庆', 0, 0, 0, 1, 1495160288, 1495160288),
(59, '杭州', 0, 0, 0, 1, 1495481127, 1495481127),
(60, '苏州', 0, 0, 0, 1, 1495481135, 1495481135),
(61, '惠州', 0, 0, 0, 1, 1495481156, 1495481156),
(62, '韶关', 0, 0, 0, 1, 1495481162, 1495481162),
(63, '静安区', 35, 0, 0, 1, 1496215309, 1496215309);

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coupons_number` varchar(100) NOT NULL DEFAULT '',
  `coupons_pass` varchar(20) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `bis_id` int(11) NOT NULL DEFAULT '0',
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_number` (`coupons_number`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=197 ;

--
-- 转存表中的数据 `coupons`
--

INSERT INTO `coupons` (`id`, `coupons_number`, `coupons_pass`, `user_id`, `goods_id`, `order_id`, `bis_id`, `shop_id`, `status`, `create_time`, `update_time`) VALUES
(177, '8F4syKC9FW', '09625', 2, 7, 119, 19, 24, 1, 1496130153, 1496141525),
(179, 'WRe3NSIIfc', '53692', 2, 7, 119, 19, 24, 1, 1496130153, 1496142072),
(180, 'bQYnefZjuk', '43734', 2, 10, 120, 19, 27, 0, 1496196313, 1496196313),
(181, '7WXAP2ksNf', '56229', 2, 10, 120, 19, 27, 0, 1496196313, 1496196313),
(182, 'E7gdExm9Dt', '60981', 2, 10, 120, 19, 27, 0, 1496196313, 1496196313),
(183, 'oIefZoMdUk', '50088', 2, 8, 122, 19, 25, 0, 1496390229, 1496390229),
(184, '33YVpF8GHi', '96224', 2, 15, 123, 19, 29, 0, 1496430297, 1496430297),
(185, '2EEKGSRynk', '83100', 2, 15, 123, 19, 29, 0, 1496430297, 1496430297),
(186, 'MTV8QesaxM', '60103', 2, 11, 125, 19, 27, 0, 1496431298, 1496431298),
(187, 'AytYSJpoTJ', '84902', 2, 11, 125, 19, 27, 0, 1496431298, 1496431298),
(188, 'QApm2IBysf', '60561', 2, 15, 126, 19, 29, 0, 1496431462, 1496431462),
(189, 'FfTroptg4b', '70763', 2, 16, 127, 0, 24, 0, 1496455058, 1496455058),
(190, 'YJxJ7YAxaY', '44417', 2, 16, 127, 0, 24, 0, 1496455063, 1496455063),
(191, 'bqfHVbm9nS', '18145', 2, 15, 129, 19, 29, 0, 1552218984, 1552218984),
(192, 'uI2csPxBTv', '05856', 2, 15, 130, 19, 29, 0, 1552219189, 1552219189),
(193, 'ie4M4BpHZD', '40493', 2, 13, 131, 19, 28, 0, 1552219629, 1552219629),
(194, 'PIJ8p6EamW', '21324', 2, 15, 132, 19, 29, 0, 1552220074, 1552220074),
(195, 'dmIxMGyCni', '26879', 2, 15, 132, 19, 29, 0, 1552220074, 1552220074),
(196, 'xQYACR4JZQ', '10597', 2, 11, 133, 19, 27, 0, 1552221778, 1552221778);

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `child_category_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `child_city_id` int(11) NOT NULL,
  `shop` int(11) NOT NULL DEFAULT '0',
  `bis_id` int(11) NOT NULL DEFAULT '0',
  `image` varchar(200) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `origin_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `current_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `buy_count` int(11) NOT NULL DEFAULT '0',
  `total_count` int(11) NOT NULL DEFAULT '0',
  `coupons_begin_time` int(11) NOT NULL DEFAULT '0',
  `coupons_end_time` int(11) NOT NULL DEFAULT '0',
  `bis_account_id` int(10) NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `se_category_id` (`shop`),
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`id`, `name`, `category_id`, `child_category_id`, `city_id`, `child_city_id`, `shop`, `bis_id`, `image`, `description`, `start_time`, `end_time`, `origin_price`, `current_price`, `buy_count`, `total_count`, `coupons_begin_time`, `coupons_end_time`, `bis_account_id`, `notes`, `status`, `create_time`, `update_time`) VALUES
(4, '海大香香美食自助餐入场券', 34, 21, 31, 39, 19, 19, '/upload/20170519/030fa50ae5971f0b52ff55b438770cb1.png', '香香自助餐，不饱不归！', 1493778840, 1498876440, '100.00', '88.00', 10, 99, 1493778900, 1499222100, 4, '凭券消费！', 1, 1495161353, 1496430245),
(7, ' 迪士尼乐园门票', 31, 21, 35, 45, 24, 19, '/upload/20170531/cad0102c075656a46e0bcc5f51dfb0db.png', '迪士尼乐园等你噢！', 1494354900, 1499279700, '200.00', '180.00', 0, 43, 1493750100, 1501266900, 7, '凭消费券兑换门票', 1, 1495910165, 1496216275),
(8, '千千美容年票', 29, 75, 35, 45, 25, 19, '/upload/20170531/e39f24ca82537a8d7df2ae2593304fb6.jpg', '千千美容，你值得拥有。', 1493657040, 1496947080, '2000.00', '1888.00', 0, 999, 1493743440, 1496940240, 8, '凭券兑换服务，谢谢支持！', 1, 1496162768, 1496165843),
(9, '大话西游3D电影票', 59, 63, 35, 47, 26, 19, '/upload/20170531/4722a8f890b67151f9f0d081076441c5.png', '大话西游》是由周星驰彩星电影公司和西安电影制片厂联合摄制的爱情悲喜剧电影，由刘镇伟执导，周星驰、朱茵、吴孟达和莫文蔚等人主演。', 1494265680, 1496944080, '58.00', '47.00', 0, 999, 1494265740, 1499276940, 8, '凭券兑票噢。', 1, 1496166583, 1496166602),
(10, '浦东机场美食店-精品午餐', 34, 21, 35, 46, 27, 19, '/upload/20170531/fd7eb0e33d774f3e7b2f5b7e9c06232a.png', '肯德基（KentuckyFried Chicken，肯塔基州炸鸡），简称KFC，是美国跨国连锁餐厅之一，也是世界第二大速食及最大炸鸡连锁企业，由哈兰·山德士于1930年在肯塔基州路易斯维尔创建，主要出售炸鸡、汉堡、薯条、蛋挞、汽水等高热量快餐食品。然而不够营养，营养超值请用本店超值套餐。', 1493575020, 1498672620, '168.00', '128.00', 0, 999, 1493575020, 1499104680, 10, '凭消费券兑换服务噢！', 1, 1496167254, 1496899909),
(11, '港式甜品-100元消费券', 34, 56, 35, 46, 27, 19, '/upload/20170531/26475b3a13e812439d728446a3bb7e11.png', '100块甜品消费券只需要95元！还等什么！', 1493576340, 1496945940, '100.00', '95.00', 1, 999, 1493576340, 1497032340, 8, '凭券消费噢', 1, 1496168437, 1552221098),
(12, '木容尚品自助餐', 34, 53, 35, 46, 27, 19, '/upload/20170531/e8948b121cdac09abb1b030b0c632514.png', '浦东机场美食-木容尚品自助餐，不饱不上机！', 1493620320, 1496212320, '78.00', '67.00', 0, 666, 1493620380, 1499409180, 8, '凭消费券兑换服务噢！', 1, 1496212437, 1496899909),
(13, '德克士炸鸡汉堡店200元消费券', 34, 21, 35, 47, 28, 19, '/upload/20170531/25b05b52162eb2beaf709b1d6950d30f.png', '德克士炸鸡汉堡店200元消费券，现在只要188！赶紧团起来！', 1493579160, 1496947080, '200.00', '188.00', 0, 899, 1493579160, 1497035220, 13, '凭消费券兑换相关服务噢！', 1, 1496214465, 1496429146),
(14, '静安风味美食城-烧烤餐厅消费券150元', 34, 21, 35, 63, 29, 19, '/upload/20170531/e4a94881b8891e36157d7a209637febc.png', '静安风味美食城-烧烤餐厅消费券150元，现在不买待何时！？', 1493666820, 1495222080, '150.00', '138.00', 0, 1000, 1493666880, 1496172480, 14, '凭消费券兑换服务噢', 1, 1496215768, 1496451672),
(15, '风味美食城-咖啡厅150元消费券', 34, 21, 35, 63, 29, 19, '/upload/20170603/2ee838eaaa9b7dd7fe19134ba6e62f27.png', '风味美食城-咖啡厅150元消费券，现价只需137！', 1496256840, 1497552840, '150.00', '137.00', 19, 996, 1496429640, 1497466440, 15, '凭券兑换服务噢！', 1, 1496429717, 1552220069),
(16, '上海一日游', 31, 28, 35, 45, 24, 0, '/upload/20170603/63f5158f67e470699ad3d691db798779.png', '小白旅游-上海一日游，带你认识上海', 1493751360, 1498157760, '500.00', '399.00', 0, 999, 1493751360, 1501268160, 8, '凭消费券兑换服务！', -1, 1496429848, 1496601555);

-- --------------------------------------------------------

--
-- 表的结构 `m_admin`
--

CREATE TABLE IF NOT EXISTS `m_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(16) NOT NULL,
  `user_id` varchar(16) NOT NULL,
  `shop` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '0',
  `buy_count` int(11) NOT NULL DEFAULT '0',
  `price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(20,2) unsigned NOT NULL DEFAULT '0.00',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:待支付，1：支付完成，2：订单完成',
  `bis_id` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=134 ;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `user_id`, `shop`, `goods_id`, `buy_count`, `price`, `total_price`, `create_time`, `update_time`, `status`, `bis_id`) VALUES
(119, 'xq8167486119', '2', 24, 7, 3, '0.50', '1.50', 1496130138, 1496130153, 1, 19),
(120, 'xq8167486120', '2', 27, 10, 3, '128.00', '384.00', 1496196302, 1496196313, 1, 19),
(121, 'xq8167486121', '2', 27, 10, 2, '128.00', '256.00', 1496199790, 1496199790, 0, 19),
(122, 'xq8167486122', '2', 25, 8, 1, '1888.00', '1888.00', 1496390222, 1496390229, 1, 19),
(123, 'xq8167486123', '2', 29, 15, 2, '137.00', '274.00', 1496430289, 1496430297, 1, 19),
(124, 'xq8167486124', '2', 27, 11, 1, '95.00', '95.00', 1496430479, 1496430479, 0, 19),
(125, 'xq8167486125', '2', 27, 11, 2, '95.00', '190.00', 1496431160, 1496431298, 1, 19),
(126, 'xq8167486126', '2', 29, 15, 1, '137.00', '137.00', 1496431459, 1552218520, -1, 19),
(127, 'xq8167486127', '2', 24, 16, 1, '399.00', '399.00', 1496455054, 1496455063, 1, 0),
(128, 'xq8167486128', '2', 29, 15, 2, '137.00', '274.00', 1552218826, 1552218832, 1, 19),
(129, 'xq8167486129', '2', 29, 15, 1, '137.00', '137.00', 1552218973, 1552218984, 1, 19),
(130, 'xq8167486130', '2', 29, 15, 1, '137.00', '137.00', 1552219184, 1552219189, 1, 19),
(131, 'xq8167486131', '2', 28, 13, 1, '188.00', '188.00', 1552219614, 1552219629, 1, 19),
(132, 'xq8167486132', '2', 29, 15, 2, '137.00', '274.00', 1552220069, 1552220074, 1, 19),
(133, 'xq8167486133', '2', 27, 11, 1, '95.00', '95.00', 1552221098, 1552221778, 1, 19);

-- --------------------------------------------------------

--
-- 表的结构 `output`
--

CREATE TABLE IF NOT EXISTS `output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bis_id` int(11) NOT NULL,
  `output_money` decimal(20,2) NOT NULL,
  `shiji_output_money` decimal(20,2) NOT NULL,
  `status` int(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `output`
--

INSERT INTO `output` (`id`, `bis_id`, `output_money`, `shiji_output_money`, `status`, `create_time`, `update_time`) VALUES
(4, 19, '205.00', '202.95', 1, 1496046519, 1496052876);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `email` varchar(30) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `status`, `create_time`, `update_time`) VALUES
(2, '123456', 'e10adc3949ba59abbe56e057f20f883e', '343382140@qq.com', 1, 1495423860, 1552221091);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
