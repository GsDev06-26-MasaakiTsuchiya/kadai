<?php

//UPDATE gs_an_table SET name='ジーズ', email='e@e.com',naiyou='あ' WHERE id =3
//1.POSTでParamを取得
$id                 = $_POST["id"];
$interviewer_name   = $_POST["interviewer_name"];
$lid                = $_POST["lid"];
$lpw                = $_POST["lpw"];

//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE interviewer_info SET interviewer_name=:interviewer_name,lid=:lid,lpw=:lpw WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':interviewer_name', $interviewer_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: my_interviewer_detail.php");
  exit;
}



//3.UPDATE gs_an_table SET ....; で更新(bindValue)
//　基本的にinsert.phpの処理の流れです。




?>
