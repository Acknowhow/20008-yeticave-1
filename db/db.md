## on data storage
default form data (like errors, input titles) should be kept separately
for two reasons:
– it is static data
– simply makes it easier to maintain app

Or maybe just integrate them into functions core
## on date format
– It is most comfortable to add current and end date for 
lot in human readable format

– While fetching data from DB it is best to choose 
TIMESTAMP get time result from convertTimeStamp function

## If lot's time runs out
UPDATE must be called on last bet made on this lot
in order to estimate winner. So must consider which 
fields to update. PARTLY **solved**, must
create separate scenario to estimate winner

## MySQL queries 

SELECT b.bet_value,
       unix_timestamp(b.bet_date_add),
       b.user_id,b.bet_is_win,l.lot_name,
       unix_timestamp(l.lot_date_end),
       l.lot_img_url 
FROM bets b LEFT JOIN lots l ON l.lot_id = b.lot_id AND b.user_id=1;

## Estimate winner
SELECT l.lot_id,l.lot_name,
l.lot_date_add,l.lot_date_end,
l.lot_description,l.lot_img_url,
l.lot_value,l.lot_step,
l.user_id,l.category_id,c.category_name 
AS lot_category,IF((UNIX_TIMESTAMP(l.lot_date_end) < UNIX_TIMESTAMP(NOW())),b.user_id,0) FROM lots l
JOIN categories c ON l.category_id=c.category_id INNER JOIN bets b
ORDER BY l.lot_date_add DESC;

## Lot winner
SELECT l.lot_id,l.lot_name,
l.lot_date_add,l.lot_date_end,
l.lot_description,l.lot_img_url,
l.lot_value,l.lot_step,
l.user_id,l.category_id,c.category_name 
AS lot_category,b.user_id AS lot_winner FROM lots l
INNER JOIN categories c ON l.category_id=c.category_id 
JOIN bets b ON UNIX_TIMESTAMP(l.lot_date_end) < UNIX_TIMESTAMP(NOW()) ORDER BY b.bet_date_add DESC LIMIT 1;
 

 
 
 
