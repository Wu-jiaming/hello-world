-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-08 07:48:40
-- 服务器版本： 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- 表的结构 `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `preview` varchar(100) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `category_no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `preview`, `parent_id`, `category_no`, `created_at`, `updated_at`) VALUES
(1, 'php', NULL, NULL, 1, NULL, NULL),
(2, 'java', NULL, NULL, 2, NULL, NULL),
(3, 'javascript', NULL, NULL, 3, NULL, NULL),
(4, 'laravel', NULL, 1, 1, NULL, NULL),
(5, 'thinkphp', NULL, 1, 2, NULL, NULL),
(6, 'yll', NULL, 1, 3, NULL, NULL),
(7, 'node.js', NULL, 3, 1, NULL, NULL),
(8, 'react.js', NULL, 3, 2, NULL, NULL),
(10, 'java base', NULL, 2, 1, NULL, NULL),
(11, 'java web', NULL, 2, 2, NULL, NULL),
(16, '21', 'http://localhost:8080/laravel2/public/upload/images/20180211/3bdcb0bc6fe5de5add55e0f2d2a8f5b3.jpg', NULL, 16, '2018-02-05 15:44:54', '2018-02-10 16:32:00'),
(18, '1', 'http://localhost:8080/laravel2/public//upload/images/20180206/2e554614d918cc5589506b912edb6957.jpg', 1, 18, '2018-02-05 15:52:49', '2018-02-05 16:09:38');

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `order_no` varchar(45) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `payway` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `member_id`, `order_no`, `total_price`, `name`, `status`, `payway`, `created_at`, `updated_at`) VALUES
(2, 2, '201806071953185985870304', '616.00', '7*深入浅出Node.js', 1, 1, '2018-06-07 11:53:18', '2018-06-07 11:53:18'),
(3, 2, '201806071956547709899988', '176.00', '2*深入浅出Node.js', 1, 1, '2018-06-07 11:56:54', '2018-06-07 11:56:54');

-- --------------------------------------------------------

