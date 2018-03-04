insert into categories(category_name) values('Доски и лыжи'), ('Крепления'), ('Ботинки'),
  ('Одежда'), ('Инструменты'), ('Разное');
insert into users (user_name, user_email, user_password, user_img_url) values('Иван', 'ivan.v@gmail.com', '$2y$10$Ug4Ternwf8xmO5nK2s1/EupzsaHaUd7cuLPVL227NqxkaJ2qy9REW', 'img/Ivan.png'),
  ('Eлена', 'kitty_93@li.ru', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', 'img/Lena.png'),
  ('Руслан', 'warrior07@mail.ru', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', 'img/Ruslan_INNit.png');

insert into lots(lot_name, lot_date_end, lot_img_url, lot_value, lot_step, user_id, category_id) values ('2014 Rossignol District Snowboard', '2017-12-15 05:33:00', 'img/lot-1.jpg', 10990, 400, 1, 1);
insert into lots(lot_name, lot_date_end, lot_img_url, lot_value, lot_step, user_id, category_id) values ('DC Ply Mens 2016/2017 Snowboard', '2018-03-15 15:33:00', 'img/lot-2.jpg', 159999, 500, 2, 1);
insert into lots(lot_name, lot_date_end, lot_img_url, lot_value, lot_step, user_id, category_id) values ('Крепления Union Contact Pro 2015 года размер L/XL', '2017-12-15 05:33:00', 'img/lot-3.jpg', 8000, 400, 2, 2);

insert into bets(lot_id, bet_value, user_id) values (1, 12590, 1);
insert into bets(lot_id, bet_value, user_id) values (2, 13590, 2);

/** Select all categories **/
select * from categories;

/** Count total bets for each open lot */
select l.lot_id,l.lot_name,l.lot_value,l.lot_img_url,l.category_id,IFNULL(count(b.bet_value),0)
  as total_bets from lots l LEFT JOIN bets b ON l.lot_id=b.lot_id WHERE l.lot_date_end > b.bet_date_add GROUP BY l.lot_id ASC;

/** Select lot by id and show its category name **/
select l.lot_id,l.lot_name,l.lot_date_add,l.lot_date_end,l.lot_description,l.lot_img_url,l.lot_value,l.lot_step,l.user_id,l.category_id,c.category_name as lot_category from lots l JOIN
  categories c ON l.category_id=c.category_id WHERE l.lot_id=2;

/** Update lot name by its id */
update lots set lot_name='2017 Rossignol District Snowboard awesome' where lots.lot_id=1;

/** Get bets by lot_id and sort by date */
select * from bets WHERE lot_id=1 ORDER BY bet_date_add DESC;




