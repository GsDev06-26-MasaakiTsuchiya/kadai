<?php
session_start();
include("functions.php");
login_check();

//入力チェック(受信確認処理追加)
if(
  !isset($_POST["book_name"]) || $_POST["book_name"]=="" ||
  !isset($_POST["book_url"]) || $_POST["book_url"]=="" ||
  !isset($_POST["comment"]) || $_POST["comment"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$book_name   = $_POST["book_name"];
$book_url  = $_POST["book_url"];
$comment = $_POST["comment"];

//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, book_name, book_url, comment,
indate )VALUES(NULL, :book_name, :book_url, :comment, sysdate())");
$stmt->bindValue(':book_name', $book_name);
$stmt->bindValue(':book_url', $book_url);
$stmt->bindValue(':comment', $comment);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: bm_index.php");
  exit;
}
?>
