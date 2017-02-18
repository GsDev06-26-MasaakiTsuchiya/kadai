<?php
//1. POSTデータ取得

$interviewee_name =  $_POST["interviewee_name"];
$interviewee_name_kana =  $_POST["interviewee_name_kana"];
$birthday = $_POST["birthday"];
$devision_name = $_POST["devision_name"];
$position_name = $_POST["position_name"];
$position_title = $_POST["position_title"];


//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());//errorが出たら処理を止めてエラーを表示
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO interviewee_info(id, interviewee_name, interviewee_name_kana, birthday, devision_name, position_name, position_title,
indate )VALUES(NULL, :interviewee_name, :interviewee_name_kana, :birthday, :devision_name, :position_name, :position_title, sysdate())");
$stmt->bindValue(':interviewee_name', $interviewee_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':interviewee_name_kana', $interviewee_name_kana, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':devision_name', $devision_name, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':position_name', $position_name, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':position_title', $position_title, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: interviewee_select.php");//location: のあとに必ずスペースが入る
  exit;

}
?>
