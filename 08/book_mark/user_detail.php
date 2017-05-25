<?php

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
  <title>ユーザーデータ編集</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>
  <header>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
      <div class="navbar-header"><a class="navbar-brand" href="user_list_view.php">ユーザー一覧</a></div>
    </nav>
  </header>
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
