CREATE DATABASE yeti CHARACTER SET utf8 COLLATE utf8_bin;
use yeti;
CREATE TABLE categories (
  category_id INT auto_increment NOT NULL PRIMARY KEY,
  category_name VARCHAR(127) unique key
);
CREATE TABLE users (
  user_id INT auto_increment NOT NULL PRIMARY KEY,
  user_name VARCHAR(255),
  user_email VARCHAR(255) unique key,
  user_password CHAR(72),
  user_img_url VARCHAR(255),
  user_contacts VARCHAR(127),
  user_is_deleted TINYINT default 0
);
CREATE TABLE bets (
  bet_id INT auto_increment NOT NULL PRIMARY KEY,
  bet_value INT,
  bet_date_add TIMESTAMP,
  user_id INT not null,
  bet_is_win TINYINT default 0,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);
CREATE TABLE lots (
  lot_id INT auto_increment NOT NULL PRIMARY KEY,
  lot_name VARCHAR(127),
  lot_date_end TIMESTAMP,
  lot_description VARCHAR(1500) default 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег
  мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях,
  наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в
  сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости.
  А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску
  и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
  lot_img_url VARCHAR(127),
  lot_value INT,
  lot_step INT,
  user_id INT not null,
  category_id INT not null
);
ALTER TABLE bets ADD lot_id INT not null AFTER bet_id;
ALTER TABLE bets ADD FOREIGN KEY (lot_id) REFERENCES lots(lot_id);
