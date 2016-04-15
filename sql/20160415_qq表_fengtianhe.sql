CREATE TABLE `dami_qqonline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `number` varchar(15) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '-1关闭 1开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
