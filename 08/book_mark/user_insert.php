<?php
// 入力チェック(受信確認処理追加)
// if(
//   !isset($_POST["name"]) || $_POST["name"]=="" ||
//   !isset($_POST["lid"]) || $_POST["lid"]=="" ||
//   !isset($_POST["kanri-flg"]) || $_POST["kanri-flg"]=="" ||
//   !isset($_POST["life-flg"]) || $_POST["life-flg"]=="" ||
//   !isset($_POST["lpw"]) || $_POST["lpw"]==""){
//   exit('ParamError');
// }

//1. POSTデータ取得
$name   = $_POST["name"];
$lid  = $_POST["lid"];
$lpw = $_POST["lpw"];
$kanri_flg = $_POST["kanri_flg"];
$life_flg = $_POST["life_flg"];

//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_user_table(id, name, lid, lpw, kanri_flg, life_flg)VALUES(NULL, :name, :lid, :lpw, :kanri_flg, :life_flg)");
$stmt->bindValue(':name', $name);
$stmt->bindValue(':lid', $lid);
$stmt->bindValue(':lpw', $lpw);
$stmt->bindValue(':kanri_flg', $kanri_flg);
$stmt->bindValue(':life_flg', $life_flg);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: user_index.php");
  exit;
}
?>
