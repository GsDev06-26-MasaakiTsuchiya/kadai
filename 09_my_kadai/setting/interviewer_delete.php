<?php

//UPDATE gs_an_table SET name='ジーズ', email='e@e.com',naiyou='あ' WHERE id =3
//1.POSTでParamを取得
$id     = $_GET["id"];

//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("DELETE FROM interviewer_info WHERE id=:id");
$stmt->bindValue(':id', $id);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: interviewer_select.php");
  exit;
}










?>
