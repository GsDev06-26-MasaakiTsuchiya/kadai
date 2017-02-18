<?php
session_start();
include("../function/function.php");
login_check();
$interview_id=$_GET["interview_id"];
$interviewee_name = $_GET["interviewee_name"];
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//interview情報取得
$stmt = $pdo->prepare("SELECT * FROM interview where id=:id");
$stmt->bindValue(':id',$interview_id, PDO::PARAM_INT);
$status = $stmt->execute();



if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  $res = $stmt->fetch();
  }

$interview_time_int = strtotime($res["interview_time"]);

// var_dump($interview_time_int);

//面接者リスト取得（selected用)
$stmt = $pdo->prepare("SELECT * FROM interviewer_list where interview_id=:interview_id");
$stmt->bindValue(':interview_id',$res["id"], PDO::PARAM_INT);
$status = $stmt->execute();
$interviewer_list = array();
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
array_push($interviewer_list,$result["interviewer_id"]);
  }
}

// var_dump($interviewer_list);
//
// exit;


//全面接者リスト情報取得(optionタグ用)

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
    if(in_array($result["id"],$interviewer_list)){
      $view .='<option value="'.h($result["id"]).'" selected>'.h($result["interviewer_name"]).'</option>';
    }else{
      $view .='<option value="'.h($result["id"]).'">'.h($result["interviewer_name"]).'</option>';
    }
  }
}
//
// $stmt = $pdo->prepare("SELECT * FROM interviewee_info where id=$interviewee_id");
// $status2 = $stmt->execute();
//
// //３．データ表示
// if($status2==false){
//   //execute（SQL実行時にエラーがある場合）
//   $error = $stmt->errorInfo();
//   exit("ErrorQuery:".$error[2]);
// }else{
//   $res = $stmt->fetch();
//   }



?>

<html lang="ja">
<head>
<meta charset="utf-8">
<title>interview_setting</title>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/common.css">
</head>
<body>
<?php include("../template/nav.html") ?>
<form class="form-group form-horizontal" action="interview_detail_select_update.php" method="post">
  <label for="interviewee_name">候補者名</label><p class="form-control-static"><?= h($interviewee_name); ?></p>
  <label for="interview_type">選考ステップ</label>
  <select class="form-control" name="interview_type">
    <option value="0"<?php if($res["interview_type"]==0){echo "selected";} ?>>書類選考</option>
    <option value="1"<?php if($res["interview_type"]==1){echo "selected";} ?>>1次面接</option>
    <option value="2"<?php if($res["interview_type"]==2){echo "selected";} ?>>2次面接</option>
    <option value="3"<?php if($res["interview_type"]==3){echo "selected";} ?>>3次面接</option>
  </select>
  <label for="interview_time">選考日</label><input class="form-control" type="datetime-local" name="interview_time" value="<?= $res["interview_time"] ?>">

  <label for="interviewer_id">選考担当者</label>
  <select class="form-control" name="interviewer_id[]" multiple>
    <?= $view ?>
  </select>
  <div class="text-center">
    <input type="hidden" name="id" value="<?=$interview_id?>">
    <input class="btn btn-default" type="submit" value="修正">
  </div>
</form>

<?php include("../template/footer.html") ?>

</body>
</html>
