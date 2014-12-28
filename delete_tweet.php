<?php
	// ステータスID、スクリーンネーム、日時、本文をtweetテーブルから20件削除
	// データベースへの接続
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=tweet1;charset=utf8', 'myusername','mypassword');
	} catch(PDOException $e) {
		var_dump($e->getMessage());
		exit;
	}
	// 処理（20件のレコードを削除）
	$stmt = $dbh->prepare("delete from tweet order by tw_id asc limit 20;");
	$stmt->execute();
	$dbh = null;

	echo "done";

?>

