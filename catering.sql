-- phpMyAdmin SQL Dump
-- version 4.3.13
-- http://www.phpmyadmin.net
--
-- Host: tdpogawennoq.rds.sae.sina.com.cn:10111
-- Generation Time: 2016-05-27 18:13:36
-- 服务器版本： 5.6.23-72.1-log
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `catering`
--

-- --------------------------------------------------------

--
-- 表的结构 `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `a_id` decimal(6,0) NOT NULL,
  `a_startdate` date NOT NULL,
  `a_enddate` date NOT NULL,
  `a_classfication` char(36) NOT NULL DEFAULT '',
  `a_state` char(10) NOT NULL,
  `a_description` text,
  `a_exist` decimal(1,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `activity`
--

INSERT INTO `activity` (`a_id`, `a_startdate`, `a_enddate`, `a_classfication`, `a_state`, `a_description`, `a_exist`) VALUES
('100001', '2016-05-05', '2016-08-08', '打折', '进行中', '', '1'),
('100002', '2016-05-05', '2016-08-08', '促销', '已结束', '', '0'),
('100003', '2016-05-05', '2016-08-08', '促销', '已结束', '', '1');

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `p_id` decimal(6,0) NOT NULL,
  `p_username` char(20) NOT NULL,
  `p_password` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`p_id`, `p_username`, `p_password`) VALUES
('100001', 'may', '123456'),
('100002', 'lily', '123456');

-- --------------------------------------------------------

--
-- 表的结构 `classfication`
--

CREATE TABLE IF NOT EXISTS `classfication` (
  `c_id` decimal(2,0) NOT NULL,
  `c_name` char(10) NOT NULL,
  `c_exist` decimal(1,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `classfication`
--

INSERT INTO `classfication` (`c_id`, `c_name`, `c_exist`) VALUES
('1', '凉菜', '1'),
('2', '热菜', '1'),
('3', '汤类', '1'),
('4', '主食', '1'),
('5', '酒类', '1'),
('6', '饮料', '1'),
('7', '烧烤', '1'),
('8', '小炒', '1'),
('9', '炖菜', '1'),
('10', '茶类', '1'),
('11', '酒水', '1');

-- --------------------------------------------------------

--
-- 表的结构 `desk`
--

CREATE TABLE IF NOT EXISTS `desk` (
  `b_id` decimal(2,0) NOT NULL,
  `b_deposit` float NOT NULL,
  `b_block` text NOT NULL,
  `b_seats` int(11) NOT NULL,
  `b_monbreakfast` decimal(1,0) NOT NULL DEFAULT '0',
  `b_monlunch` decimal(1,0) NOT NULL DEFAULT '0',
  `b_monsupper` decimal(1,0) NOT NULL DEFAULT '0',
  `b_tuebreakfast` decimal(1,0) NOT NULL DEFAULT '0',
  `b_tuelunch` decimal(1,0) NOT NULL DEFAULT '0',
  `b_tuesupper` decimal(1,0) NOT NULL DEFAULT '0',
  `b_wedbreakfast` decimal(1,0) NOT NULL DEFAULT '0',
  `b_wedlunch` decimal(1,0) NOT NULL DEFAULT '0',
  `b_wedsupper` decimal(1,0) NOT NULL DEFAULT '0',
  `b_thubreakfast` decimal(1,0) NOT NULL DEFAULT '0',
  `b_thulunch` decimal(1,0) NOT NULL DEFAULT '0',
  `b_thusupper` decimal(1,0) NOT NULL DEFAULT '0',
  `b_fribreakfast` decimal(1,0) NOT NULL DEFAULT '0',
  `b_frilunch` decimal(1,0) NOT NULL DEFAULT '0',
  `b_frisupper` decimal(1,0) NOT NULL DEFAULT '0',
  `b_satbreakfast` decimal(1,0) NOT NULL DEFAULT '0',
  `b_satlunch` decimal(1,0) NOT NULL DEFAULT '0',
  `b_satsupper` decimal(1,0) NOT NULL DEFAULT '0',
  `b_sunbreakfast` decimal(1,0) NOT NULL DEFAULT '0',
  `b_sunlunch` decimal(1,0) NOT NULL DEFAULT '0',
  `b_sunsupper` decimal(1,0) NOT NULL DEFAULT '0',
  `b_exist` decimal(1,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `desk`
--

INSERT INTO `desk` (`b_id`, `b_deposit`, `b_block`, `b_seats`, `b_monbreakfast`, `b_monlunch`, `b_monsupper`, `b_tuebreakfast`, `b_tuelunch`, `b_tuesupper`, `b_wedbreakfast`, `b_wedlunch`, `b_wedsupper`, `b_thubreakfast`, `b_thulunch`, `b_thusupper`, `b_fribreakfast`, `b_frilunch`, `b_frisupper`, `b_satbreakfast`, `b_satlunch`, `b_satsupper`, `b_sunbreakfast`, `b_sunlunch`, `b_sunsupper`, `b_exist`) VALUES
('1', 5, 'A区', 5, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1'),
('2', 10, 'B区', 5, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1'),
('3', 6, 'C区', 6, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1'),
('4', 6, 'D区', 5, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1'),
('5', 5, 'E区', 5, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- 表的结构 `dishes`
--

CREATE TABLE IF NOT EXISTS `dishes` (
  `d_id` decimal(6,0) NOT NULL,
  `c_id` decimal(2,0) NOT NULL,
  `d_name` char(32) NOT NULL,
  `d_price` float NOT NULL,
  `d_disprice` float DEFAULT NULL,
  `d_account` int(11) NOT NULL,
  `d_description` text,
  `d_pic` text,
  `d_extra` text,
  `d_exist` decimal(1,0) NOT NULL,
  `d_new` decimal(1,0) NOT NULL,
  `d_hot` decimal(1,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dishes`
