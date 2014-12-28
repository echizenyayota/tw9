<?php

// ステータスID、スクリーンネーム、日時、本文をtweetテーブルに格納
require_once("twitteroauth/twitteroauth.php");

$consumerKey = "MYCONSUMERKEY";
$consumerSecret = "MYCONSUMERSECRET";
$accessToken = "MYACCESSTOKEN";
$accessTokenSecret = "MYACCESSTOKENSECRET";

$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);

$request = $twObj->OAuthRequest('https://api.twitter.com/1.1/statuses/user_timeline.json','GET',
    array(
        'count'=>'100',
        'screen_name' => 'echizenya_yota',
        ));
$results = json_decode($request);

if(isset($results) && empty($results->errors)){
    foreach($results as $tweet){
		// データベースの接続
		try {
		 	$dbh = new PDO('mysql:host=localhost;dbname=tweet1;charset=utf8', 'myusername','mypassword');
		} catch(PDOException $e) {
		 	var_dump($e->getMessage());
		 	exit;
		}
		// 処理(データの挿入)
		$stmt = $dbh->prepare("insert into tweet (tw_id, tw_screen, tw_date, tw_txt) values (:tw_id, :tw_screen, :tw_date, :tw_txt)");

		// $tw_idは文字列型
		$stmt->bindParam(":tw_id", $tw_id);
		$stmt->bindParam(":tw_screen", $tw_screen);
		$stmt->bindParam(":tw_date", $tw_date);
		$stmt->bindParam(":tw_txt", $tw_txt);

		$tw_id = $tweet->id;
		$tw_screen = $tweet->user->screen_name;
		$tw_date = date('Y-m-d H:i:s', strtotime($tweet->created_at));
		$tw_txt = $tweet->text;

		$stmt->execute();

		// 最大のステータスIDの番号を取得する
		$sql = "select * from tweet where tw_id >= all (select tw_id from tweet)";
		$stmt2 = $dbh->query($sql);
		$statusid_str = $stmt2->fetchColumn(1);

		$stmt2->execute();

		// 切断
		$dbh = null;

	}
  }else{
	echo "関連したつぶやきがありません。";
 }

$statusid = intval($statusid_str);
echo $statusid;
$type = gettype($statusid);
echo "<br/>";
echo $type;

 ?>



