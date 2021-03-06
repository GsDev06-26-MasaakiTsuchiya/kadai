<?php
session_start();
include("../function/function.php");

$html_title = '無料から使えるクラウド採用管理、面接システム Smart Interview';
?>
<!DOCTYPE html>
<html>
<head>
<?php include("../template/head_for_interviewee.php") ?>
<style>
h4.pg{
font-size:0.9em;
}
.gray{
  color:#aaa;
}

</style>

</head>
<body>
<?php include("../template/nav_for_interviewee.php") ?>
<div class="container-fruid">
  <div class="row">
      <div class="col-xs-2 hidden-xs"></div>
      <h4 class="col-xs-2 pg text-center gray">
      </h4>
      <div class="col-xs-2 hidden-xs"></div>
  </div>
</div>
<div class="container-fruid">
  <div class="row">
    <div class="col-xs-2 hidden-xs"></div>
    <div class="col-xs-8">
    <h3 class="text-center">再調整通知</h3>
<form action="interview_reset_act.php" method="post">
  <div class="form-group">
    <p>再調整の理由をご選択ください。</p>
    <label class="radio-inline">
    <input type="radio" name="cancel_reason" value="not_work">ウェブ面接機能が動作しない。
    </label>
    <label class="radio-inline">
    <input type="radio" name="cancel_reason" value="not_wish">ウェブ面接を希望しない。
    </label>
    <label class="radio-inline">
    <input type="radio" name="cancel_reason" value="not_available">対応可能な日時がない。
    </label>
  </div>
  <div class="form-group">
    <p>コメント</p>
    <textarea name="comment" style="width:100%;" placeholder="なにか連絡事項があればご入力ください。"></textarea>
  </div>
  <input type="hidden" name="interview_id" value="<?= h($_SESSION["interview_id"]);?>">
  <div class="form-group">
    <div class="text-center">
    <input type="submit" class="btn btn-info" value="送信">
    </div>
  </div>
</form>
</div>
<div class="col-xs-2 hidden-xs"></div>
</div>
<?php include("../template/footer_for_interviewee.html") ?>
</body>
</html>
