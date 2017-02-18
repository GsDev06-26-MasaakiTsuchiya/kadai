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
$stmt = $pdo->prepare("SELECT * FROM interviewer_list,interview where interviewer_list.interviewer_id = :id AND interview.id=interviewer_list.interview_id");
$stmt->bindValue(':id',$_SESSION["interviewer_id"],PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$view="";
$interview_type = array("書類選考","1次面接","2次面接","3次面接");
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // var_dump($result);
    $view .='<tr>';
    $view .='<td><span class="glyphicon glyphicon-user"><span>';
    // interviewee名前抽出
        $stmt2 = $pdo->prepare("SELECT interviewee_name FROM interviewee_info where id=:id");
        $stmt2->bindValue(':id',$result["interviewee_id"],PDO::PARAM_INT);
        $status2 = $stmt2->execute();
        if($status2==false){
          //execute（SQL実行時にエラーがある場合）
          $error2 = $stmt2->errorInfo();
          exit("ErrorQuery:".$error2[2]);
        }else{
          $res = $stmt2->fetch();
        }
    $view .='<td>'.h($res["interviewee_name"]).'</td>';
    $view .='<td>'.$interview_type[h($result["interview_type"])].'</td>';
    $view .='<td>'.h($result["interview_time"]).'</td>';
    //結果入力済みか確認
        $stmt3 = $pdo->prepare("SELECT * FROM interview_result where interview_id=:interview_id");
        $stmt3->bindValue(':interview_id',$result["interview_id"],PDO::PARAM_INT);
        $status3 = $stmt3->execute();
        if($status3==false){
          //execute（SQL実行時にエラーがある場合）
          $error3 = $stmt3->errorInfo();
          exit("ErrorQuery:".$error3[2]);
        }else{
          $res2 = $stmt3->fetch();
        }
        // var_dump($res2);
        // exit;
    if(!$res2){
    $view .='<td><a href="input_data.php?interview_id='.h($result["interview_id"]).'&interviewee_id='.h($result["interviewee_id"]).'" class="btn btn-xs btn-info">入力</a></td>';
    }else{
    $view .='<td><a href="input_data.php?interview_id='.h($result["interview_id"]).'&interviewee_id='.h($result["interviewee_id"]).'" class="btn btn-xs btn-primary">修正</a></td>';
    }
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



</style>
</head>
<body>
<?php include("../template/nav.html") ?>

<h3 class="text-center">評価入力</h3>

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
