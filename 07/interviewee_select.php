<?php

include("./function/function.php");

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
$data_s = [];
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<div class="radio-inline radio_item">';
    $view .= '<input type="radio" id="'.h($result["id"]).'" name="target_inteviewee" value="'.h($result["id"]).'">';
    $view .= '<label for="'.h($result["id"]).' class="form-control">';
    $view .= '<h5 class="text-center">'.h($result["interviewee_name_kana"]).'</h3>';
    $view .= '<h3 class="text-center">'.h($result["interviewee_name"]).'</h3>';
    $view .= '<table class="table table-striped">';
    $view .= '<tr><th class="text-center">面接日時</th><td class="text-center">'.h($result["interview_date"]).'</td></tr>';
    $view .= '<tr><th class="text-center">誕生日</th><td class="text-center">'.h($result["birthday"]).'</td></tr>';
    // $view .= '<tr><th class="text-center">ステージ</th><td class="text-center">'.h($result["stage"]).'</td></tr>';
    $view .= '<tr><th class="text-center">部門</th><td class="text-center">'.h($result["devision_name"]).'</td></tr>';
    $view .= '<tr><th class="text-center">職種</th><td class="text-center">'.h($result["position_name"]).'</td></tr>';
    $view .= '<tr><th class="text-center">タイトル</th><td class="text-center">'.h($result["position_title"]).'</td></tr>';
    $view .= '</table>';
    $view .= '</label>';
    $view .= '</div>';
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
<link rel="stylesheet" href="./css/common.css">
<style>
.radio_item{
  border: 1px solid #000;
}
</style>
</head>
<body>
<?php include("./template/nav.html") ?>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <form id="form" class="text-center" class="form-group" action="" method="post">
        <?=$view?>
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
</div>

<?php include("./template/footer.html") ?>
<script>
  $(function(){
      $('#to_output_data').click(function() {
          $('#form').attr('action', 'output_data.php');
          $('#form').submit();
      });
      $('#to_input_data').click(function() {
          $('#form').attr('action', 'input_data.php');
          $('#form').submit();
      });
  });
</script>
</body>
</html>