--

INSERT INTO `dishes` (`d_id`, `c_id`, `d_name`, `d_price`, `d_disprice`, `d_account`, `d_description`, `d_pic`, `d_extra`, `d_exist`, `d_new`, `d_hot`) VALUES
('100002', '1', '辣子鸡', 23, 20, 20, '好吃', '6fbcbe0592bf4dd7bd7ed8d6c9f902eb.jpg', '好吃', '0', '0', '0'),
('100003', '1', '辣子鸡', 23, 20, 20, '好吃', '6fbcbe0592bf4dd7bd7ed8d6c9f902eb.jpg', '好吃', '1', '0', '0'),
('100004', '1', '肉沫粉条', 23, 20, 20, '好吃', '2454d0cc0270d64ad38528442c411c3b.jpg', '好吃', '1', '1', '1'),
('100005', '1', '辣子鸡', 23, 20, 20, '好吃', 'afbbf16e5613a451da32fffc3804411b.jpg', '好吃', '1', '1', '0'),
('100006', '1', '辣子鸡', 23, 20, 25, '好吃', 'e5f83ab7e1f579cadc1d04da0e83760e.jpg', '好吃', '1', '0', '0'),
('100008', '1', '周黑鸭', 52, 45, 20, '好好吃', 'b9e1e6b4d63b9061861964e21d120daf.jpg', '好吃', '1', '0', '1');

-- --------------------------------------------------------

--
-- 表的结构 `judgement`
--

