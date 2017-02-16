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
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<?php include("./template/nav.html"); ?>
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
