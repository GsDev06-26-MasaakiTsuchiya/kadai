<?php
session_start();
include("functions.php");
login_check();

$id = $_GET["id"];
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table where id=:id");
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
  <meta charset="UTF-8">
  <title>ユーザーデータ更新</title>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">


  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>
<?php include("./template/nav.html"); ?>
  <!-- Head[End] -->

  <!-- Main[Start] -->
  <form method="post" action="user_update.php">
    <div class="jumbotron">
     <fieldset>
      <legend>User</legend>
       <label>name:<input type="text" name="name" value="<?= $res["name"] ?>"></label><br>
       <label>id：<input type="text" name="lid" value="<?= $res["lid"] ?>"></label><br>
       <label>pw：<input type="text" name="lpw" value="<?= $res["lpw"] ?>"></label><br>
       <label>管理者：
         <select name="kanri_flg">
           <option <?php if($res["kanri_flg"] == 0){echo "selected";}?> value="0">一般</option>
           <option <?php if($res["kanri_flg"] == 1){echo "selected";}?> value="1">管理者</option>
         </select>
       <label>使用中：
         <select name="life_flg">
           <option <?php if($res["life_flg"] == 0){echo "selected";}?> value="0">使用中</option>
           <option <?php if($res["life_flg"] == 1){echo "selected";}?> value="1">使用しなくなった</option>
         </select>
        <input type="hidden" name="id" value="<?= $res["id"] ?>">
      </fieldset>
          <input type="submit" value="更新">
    </div>
  </form>
  <!-- Main[End] -->


  </body>
</html>
