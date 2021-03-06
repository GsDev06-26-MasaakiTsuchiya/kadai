<?php
session_start();
include("../function/function.php");

login_check();

//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM interviewee_info");
$status = $stmt->execute();

//３．データ表示
$view="";
$view2="";
$data_s = [];
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .='<tr>';
    $view .='<td><span class="glyphicon glyphicon-user"><span>';
    $view .='<td>'.h($result["interviewee_name"]).'/'.h($result["interviewee_name_kana"]).'</td>';
    $view .='<td>/'.h($result["devision_name"]).'/'.h($result["position_name"]).'/'.h($result["position_title"]).'</td>';
    // $view .='<td><a href="input_data.php?target_inteviewee='.h($result["id"]).'" class="btn btn-xs btn-info">評価入力</a>&nbsp;<a href="output_data.php?target_inteviewee='.h($result["id"]).'" class="btn btn-xs btn-primary">評価閲覧</a></td>';
    $view .='<td><a href="interview_detail_select.php?target_interviewee_id='.h($result["id"]).'" class="btn btn-xs btn-info">選考設定</a>&nbsp;<a href="interviewee_detail.php?target_interviewee_id='.h($result["id"]).'&target_interviewee_name='.h($result["interviewee_name"]).'" class="btn btn-xs btn-primary">情報更新</a>&nbsp;<a href="interviewee_delete.php?target_interviewee_id='.h($result["id"]).'&target_interviewee_name='.h($result["interviewee_name"]).'" class="btn btn-xs btn-danger">削除</a></td>';
    $view .='</tr>';

  }
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
<style>

html,body{
  height: 100%;
}
.container{
  margin-bottom:20px;
}


</style>
</head>
<body>
<?php include("../template/nav.html") ?>

<h3 class="text-center">候補者管理</h3>
<div class="container">
<div class="row">
  <div class="col-sm-offset-9 col-sm-2 text-center"><a class="btn btn-sm btn-default" href="interviewee_setting.php">新規登録</a></div>
  </div>
</div>

<!-- <div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <form id="form" class="text-center" class="form-group" action="" method="post">
          </form>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10 text-center">
        <input class="btn btn-default" type="button" id="to_input_data" value="評価入力"><input class="btn btn-info" type="button" id="to_output_data" value="結果表示">
    </div>
    <div class="col-sm-1"></div>
  </div>
</div> -->


<div class="container">
  <table class="table table-hover">
    <?=$view?>
  </table>
</div>
<?php include("../template/footer.html") ?>
<!-- <script>
  $(function(){
      $('#to_output_data').click(function() {
          $('#form').attr('action', 'output_data.php');
          $('#form').submit();
      });
      $('#to_input_data').click(function() {
          $('#form').attr('action', 'input_data.php');
          $('#form').submit();
      });
  }); -->
</script>
</body>
</html>
