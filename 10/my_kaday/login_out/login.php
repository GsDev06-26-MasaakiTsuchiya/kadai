<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/common.css">
<title>ログイン</title>
</head>
<body>

<?php include("../template/nav.php") ?>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<div class="container">
  <div class="row">
    <div class="col-sm-8"></div>
    <div class="col-sm-3">
      <form class="form-group form-horizontal"name="form1" action="login_act.php" method="post">
      <label class="label-control col-sm-2" for="lid">ID</label><div class="col-sm-10"><input class="form-control" type="text" name="lid" /></div>
      <label class="label-control col-sm-2" for="lpw">PW</label><div class="col-sm-10"><input class="form-control" type="password" name="lpw" /></div>
      <div class="text-right">
        <input class="btn btn-sm btn-default" type="submit" value="LOGIN" />
      </div>
      </form>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>

<?php include("../template/footer.html") ?>
</body>
</html>
