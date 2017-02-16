<?php
session_start();
include("functions.php");
login_check();
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="user_list_view.php">ユーザー一覧</a></div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>User</legend>
     <label>name:<input type="text" name="name"></label><br>
     <label>id：<input type="text" name="lid"></label><br>
     <label>pw：<input type="text" name="lpw"></label><br>
     <label>管理者：
       <select name="kanri_flg">
         <option value="0">一般</option>
         <option value="1">管理者</option>
       </select>
     <label>使用中：
       <select name="life_flg">
         <option value="0">使用中</option>
         <option value="1">使用しなくなった</option>
       </select>
    </fieldset>
        <input type="submit" value="登録">
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