CREATE TABLE IF NOT EXISTS `judgement` (
  `j_openid` char(50) NOT NULL DEFAULT '',
  `j_nickname` char(30) NOT NULL DEFAULT '',
  `j_headimgurl` char(250) NOT NULL DEFAULT '',
  `j_subtime` int(11) NOT NULL DEFAULT '0',
  `j_judgement` text NOT NULL,
  `j_id` decimal(16,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `judgement`
--

INSERT INTO `judgement` (`j_openid`, `j_nickname`, `j_headimgurl`, `j_subtime`, `j_judgement`, `j_id`) VALUES
('otemYwJzZjl0xDoMYpNGwiVczgfw', '麦', 'http://wx.qlogo.cn/mmopen/eWdpuJEziaMVI4ugAhXZv5E9noicsWOvu5LWVicld86tTNNlicpJ8UfBsTxSPOdpxUgHgK35ArydcTuD9icib6qnygN0MYV9G9WjF1/0', 1461814183, '好吃', '2016042812320721'),
('otemYwJzZjl0xDoMYpNGwiVczgfw', '麦', 'http://wx.qlogo.cn/mmopen/eWdpuJEziaMVI4ugAhXZv5E9noicsWOvu5LWVicld86tTNNlicpJ8UfBsTxSPOdpxUgHgK35ArydcTuD9icib6qnygN0MYV9G9WjF1/0', 1461814183, '好好吃', '2016042812324957'),
('otemYwJzZjl0xDoMYpNGwiVczgfw', '麦', 'http://wx.qlogo.cn/mmopen/eWdpuJEziaMVI4ugAhXZv5E9noicsWOvu5LWVicld86tTNNlicpJ8UfBsTxSPOdpxUgHgK35ArydcTuD9icib6qnygN0MYV9G9WjF1/0', 1461814183, '真好啊', '2016042812333528'),
('otemYwJzZjl0xDoMYpNGwiVczgfw', '麦', 'http://wx.qlogo.cn/mmopen/eWdpuJEziaMVI4ugAhXZv5E9noicsWOvu5LWVicld86tTNNlicpJ8UfBsTxSPOdpxUgHgK35ArydcTuD9icib6qnygN0MYV9G9WjF1/0', 1461818279, '味道挺好的', '2016042812375971'),
('otemYwJzZjl0xDoMYpNGwiVczgfw', '麦', 'http://wx.qlogo.cn/mmopen/eWdpuJEziaMVI4ugAhXZv5E9noicsWOvu5LWVicld86tTNNlicpJ8UfBsTxSPOdpxUgHgK35ArydcTuD9icib6qnygN0MYV9G9WjF1/0', 1461818385, '味道挺好的呀', '2016042812394586'),
('otemYwJzZjl0xDoMYpNGwiVczgfw', '麦', 'http://wx.qlogo.cn/mmopen/eWdpuJEziaMVI4ugAhXZv5E9noicsWOvu5LWVicld86tTNNlicpJ8UfBsTxSPOdpxUgHgK35ArydcTuD9icib6qnygN0MYV9G9WjF1/0', 1461822918, '好吃', '2016042813551878'),
('otemYwJzZjl0xDoMYpNGwiVczgfw', '麦', 'http://wx.qlogo.cn/mmopen/icvzC7hbXuaSAQWYI2nDkrhMRIOgSvmlROXOE5qXf1L8Gxdj3k2JlciclZQW9XQMIyVWDudHkdNc7ElgkcTWyZdBKqq9jwFZLy/0', 1462589164, '好好好好吃', '2016050710460432');

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `m_id` char(16) NOT NULL DEFAULT '',
  `m_email` char(50) NOT NULL DEFAULT 'NULL',
  `m_integral` int(11) NOT NULL,
  `m_grade` int(2) NOT NULL DEFAULT '0',
  `m_account` int(11) DEFAULT NULL,
  `m_amount` float DEFAULT NULL,
  `m_openid` char(50) NOT NULL,
  `m_exist` decimal(1,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`m_id`, `m_email`, `m_integral`, `m_grade`, `m_account`, `m_amount`, `m_openid`, `m_exist`) VALUES
('9999999999999999', 'NULL', 0, 0, 0, 0, 'abc', '1');

-- --------------------------------------------------------

--
-- 表的结构 `orderdesk`
--

CREATE TABLE IF NOT EXISTS `orderdesk` (
  `r_id` decimal(16,0) NOT NULL,
  `o_id` decimal(16,0) NOT NULL,
  `b_id` decimal(2,0) NOT NULL,
  `r_disamount` float NOT NULL,
  `r_amount` float NOT NULL,
  `r_time` char(20) NOT NULL DEFAULT '',
  `r_state` char(20) NOT NULL DEFAULT 'NULL',
  `r_exist` decimal(1,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `orderdish`
--

CREATE TABLE IF NOT EXISTS `orderdish` (
  `u_id` decimal(16,0) NOT NULL DEFAULT '0',
  `d_id` decimal(6,0) NOT NULL,
  `r_id` decimal(16,0) NOT NULL,
  `u_account` int(11) NOT NULL,
  `u_state` char(10) NOT NULL DEFAULT '',
  `u_flavor` decimal(1,0) DEFAULT '0',
  `u_amount` float NOT NULL,
  `u_dish` char(32) NOT NULL,
  `u_price` float NOT NULL,
  `u_disprice` float NOT NULL,
  `u_disamount` float NOT NULL DEFAULT '0',
  `u_urgent` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `o_id` decimal(16,0) NOT NULL,
  `m_id` char(16) NOT NULL DEFAULT '',
  `w_id` decimal(6,0) NOT NULL,
  `o_time` datetime NOT NULL,
  `o_number` int(11) DEFAULT NULL,
  `o_amount` float NOT NULL,
  `o_discount` float NOT NULL,
  `o_receivable` float NOT NULL,
  `o_received` float NOT NULL,
  `o_integral` int(11) NOT NULL,
  `o_etime` datetime NOT NULL,
  `o_state` char(10) NOT NULL,
  `o_tablenumber` int(11) DEFAULT NULL,
  `o_exist` decimal(1,0) DEFAULT NULL,
  `o_deposit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `remsg`
--

CREATE TABLE IF NOT EXISTS `remsg` (
  `y_openid` char(50) NOT NULL DEFAULT '',
  `y_content` decimal(16,0) NOT NULL DEFAULT '0',
  `y_addtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `y_state` char(10) NOT NULL,
  `y_usetime` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `reserve`
--

CREATE TABLE IF NOT EXISTS `reserve` (
  `n_id` decimal(16,0) NOT NULL,
  `n_reservetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `n_usernumber` int(11) NOT NULL,
  `n_name` char(10) NOT NULL,
  `n_phone` decimal(11,0) NOT NULL,
  `n_description` text,
  `n_money` float NOT NULL,
  `n_state` char(10) NOT NULL DEFAULT '',
  `n_usetime` char(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `reservedesk`
--

CREATE TABLE IF NOT EXISTS `reservedesk` (
  `v_id` decimal(16,0) NOT NULL,
  `n_id` decimal(16,0) NOT NULL,
  `b_id` decimal(2,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `s_openid` char(50) NOT NULL DEFAULT '',
  `s_nickname` char(30) NOT NULL DEFAULT '',
  `s_headimgurl` char(250) NOT NULL DEFAULT '',
  `s_subtime` int(11) NOT NULL DEFAULT '0',
  `s_sex` decimal(1,0) DEFAULT '0',
  `s_city` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`s_openid`, `s_nickname`, `s_headimgurl`, `s_subtime`, `s_sex`, `s_city`) VALUES
('otemYwPg5_Bh5PBPsa5dZC7tPsRA', '沙漏的离歌', 'http://wx.qlogo.cn/mmopen/LMHiagiaWARTALR6bZOFm5s0WJc10vgrTyTcQzDOQscle5q2VfRicJwP8u9ITyjGgj3fKE5CM6bpic2tTGVD5bk78bq4iaUe3SL29/0', 1461813733, '2', '石家庄'),
('otemYwPZ-fJtcLx2RBpWEZ8QFGOc', '秦天依', 'http://wx.qlogo.cn/mmopen/UDMYft3sF5jZtiaT7iam2JmOmUUicjvCiaKXXaaCpY3TR5wKcJvubtx4LCmDWGS0fJT4TUYXx8rHCUC7OLsEShcxLRFylSbeRLcv/0', 1464343755, '2', '衡水');

-- --------------------------------------------------------

--
-- 表的结构 `waiter`
--

CREATE TABLE IF NOT EXISTS `waiter` (
  `w_id` decimal(6,0) NOT NULL,
  `w_name` char(10) NOT NULL,
  `w_age` int(11) DEFAULT NULL,
  `w_sex` decimal(1,0) DEFAULT '1',
  `w_exist` decimal(1,0) NOT NULL,
  `w_state` char(10) NOT NULL DEFAULT '空闲',
  `w_desk` decimal(2,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `waiter`
--

INSERT INTO `waiter` (`w_id`, `w_name`, `w_age`, `w_sex`, `w_exist`, `w_state`, `w_desk`) VALUES
('100001', '李四', 52, '1', '1', '空闲', NULL),
('100002', '王五', 25, '1', '1', '空闲', NULL),
('100003', '陈六', 25, '0', '1', '空闲', NULL),
('100004', '李丽', 45, '0', '1', '空闲', NULL),
('100005', '陈佳', 24, '1', '1', '空闲', NULL),
('100006', '程成', 24, '1', '1', '空闲', NULL),
('100007', '陈媛', 23, '0', '0', '空闲', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `classfication`
--
ALTER TABLE `classfication`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `desk`
--
ALTER TABLE `desk`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`), ADD KEY `FK_包括` (`c_id`);

--
-- Indexes for table `judgement`
--
ALTER TABLE `judgement`
  ADD PRIMARY KEY (`j_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `orderdesk`
--
ALTER TABLE `orderdesk`
  ADD PRIMARY KEY (`r_id`), ADD KEY `FK_使用` (`b_id`), ADD KEY `FK_订单` (`o_id`);

--
-- Indexes for table `orderdish`
--
ALTER TABLE `orderdish`
  ADD PRIMARY KEY (`u_id`), ADD KEY `FK_点菜` (`d_id`), ADD KEY `FK_菜单` (`r_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`), ADD KEY `FK_拥有` (`m_id`), ADD KEY `FK_服务` (`w_id`);

--
-- Indexes for table `remsg`
--
ALTER TABLE `remsg`
  ADD PRIMARY KEY (`y_content`);

--
-- Indexes for table `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `reservedesk`
--
ALTER TABLE `reservedesk`
  ADD PRIMARY KEY (`v_id`), ADD KEY `FK_预定` (`n_id`), ADD KEY `FK_餐桌` (`b_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`s_openid`);

--
-- Indexes for table `waiter`
--
ALTER TABLE `waiter`
  ADD PRIMARY KEY (`w_id`);

--
-- 限制导出的表
--

--
-- 限制表 `dishes`
--
ALTER TABLE `dishes`
ADD CONSTRAINT `FK_包括` FOREIGN KEY (`c_id`) REFERENCES `classfication` (`c_id`);

--
-- 限制表 `orderdesk`
--
ALTER TABLE `orderdesk`
ADD CONSTRAINT `FK_使用` FOREIGN KEY (`b_id`) REFERENCES `desk` (`b_id`),
ADD CONSTRAINT `FK_订单` FOREIGN KEY (`o_id`) REFERENCES `orders` (`o_id`);

--
-- 限制表 `orderdish`
--
ALTER TABLE `orderdish`
ADD CONSTRAINT `FK_点菜` FOREIGN KEY (`d_id`) REFERENCES `dishes` (`d_id`),
ADD CONSTRAINT `FK_菜单` FOREIGN KEY (`r_id`) REFERENCES `orderdesk` (`r_id`);

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `FK_拥有` FOREIGN KEY (`m_id`) REFERENCES `member` (`m_id`),
ADD CONSTRAINT `FK_服务` FOREIGN KEY (`w_id`) REFERENCES `waiter` (`w_id`);

--
-- 限制表 `reservedesk`
--
ALTER TABLE `reservedesk`
ADD CONSTRAINT `FK_预定` FOREIGN KEY (`n_id`) REFERENCES `reserve` (`n_id`),
ADD CONSTRAINT `FK_餐桌` FOREIGN KEY (`b_id`) REFERENCES `desk` (`b_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
