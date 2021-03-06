<?php
session_start();
include("../function/function.php");
login_check();
//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成 該当の候補者情報の抽出
$stmt = $pdo->prepare("SELECT * FROM job_post");
$status = $stmt->execute();

$view = "";
$jq_i = "";
//３．データ表示
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td><span class="glyphicon glyphicon-duplicate"></span></td>';
    $view .= '<td>'.h($result["job_title"]).'</td>';
    $jd_text_of_head = substr($result["job_description"],0,50);
    $view .= '<td>'.$jd_text_of_head.'</td>';
    $view .= '<td>';
    $view .= '<a class="btn btn-sm btn-info" href="job_post_view.php?job_post_id='.$result["id"].'">確認</a> <a class="btn btn-sm btn-primary" href="job_post_detail.php?job_post_id='.$result["id"].'">修正</a> <a class="btn btn-sm btn-danger" href="job_post_delete.php?job_post_id='.$result["id"].'">削除</a>';
    if($result["life_flg"]==0){
      $view .=' <button class="btn btn-sm btn-success" id="close_'.$result["id"].'">掲載中</button>';
    }else{
      $view .=' <button class="btn btn-sm btn-warning" id="open_'.$result["id"].'">休止中</button>';
    }
    $view .= '</td>';
    $view .= '</tr>';
    $jq_i .= '$("#close_'.$result["id"].'").click(function(){';
    $jq_i .=  '$.ajax({';
    $jq_i .=     'type:"post",';
    $jq_i .=     'url: "stop_start.php?job_post_id='.$result["id"].'",';
    $jq_i .=     'data: {';
    $jq_i .=       '"life_flg": 1 ';
    $jq_i .=     '},';
    $jq_i .=     'success: function(j_data){';
    $jq_i .=       '$("#close_'.$result["id"].'").removeClass("btn-success").addClass("btn-warning").text("休止中").attr("id","open_'.$result["id"].'");';
    $jq_i .=        'console.log(j_data);';
    $jq_i .=     '}';
    $jq_i .=   '});';
    $jq_i .= '});';

    $jq_i .= '$("#open_'.$result["id"].'").click(function(){';
    $jq_i .=  '$.ajax({';
    $jq_i .=     'type:"post",';
    $jq_i .=     'url: "stop_start.php?job_post_id='.$result["id"].'",';
    $jq_i .=     'data: {';
    $jq_i .=       '"life_flg": 0 ';
    $jq_i .=     '},';
    $jq_i .=     'success: function(j_data){';
    $jq_i .=       '$("#open_'.$result["id"].'").removeClass("btn-warning").addClass("btn-success").text("掲載中").attr("id","close_'.$result["id"].'");';
    $jq_i .=        'console.log(j_data);';
    $jq_i .=     '}';
    $jq_i .=   '});';
    $jq_i .= '});';




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

.container{
  margin-bottom:20px;
}


</style>
</head>
<body>
<?php include("../template/nav.php") ?>

<h3 class="text-center">選考設定</h3>
<div class="container">
<div class="row">
  <div class="col-sm-offset-9 col-sm-2 text-center"><a class="btn btn-sm btn-default" href="job_post_input.php">新規登録</a></div>
  </div>
</div>
<div class="container">
  <table class="table table-hover">
    <tr><th></th><th>jobtitle</th><th>summary</th><th>処理</th><tr>
    <?=$view?>
  </table>
</div>
<?php include("../template/footer.html") ?>

</body>
<script>
$(function(){

  <?=$jq_i?>
  //求人を休止する
  // $('#close_id ').click(function(){
  //   $.ajax({
  //     type:"post",
  //     url: "stop_start.php?job_post_id=",
  //     data: {
  //       "life_flg":"1"
  //     },
  //     success: function(j_data){
  //       $("#close").attr('id','open').removeClass('btn-success').addClass('btn-warning').text('休止中');
  //     }
  //   });
  // });
  // //求人を再開する
  // $('#open_id').click(function(){
  //   $.ajax({
  //     type:"post",
  //     url: "stop_start.php",
  //     data: {
  //       "life_flg":"0"
  //     },
  //     success: function(j_data){
  //       $("#open").attr('id','close').removeClass('btn-warning').addClass('btn-success').text('掲載中');
  //     }
  //   });
  // });

});
</script>
</html>
