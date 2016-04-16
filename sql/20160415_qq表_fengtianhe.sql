CREATE TABLE `dami_qqonline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `number` varchar(15) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '-1关闭 1开启',
  `is_del` tinyint(4) DEFAULT '-1',
  `is_qun` tinyint(4) DEFAULT '-1' COMMENT '-1是qq 1是群',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8
