<?php

session_start();
include("../function/function.php");
login_check();

//1. POSTデータ取得



$_SESSION["interview_date_time_reserves"] = $_POST["interview_date_time_reserves"];


//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$view_interviewer_name ="";
foreach($_SESSION["interviewer_id"] as $interviewer_id){
  $stmt = $pdo->prepare("SELECT interviewer_name FROM interviewer_info where id = :interviewer_id");
  $stmt->bindValue(':interviewer_id', $interviewer_id, PDO::PARAM_INT);
  $status = $stmt->execute();
  //３．データ表示
  if($status==false){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
  }else{

      $res_interviewer = $stmt->fetch();
      $view_interviewer_name .= $res_interviewer["interviewer_name"];
      $view_interviewer_name .= '&emsp;';
    }
}

$stmt = $pdo->prepare("SELECT * FROM interview INNER JOIN interviewee_info ON interview.interviewee_id = interviewee_info.id WHERE interview.id= :interview_id");
$stmt->bindValue(':interview_id', $_SESSION["interview_id"], PDO::PARAM_INT);
$status2 = $stmt->execute();

//３．データ表示
if($status2==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  $res_interviewee = $stmt->fetch();
  }


$interview_type_str = interview_type($res_interviewee["interview_type"]);//面接のステージ

$html_title = '無料から使えるクラウド採用管理、面接システム Smart Interview';
?>
<!DOCTYPE html>
<html>
<head>
<?php include("../template/head.php") ?>
<style>
.container{
  margin-top:30px;
  margin-bottom:30px;
}

</style>
</head>
<body>
<?php include("../template/nav.php") ?>

<h3 class="text-center">ビデオ面接予約</h3>
<!-- 一覧に戻るボタン -->
<?php include("../template/back_to_interviewee_select.php"); ?>


<div class="container">
<?php $_GET['progress']=3;include("../template/interview_setting_progress.php"); ?>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <form class="form-group form-horizontal" action="video_interview_resetting_update.php" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2" for="interviewee_name">候補者名</label><div class="col-sm-10"><p class="form-control-static"><?= h($res_interviewee["interviewee_name"]); ?></p></div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="interview_type">選考ステップ</label>
          <div class="col-sm-10"><p class="form-control-static"><?= h($interview_type_str); ?></p></div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="interview_type">面接担当者</label>
          <div class="col-sm-10"><p class="form-control-static"><?= $view_interviewer_name ?></p></div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="interviewer">面接日時候補</label>
            <div class="col-sm-10"><p class="form-control-static">
              <ul>
              <?php foreach($_SESSION["interview_date_time_reserves"] as $interview_date_time_reserve):?>
                <li><?php echo $interview_date_time_reserve ;?></li>
              <?php endforeach; ?>
              </ul>
            </div>
        </div>
        <!-- <div class="form-group">
          <label class="control-label col-sm-2" for="toSubmit">送信先</label>
          本人　エージェント　媒体経由　その他
          <div class="col-sm-10"><p class="form-control-static"><?= $view ?></p></div>
        </div> -->
        <div class="form-group hidden">
          <label class="control-label col-sm-2" for="toSubmit">送信先アドレス</label>
          <div class="col-sm-10">
            <input type="text" name="toSubmit_address" value="<?= h($res_interviewee["mail"])?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="mail_text">案内テキスト</label>
          <div class="col-sm-10">
            <span class="help-block">候補者がアクセスするサイトに表示するテキストです。変更が必要な場合は編集してください。</span>
            <textarea name="mail_text" style="width:90%; height:300px;">
　この度は弊社採用募集にご応募いただきましてありがとうございます。選考にあたりましてビデオ面接システムを利用して実施させていただきたいと思います。
手順にしたがって動作環境のテストと面接日程の選択をお願いいたします。
もし動作環境が整わなかったり、ご都合の良い日時がない場合はフォームよりご連絡ください。
よろしくお願い申し上げます。
          </textarea>
          </div>
        </div>
        <div class="text-center">
          <a class="btn btn-default" href="video_interview_resetting_02.php?interview_id=<?php echo($_SESSION["interview_id"]);?>">戻る</a>
          &emsp;<a data-toggle="modal" href="#myModal" class="btn btn-info">確認</a>
          <!-- <input class="btn btn-info" type="submit" value="送信"> -->
        </div>

      <?php
      $body_text="候補者に送信してよろしいでしょうか？
      送信ボタンを押すと候補者にメールが送信されます。";
      $btn_text="送信";
      $_GET['body_text'] = $body_text;
      $_GET['btn_text'] = $btn_text;
      include("../template/submit_my_modal.php");
      ?>
      </form>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>

<?php include("../template/footer.html") ?>
</body>
</html>
