<?php
session_start();
include("functions.php");
ssidCheck();

//1.POSTでParamを取得
$id     = $_POST["id"];
$title   = $_POST["title"];
$article  = $_POST["article"];

//2.DB接続など
$pdo = db_con();

//3.UPDATE gs_cms_table SET ....; で更新(bindValue)
$stmt = $pdo->prepare("UPDATE gs_cms_table SET title=:title,article=:article  WHERE id=:id");
$stmt->bindValue(':title',   $title,   PDO::PARAM_STR);
$stmt->bindValue(':article', $article, PDO::PARAM_STR);
$stmt->bindValue(':id',      $id,      PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  queryError($stmt);
}else{
  header("Location: select.php");
  exit;
}

?>