--
-- 表的结构 `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `pdt_snapshot` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `count`, `pdt_snapshot`) VALUES
(2, 2, 1, 7, NULL),
(3, 3, 1, 2, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `pdt_content`
--

CREATE TABLE `pdt_content` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `content` varchar(20000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `pdt_content`
--

INSERT INTO `pdt_content` (`id`, `product_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, '作者：厂长\r\n链接：https://www.zhihu.com/question/33578075/answer/56951771\r\n来源：知乎\r\n著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。\r\n\r\n如果你去年注意过技术方面的新闻，我敢说你至少看到node.js不下一两次。那么问题来了“node.js是什么？”。有些人没准会告诉你“这是一种通过JavaScript语言开发web服务端的东西”。如果这种晦涩解释还没把你搞晕，你没准会接着问：“为什么我们要用node.js？”，别人一般会告诉你：node.js有非阻塞，事件驱动I/O等特性，从而让高并发（high concurrency）在的轮询（Polling）和comet构建的应用中成为可能。当你看完这些解释觉得跟看天书一样的时候，你估计也懒得继续问了。不过没事。我这篇文章就是在避开高端术语的同时，帮助你你理解node.js的。浏览器给网站发请求的过程一直没怎么变过。当浏览器给网站发了请求。服务器收到了请求，然后开始搜寻被请求的资源。如果有需要，服务器还会查询一下数据库，最后把响应结果传回浏览器。不过，在传统的web服务器中（比如Apache），每一个请求都会让服务器创建一个新的进程来处理这个请求。后来有了Ajax。有了Ajax，我们就不用每次都请求一个完整的新页面了，取而代之的是，每次只请求需要的部分页面信息就可以了。这显然是一个进步。但是比如你要建一个FriendFeed这样的社交网站（类似人人网那样的刷朋友新鲜事的网站），你的好友会随时的推送新的状态，然后你的新鲜事会实时自动刷新。要达成这个需求，我们需要让用户一直与服务器保持一个有效连接。目前最简单的实现方法，就是让用户和服务器之间保持长轮询（long polling）。HTTP请求不是持续的连接，你请求一次，服务器响应一次，然后就完了。长轮训是一种利用HTTP模拟持续连接的技巧。具体来说，只要页面载入了，不管你需不需要服务器给你响应信息，你都会给服务器发一个Ajax请求。这个请求不同于一般的Ajax请求，服务器不会直接给你返回信息，而是它要等着，直到服务器觉得该给你发信息了，它才会响应。比如，你的好友发了一条新鲜事，服务器就会把这个新鲜事当做响应发给你的浏览器，然后你的浏览器就刷新页面了。浏览器收到响应刷新完之后，再发送一条新的请求给服务器，这个请求依然不会立即被响应。于是就开始重复以上步骤。利用这个方法，可以让浏览器始终保持等待响应的状态。虽然以上过程依然只有非持续的Http参与，但是我们模拟出了一个看似持续的连接状态我们再看传统的服务器（比如Apache）。每次一个新用户连到你的网站上，你的服务器就得开一个连接。每个连接都需要占一个进程，这些进程大部分时间都是闲着的（比如等着你好友发新鲜事，等好友发完才给用户响应信息。或者等着数据库返回查询结果什么的）。虽然这些进程闲着，但是照样占用内存。这意味着，如果用户连接数的增长到一定规模，你服务器没准就要耗光内存直接瘫了。这种情况怎么解决？解决方法就是刚才上边说的：非阻塞和事件驱动。这些概念在我们谈的这个情景里面其实没那么难理解。你把非阻塞的服务器想象成一个loop循环，这个loop会一直跑下去。一个新请求来了，这个loop就接了这个请求，把这个请求传给其他的进程（比如传给一个搞数据库查询的进程），然后响应一个回调（callback）。完事了这loop就接着跑，接其他的请求。这样下来。服务器就不会像之前那样傻等着数据库返回结果了。如果数据库把结果返回来了，loop就把结果传回用户的浏览器，接着继续跑。在这种方式下，你的服务器的进程就不会闲着等着。从而在理论上说，同一时刻的数据库查询数量，以及用户的请求数量就没有限制了。服务器只在用户那边有事件发生的时候才响应，这就是事件驱动。FriendFeed是用基于Python的非阻塞框架Tornado (知乎也用了这个框架) 来实现上面说的新鲜事功能的。不过，Node.js就比前者更妙了。Node.js的应用是通过javascript开发的，然后直接在Google的变态V8引擎上跑。用了Node.js，你就不用担心用户端的请求会在服务器里跑了一段能够造成阻塞的代码了。因为javascript本身就是事件驱动的脚本语言。你回想一下，在给前端写javascript的时候，更多时候你都是在搞事件处理和回调函数。javascript本身就是给事件处理量身定制的语言。Node.js还是处于初期阶段。如果你想开发一个基于Node.js的应用，你应该会需要写一些很底层代码。但是下一代浏览器很快就要采用WebSocket技术了，从而长轮询也会消失。在Web开发里，Node.js这种类型的技术只会变得越来越重要。', NULL, NULL),
(2, NULL, '<p>ad<br/></p>', '2018-02-06 15:40:44', '2018-02-06 15:40:44'),
(3, NULL, '<p>aaa<br/></p>', '2018-02-06 15:47:47', '2018-02-06 15:47:47'),
(4, 7, '<p>dd dsa<br/></p>', '2018-02-06 15:51:30', '2018-02-06 15:51:30'),
(7, 10, '<p>dsadasdasssssssssssssssssssssssssssssssssssssssssssssssss<br/></p>', '2018-02-07 13:57:08', '2018-02-07 13:57:08'),
(9, 11, '<p>的<br/></p>', '2018-02-07 15:05:58', '2018-02-07 15:05:58');

-- --------------------------------------------------------

--
-- 表的结构 `pdt_image`
--

