<?php
session_start();

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>ログイン</title>
</head>
<body>

<?php include("./template/nav.html"); ?>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<?php
if(!isset($_SESSION["chk_ssid"])||($_SESSION["chk_ssid"])!=session_id()){
echo '
<div class="text-center">
<form name="form1" action="login_act.php" method="post">
ID:<input type="text" name="lid" />
PW:<input type="password" name="lpw" />
<input type="submit" value="LOGIN" />
</form>
</div>

<div class="text-center">
<a href="bm_list_view_p.php" class="btn btn-default">Book Mark Listはこちら</a>
</div>
';
}else{

  echo '<h2 class="text-center">Login中です</h2>';
}

?>



</body>
</html>
