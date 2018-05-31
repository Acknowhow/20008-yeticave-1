CREATE DATABASE yeti CHARACTER SET utf8 COLLATE utf8_bin;
USE yeti;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `name` VARCHAR(127)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `name` VARCHAR(127),
  `email` VARCHAR(255),
  `password` CHAR(72),
  `avatar_path` VARCHAR(255),
  `contacts` VARCHAR(128)
);

DROP TABLE IF EXISTS `bets`;
CREATE TABLE `bets` (
  `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `value` INT(20),
  `date_add` DATETIME,
  `user_id` INT(11) unsigned NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

DROP TABLE IF EXISTS `lots`;
CREATE TABLE `lots` (
  `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `name` VARCHAR(127),
  `date_add` DATETIME,
  `date_end` DATETIME,
  `description` VARCHAR(1500) default 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег
  мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях,
  наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в
  сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости.
  А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску
  и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
  `lot_path` VARCHAR(127),
  `value` INT(20),
  `step` INT(20),
  `user_id` INT(11) unsigned NOT NULL,
  `category_id` INT(11) unsigned NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
);

INSERT INTO `categories`(`name`) VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'),
  ('Одежда'), ('Инструменты'), ('Разное');

ALTER TABLE `bets` ADD `lot_id` INT unsigned NOT NULL AFTER `id`;
ALTER TABLE `bets` ADD FOREIGN KEY (`lot_id`) REFERENCES `lots`(`id`);

ALTER TABLE `categories` ADD UNIQUE INDEX (`name`);
ALTER TABLE `users` ADD UNIQUE INDEX (`email`);

ALTER TABLE `categories` ADD INDEX (`name`);
ALTER TABLE `users` ADD INDEX (`name`);
ALTER TABLE `bets` ADD INDEX (`user_id`, `lot_id`, `date_add`);
ALTER TABLE `lots` ADD INDEX (`name`, `date_add`, `date_end`, `user_id`,`category_id`);