CREATE TABLE `pdt_image` (
  `id` int(11) NOT NULL,
  `image_path` varchar(200) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_no` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `pdt_image`
--

INSERT INTO `pdt_image` (`id`, `image_path`, `product_id`, `image_no`, `created_at`, `updated_at`) VALUES
(1, '/images/1.jpg', 1, 1, NULL, NULL),
(2, '/images/2.jpg', 1, NULL, NULL, NULL),
(3, '/images/3.jpg', 1, NULL, NULL, NULL),
(4, 'http://localhost:8080/laravel2/public//upload/images/20180206/661888ee7ef0287cdfced9f84759bb3f.jpg', NULL, 1, '2018-02-06 15:47:47', '2018-02-06 15:47:47'),
(5, 'http://localhost:8080/laravel2/public//upload/images/20180206/338f1638aeb141e4a02658668e8595de.jpg', NULL, 2, '2018-02-06 15:47:47', '2018-02-06 15:47:47'),
(6, 'http://localhost:8080/laravel2/public//upload/images/20180206/c52fffa0ed993cc823bfac0938230a2a.jpg', NULL, 3, '2018-02-06 15:47:47', '2018-02-06 15:47:47'),
(7, 'http://localhost:8080/laravel2/public//upload/images/20180206/56abcbb28467f7980756c40b4a8121a6.jpg', NULL, 4, '2018-02-06 15:47:47', '2018-02-06 15:47:47'),
(8, 'http://localhost:8080/laravel2/public//upload/images/20180206/878954d43d4075149c613a3384767919.jpg', NULL, 5, '2018-02-06 15:47:48', '2018-02-06 15:47:48'),
(9, 'http://localhost:8080/laravel2/public//upload/images/20180206/f0e3a0ff27bb0cac1604ca8914f5eb77.jpg', 7, 1, '2018-02-06 15:51:30', '2018-02-06 15:51:30'),
(10, 'http://localhost:8080/laravel2/public//upload/images/20180206/9e3fd007702d839594b486ac5936c21f.jpg', 7, 2, '2018-02-06 15:51:30', '2018-02-06 15:51:30'),
(11, 'http://localhost:8080/laravel2/public//upload/images/20180206/4ea9c217c3ad0eee8d77a216944e4e14.jpg', 7, 3, '2018-02-06 15:51:30', '2018-02-06 15:51:30'),
(12, 'http://localhost:8080/laravel2/public//upload/images/20180206/95ab9cbe479c6a92877d61ac0c76ea75.jpg', 7, 4, '2018-02-06 15:51:30', '2018-02-06 15:51:30'),
(13, 'http://localhost:8080/laravel2/public//upload/images/20180206/6cecad4c0360923c725df206f6313972.jpg', 7, 5, '2018-02-06 15:51:30', '2018-02-06 15:51:30'),
(24, 'http://localhost:8080/laravel2/public//upload/images/20180206/f0e3a0ff27bb0cac1604ca8914f5eb77.jpg', 10, 1, '2018-02-07 13:57:08', '2018-02-07 13:57:08'),
(25, 'http://localhost:8080/laravel2/public//upload/images/20180206/9e3fd007702d839594b486ac5936c21f.jpg', 10, 2, '2018-02-07 13:57:08', '2018-02-07 13:57:08'),
(26, 'http://localhost:8080/laravel2/public//upload/images/20180206/4ea9c217c3ad0eee8d77a216944e4e14.jpg', 10, 3, '2018-02-07 13:57:08', '2018-02-07 13:57:08'),
(27, 'http://localhost:8080/laravel2/public//upload/images/20180206/95ab9cbe479c6a92877d61ac0c76ea75.jpg', 10, 4, '2018-02-07 13:57:08', '2018-02-07 13:57:08'),
(28, 'http://localhost:8080/laravel2/public//upload/images/20180206/6cecad4c0360923c725df206f6313972.jpg', 10, 5, '2018-02-07 13:57:08', '2018-02-07 13:57:08'),
(29, 'http://localhost:8080/laravel2/public//upload/images/20180206/f0e3a0ff27bb0cac1604ca8914f5eb77.jpg', 10, 1, '2018-02-07 14:09:55', '2018-02-07 14:09:55'),
(30, 'http://localhost:8080/laravel2/public//upload/images/20180206/9e3fd007702d839594b486ac5936c21f.jpg', 10, 2, '2018-02-07 14:09:55', '2018-02-07 14:09:55'),
(31, 'http://localhost:8080/laravel2/public//upload/images/20180206/4ea9c217c3ad0eee8d77a216944e4e14.jpg', 10, 3, '2018-02-07 14:09:55', '2018-02-07 14:09:55'),
(32, 'http://localhost:8080/laravel2/public//upload/images/20180206/95ab9cbe479c6a92877d61ac0c76ea75.jpg', 10, 4, '2018-02-07 14:09:55', '2018-02-07 14:09:55'),
(33, 'http://localhost:8080/laravel2/public//upload/images/20180206/6cecad4c0360923c725df206f6313972.jpg', 10, 5, '2018-02-07 14:09:55', '2018-02-07 14:09:55'),
(34, 'http://localhost:8080/laravel2/public//upload/images/20180207/f5dd94a6298927989d9f898a54a62834.jpg', 11, 1, '2018-02-07 15:05:58', '2018-02-07 15:05:58'),
(35, 'http://localhost:8080/laravel2/public//upload/images/20180207/b67999593f7fb23970b5f94acec08795.jpg', 12, 1, '2018-02-07 15:13:16', '2018-02-07 15:13:16');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `summary` varchar(200) DEFAULT NULL,
  `preview` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `name`, `summary`, `preview`, `category_id`, `price`, `created_at`, `updated_at`) VALUES
(1, '深入浅出Node.js', '简单的说 Node.js 就是运行在服务端的 JavaScript。\r\n\r\nNode.js 是一个基于Chrome JavaScript 运行时建立的一个平台。\r\n\r\nNode.js是一个事件驱动I/O服务端JavaScript环境，基于Google的V8引擎，V8引擎执行Javascript的速度非常快，性能非常好。', '/images/1.jpg', 7, '88.00', NULL, NULL),
(2, 'node.js的权威指南', '一种javascript的运行环境，能够使得javascript脱离浏览器运行', '/images/2.jpg', 7, '44.00', NULL, NULL),
(3, 'React', 'React 是一个用于构建用户界面的 JAVASCRIPT 库。\r\n\r\nReact主要用于构建UI，很多人认为 React 是 MVC 中的 V（视图）。\r\n\r\nReact 起源于 Facebook 的内部项目，用来架设 Instagram 的网站，并于 2013 年 5 月开源。\r\n\r\nReact 拥有较高的性能，代码逻辑非常简单，越来越多的人已开始关注和使用它。', '/images/3.jpg', 8, '11.00', NULL, NULL),
(4, 'React Native', 'React是Facebook开发的一款JS库.\r\nFacebook认为MVC无法满足他们的扩展需求，由于他们非常巨大的代码库和庞大的组织，使得MVC很快变得非常复复杂，每当需要添加一项新的功能或特性时，系统的复杂度就成级数增长，致使代码变得脆弱和不可预测，结果导致他们的MVC正在土崩瓦解。认为MVC不适合大规模应用，当系统中有很多的模型和相应的视图时，其复杂度就会迅速扩大，非常难以理解和调试，特别', '/images/4.jpg', 8, '22.00', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `temp_email`
--

CREATE TABLE `temp_email` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `deadline` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `temp_email`
--

INSERT INTO `temp_email` (`id`, `member_id`, `code`, `deadline`) VALUES
(1, 13, '309561b6afe8a4a0a29ba65bd027a8b2', '2018-01-22 14:47:27'),
(2, 14, '2860c6df3d206ee6ea2000d1a3d801ef', '2018-01-22 14:47:33'),
(3, 15, 'dbf069b81e2b1916c8729e9c7ca5ba50', '2018-01-22 14:47:58'),
(4, 16, '204d54937688b1f627b4a995081f7d1b', '2018-01-22 14:48:03'),
(5, 17, '5594feb99b575c1b47734f20a5e254a4', '2018-01-22 14:48:17'),
(6, 18, '9741fcabd2f7be9b1de1cd36454ca548', '2018-01-22 14:48:39'),
(7, 19, 'c5d4bc109e19ca376e72636ab3a09726', '2018-01-22 14:55:44'),
(8, 20, '6aebc1a77cb98a6d72089db7b09fa94a', '2018-01-22 15:01:29'),
(9, 21, 'd3580fdf84d992bbb80b29d522838c37', '2018-01-22 15:01:46'),
(10, 22, '430ff26a6884ab1cb3cd78ddc89242da', '2018-01-22 15:06:13'),
(11, 23, '069414f24899379b7c3974786004920f', '2018-01-22 15:06:18'),
(12, 24, 'c40e2c6fd5f53389435fe0236b092d57', '2018-01-22 15:06:24'),
(13, 25, 'd10929c4b80ff2b1af8bf081776a9218', '2018-01-22 15:08:10'),
(14, 26, 'bb724ab71d5857fd7c80700c746f5a14', '2018-01-22 15:12:17'),
(15, 27, '924c77e5110d4baaa478a6ff790d9a7a', '2018-01-22 15:12:24'),
(16, 28, '24e04cd3adebe6ff66b6a61e5d5f7e6a', '2018-01-22 15:15:35'),
(17, 29, '70dc3eb0a7920e891bd3ec6e18b552aa', '2018-01-22 15:15:43'),
(18, 30, '03bb8f246cf605afb5740cd670310c48', '2018-01-22 15:17:03'),
(19, 31, 'b29ea1774aad28bdbb6ab8185ef94251', '2018-01-22 15:22:26'),
(20, 32, '025809434eba8ce4e3a2bc4e53e4a9bc', '2018-01-22 15:22:26'),
(21, 33, 'be1ff6248bec5587b1da1e21faf7a770', '2018-01-22 15:22:27'),
(22, 34, '9ebe979aa5d7dbc69824d5a366ae0bee', '2018-01-22 15:22:27'),
(23, 35, '217f0681699a0c8effbc1970ac192ef2', '2018-01-22 15:22:27'),
(24, 36, '9e31601a14bdcef1632c71ab8ffddf72', '2018-01-22 15:22:29'),
(25, 37, '930b7d7a37deae134f80deeee3d9f2c6', '2018-01-22 15:22:29'),
(26, 38, '95f5534928d71e2563e7f0e41cd3225c', '2018-01-22 15:22:30'),
(27, 39, '82697974c90313acef0c32b2b1332ebc', '2018-01-22 15:22:30'),
(28, 40, '93a197c8ef40db568dc3d55d2f18392b', '2018-01-22 15:22:46'),
(29, 41, '59f87231e799aeb4216403660a1c8c35', '2018-01-22 15:22:47'),
(30, 42, 'fd820c710bc171da60e712b3dcf5bf40', '2018-01-22 15:22:57'),
(31, 43, '4b359263768d9cbf10d0b9c980514220', '2018-01-22 15:22:58'),
(32, 44, 'fc0df5ed49fe7b347052a59ac44a9889', '2018-01-22 15:22:58'),
(33, 45, 'caeecc1c82e69f1ccf5b1d7dbfc6736f', '2018-01-22 15:26:48'),
(34, 46, '6f5bef5c88663410d943eb2d1ce1afd0', '2018-01-22 15:53:58'),
(35, 48, '4c114635415d016028364fe35eba9c9d', '2018-06-07 15:11:59'),
(36, 49, 'a3e6d7c27a7a18e578821233d6fff1cc', '2018-06-07 15:12:27');

-- --------------------------------------------------------

--
-- 表的结构 `temp_phone`
--

CREATE TABLE `temp_phone` (
  `id` int(11) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `deadline` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `temp_phone`
--

INSERT INTO `temp_phone` (`id`, `phone`, `code`, `deadline`) VALUES
(1, '13112339438', 348276, '2018-06-06 16:06:11');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `phone`, `created_at`, `updated_at`, `active`) VALUES
(1, '1', '1', NULL, '', NULL, NULL, NULL),
(2, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '13112339438', '2018-01-20 17:17:47', '2018-01-20 17:17:47', NULL),
(3, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:32:33', '2018-01-21 14:32:33', NULL),
(4, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:32:37', '2018-01-21 14:32:37', NULL),
(5, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:32:46', '2018-01-21 14:32:46', NULL),
(6, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:32:50', '2018-01-21 14:32:50', NULL),
(7, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:42:47', '2018-01-21 14:42:47', NULL),
(8, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:42:56', '2018-01-21 14:42:56', NULL),
(9, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:42:59', '2018-01-21 14:42:59', NULL),
(10, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:45:22', '2018-01-21 14:45:22', NULL),
(11, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:46:42', '2018-01-21 14:46:42', NULL),
(12, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:46:43', '2018-01-21 14:46:43', NULL),
(13, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:47:27', '2018-01-21 14:47:27', NULL),
(14, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:47:33', '2018-01-21 14:47:33', NULL),
(15, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:47:58', '2018-01-21 14:47:58', NULL),
(16, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:48:03', '2018-01-21 14:48:03', NULL),
(17, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:48:17', '2018-01-21 14:48:17', NULL),
(18, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:48:39', '2018-01-21 14:48:39', NULL),
(19, NULL, 'e10adc3949ba59abbe56e057f20f883e', '754205661@qq.com', '', '2018-01-21 14:55:44', '2018-01-21 14:55:44', NULL),
(20, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:01:29', '2018-01-21 15:01:29', NULL),
(21, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:01:46', '2018-01-21 15:01:46', NULL),
(22, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:06:13', '2018-01-21 15:06:13', NULL),
(23, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:06:18', '2018-01-21 15:06:18', NULL),
(24, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:06:24', '2018-01-21 15:06:24', NULL),
(25, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:08:10', '2018-01-21 15:08:10', NULL),
(26, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:12:17', '2018-01-21 15:12:17', NULL),
(27, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:12:24', '2018-01-21 15:12:24', NULL),
(28, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:15:35', '2018-01-21 15:15:35', NULL),
(29, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:15:43', '2018-01-21 15:15:43', NULL),
(30, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:17:03', '2018-01-21 15:17:03', NULL),
(31, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:26', '2018-01-21 15:22:26', NULL),
(32, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:26', '2018-01-21 15:22:26', NULL),
(33, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:27', '2018-01-21 15:22:27', NULL),
(34, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:27', '2018-01-21 15:22:27', NULL),
(35, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:27', '2018-01-21 15:22:27', NULL),
(36, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:29', '2018-01-21 15:22:29', NULL),
(37, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:29', '2018-01-21 15:22:29', NULL),
(38, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:30', '2018-01-21 15:22:30', NULL),
(39, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:30', '2018-01-21 15:22:30', NULL),
(40, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:46', '2018-01-21 15:22:46', NULL),
(41, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:47', '2018-01-21 15:22:47', NULL),
(42, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:57', '2018-01-21 15:22:57', NULL),
(43, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:58', '2018-01-21 15:22:58', NULL),
(44, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:22:58', '2018-01-21 15:22:58', NULL),
(45, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:26:48', '2018-01-21 15:26:48', NULL),
(46, NULL, 'e10adc3949ba59abbe56e057f20f883e', 'wnfnko@163.com', '', '2018-01-21 15:53:58', '2018-01-21 15:54:20', 1),
(47, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '13112339438', '2018-06-06 15:08:32', '2018-06-06 15:08:32', 1),
(48, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2495336890@qq.com', '', '2018-06-06 15:11:59', '2018-06-06 15:16:15', 1),
(49, NULL, 'e10adc3949ba59abbe56e057f20f883e', '2495336890@qq.com', '', '2018-06-06 15:12:27', '2018-06-06 15:12:27', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdt_content`
--
ALTER TABLE `pdt_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdt_image`
--
ALTER TABLE `pdt_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_email`
--
ALTER TABLE `temp_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_phone`
--
ALTER TABLE `temp_phone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- 使用表AUTO_INCREMENT `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `pdt_content`
--
ALTER TABLE `pdt_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `pdt_image`
--
ALTER TABLE `pdt_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `temp_email`
--
ALTER TABLE `temp_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- 使用表AUTO_INCREMENT `temp_phone`
--
ALTER TABLE `temp_phone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
