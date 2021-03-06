<?php
session_start();
include("../function/function.php");
login_check();

$id = $_SESSION["interviewer_id"];
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM interviewer_info where id=:id");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  $res = $stmt->fetch();
}




 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>interviewer_detail</title>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/common.css">
</head>
<body>
<?php include("../template/nav.html") ?>
<form class="form-group form-horizontal" action="interviewer_update.php" method="post">
  <label for="interviewer_name">名前</label><input class="form-control" type="text" name="interviewer_name" value="<?=$res["interviewer_name"]?>">
  <label for="lid">id</label><input class="form-control" type="text" name="lid" value="<?=$res["lid"]?>">
  <label for="lpw">pw</label><input class="form-control" type="text" name="lpw" value="<?=$res["lpw"]?>">
  <input type="hidden" name="id" value="<?=$res["id"]?>">
  <div class="text-center">
    <input class="btn btn-default" type="submit" value="更新">
  </div>
</form>

<?php include("../template/footer.html") ?>

</body>
</html>
