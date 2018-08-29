CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reset_key` varchar(50) DEFAULT NULL,
  `activated` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `user_addresses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address` varchar(50) NOT NULL,
  `alerts` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `to` varchar(50) NOT NULL,
  `from` varchar(50) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `block` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `ds_charts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blocknum` int NOT NULL,
  `difficulty` int NOT NULL,
  `timestamp` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `tx_charts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blocknum` int NOT NULL,
  `gas_used` int NOT NULL,
  `micro_blocks` int NOT NULL,
  `transactions` int NOT NULL,
  `timestamp` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


