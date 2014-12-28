// プログラムの定期実行

crontab -l
crontab -e

10 19 * * * /usr/bin/php /var/www/html/tw9/add_tweet.php
15 19 * * * /usr/bin/php /var/www/html/tw10/delete_tweet.php

// データベースのテーブル構造

create table tweet (
	id int(11) not null auto_increment primary key,
	tw_id text,
	tw_screen varchar(16),
	tw_date varchar(25),
	tw_txt text,
);


