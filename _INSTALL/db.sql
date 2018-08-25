CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reset_key` varchar(100) DEFAULT NULL,
  `activated` varchar(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `api_key` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `user_addresses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address` varchar(100) NOT NULL,
  `alerts` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `to` varchar(100) NOT NULL,
  `from` varchar(100) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `block` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `charts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `timestamp` varchar(50) NOT NULL,
  `difficulty` int NOT NULL,
  `transactions_daily` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
