<?php

session_start();
include("functions.php");
login_check();
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr id="user_'.$result["id"].'">';
    $view .= '<td>'.$result["name"].'</td><td>'.$result["lid"].'</td><td>'.'<a href="user_detail.php?id='.$result["id"].'">更新</a>/<span class="deleteLink" data-id="'.$result["id"].'">削除</span></td>';

    // <a href="user_delete.php?id='.$result["id"].'">削除</a></td>';
    $view .= "</tr>";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー一覧</title>
<link rel="stylesheet" href="css/range.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<style>
.deleteLink {
    color: blue;
    cursor: pointer;
}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="user_index.php">ユーザー登録</a>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
  <table class="table table-striped">
    <tr><th>名前</th><th>id<th>更新・削除</th></tr>
      <?=$view?>
  </table>
  </div>
</div>
<!-- Main[End] -->
<script>

$(function(){
  $(.deleteLink).click(function(){
    if(confirm("削除してもよろしいですか?")){
      $.post('user_delete.php',{
        id: $(this).data('id')
      },function(rs){
        $('#user_' +rs).fadeOut(800);
      });
    }

  });


});
</script>

</body>
</html>
