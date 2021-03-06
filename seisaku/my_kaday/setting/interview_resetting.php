<?php
session_start();
include("../function/function.php");
login_check();

$_SESSION["interview_id"] = $_GET["interview_id"];

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM interviewer_info");
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
    $view .='<option value="'.h($result["id"]).'">'.h($result["interviewer_name"]).'</option>';
  }
}



$stmt = $pdo->prepare("SELECT * FROM interview INNER JOIN interviewee_info ON interview.interviewee_id = interviewee_info.id WHERE interview.id = :interview_id");
$stmt->bindValue(':interview_id', $_SESSION["interview_id"], PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status2 = $stmt->execute();

//３．データ表示
if($status2==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  $res = $stmt->fetch();
  }


$interview_type_str = interview_type($res["interview_type"]);

$html_title = '無料から使えるクラウド採用管理、面接システム Smart Interview';
?>
<!DOCTYPE html>
<html>
<head>
<?php include("../template/head.php") ?>
<style>
/*html,body{
  height: 100%;
}*/
.container{
  margin-bottom:20px;
}
</style>
</head>
<body>
<?php include("../template/nav.php") ?>

<h3 class="text-center">面接再調整</h3>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <div class="text-right back_to_select">
        <a class="btn btn-default" href="interviewee_select.php">候補者一覧に戻る</a>
      </div>
      <form class="form-group form-horizontal" action="interview_insert.php" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2" for="interviewee_name">候補者名</label><div class="col-sm-10"><p class="form-control-static"><?= h($res["interviewee_name"]); ?></p></div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="interview_type">選考ステップ</label>
          <div class="col-sm-10"><p class="form-control-static"><?= h($interview_type_str); ?></p></div>
        </div>
      </form>
      <div class="text-center">
        <a class="btn btn-info" href="video_interview_resetting_01.php?interview_id=<?= h($_SESSION["interview_id"]); ?>">ビデオ面接予約</a>&emsp;
        <a class="btn btn-primary" href="#" disabled>通常面接予約</a>&emsp;　
        <a class="btn btn-default" href="#" disabled>日程直接入力</a>
      </div>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>

<?php include("../template/footer.html") ?>

</body>
</html>
