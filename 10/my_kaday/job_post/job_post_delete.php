<?php
session_start();
include("../function/function.php");
login_check();

$job_post_id     = $_GET["job_post_id"];

//2. DB接続します(エラー処理追加)
$pdo= db_con();


//３．データ登録SQL作成
$stmt = $pdo->prepare("DELETE FROM job_post WHERE id=:id");
$stmt->bindValue(':id', $job_post_id);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: job_post_select.php");
  exit;
}
