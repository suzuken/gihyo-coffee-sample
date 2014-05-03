DROP DATABASE IF EXISTS `coffee_db`;
CREATE DATABASE IF NOT EXISTS `coffee_db`;
GRANT ALL PRIVILEGES ON `coffee_db`.* TO `coffee`@`localhost` IDENTIFIED BY 'coffeepass';

CREATE TABLE IF NOT EXISTS `coffee_db`.`user` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    PRIMARY KEY ( `id` )
) ENGINE = INNODB CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `coffee_db`.`item` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `price` int(10) NOT NULL,
    `name` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `photo_src` varchar(2000),
    `photo_href` varchar(2000),
    `photo_title` varchar(2000),
    `type` int(1) unsigned NOT NULL,
    PRIMARY KEY ( `id` )
) ENGINE = INNODB CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `coffee_db`.`purchase` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `item_id` int(10) unsigned NOT NULL,
    `price` int(10) unsigned NOT NULL,
    PRIMARY KEY ( `id` )
) ENGINE = INNODB CHARACTER SET utf8;

