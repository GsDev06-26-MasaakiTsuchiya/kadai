<?php
session_start();
include("../function/function.php");
login_check();

$id = $_GET["target_interviewee_id"];
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM interviewee_info where id=:id");
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
<html lang="ja">
<head>
<meta charset="utf-8">
<title>interview_rader_chart > input</title>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/common.css">
</head>
<body>
<?php include("../template/nav.html") ?>
<div class="container">
  <div class="row">
    <div class="col-offset-sm-1 col-sm-10">
      <h3 class="text-center">候補者登録</h3>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-10 col-offset-sm-1">
      <form class="form-horizontal" action="interviewee_update.php" method="post">
        <div class="form-group">
        <label class="control-label col-sm-2" for="interviewee_name">候補者名</label><div class="col-sm-10"><input class="form-control" type="text" name="interviewee_name" value="<?=$res["interviewee_name"]?>"></div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="interviewee_name_kana">カナ</label><div class="col-sm-10"><input class="form-control" type="text" name="interviewee_name_kana" value="<?=$res["interviewee_name_kana"]?>"></div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="birthday">誕生日</label><div class="col-sm-10"><input class="form-control" type="date" name="birthday" value="<?=$res["birthday"]?>"></div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="devision_name">部署名</label><div class="col-sm-10"><input class="form-control" type="text" name="devision_name" value="<?=$res["devision_name"]?>"></div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="position_name">職種</label><div class="col-sm-10"><input class="form-control" type="text" name="position_name" value="<?=$res["position_name"]?>"></div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="position_title">タイトル</label><div class="col-sm-10"><input class="form-control" type="text" name="position_title" value="<?=$res["position_title"]?>"></div>
        </div>
        <input type="hidden" name="id" value="<?=$res["id"]?>">
        <div class="text-center">
          <input class="btn btn-default" type="submit" value="更新">
        </div>
      </form>
    </div>
  </div>
</div>

<?php include("../template/footer.html") ?>

</body>
</html>
