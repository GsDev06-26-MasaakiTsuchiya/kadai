<?php
session_start();
include("../function/function.php");
login_check();
$interview_id = $_GET["interview_id"];
$interviewee_id = $_GET["interviewee_id"];
$interview_type = array("書類選考","1次面接","2次面接","3次面接");


$pdo = db_con();
// ２．データ登録SQL作成

$stmt = $pdo->prepare("SELECT * FROM interview_result WHERE interview_id = :interview_id AND interviewer_id = :interviewer_id");
$stmt->bindValue(':interview_id',$interview_id, PDO::PARAM_INT);
$stmt->bindValue(':interviewer_id',$_SESSION["interviewer_id"], PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  $res_interview_result = $stmt->fetch();

}

$stmt2 = $pdo->prepare("SELECT interviewee_info.interviewee_name,interviewee_info.interviewee_name_kana,interviewee_info.birthday,job_post.job_title FROM interviewee_info, job_post WHERE interviewee_info.id =:interviewee_id AND interviewee_info.job_post_id = job_post.id");
$stmt2->bindValue(':interviewee_id',$interviewee_id, PDO::PARAM_INT);
$status2 = $stmt2->execute();

if($status2==false){
  //execute（SQL実行時にエラーがある場合）
  $error2 = $stmt2->errorInfo();
  exit("ErrorQuery:".$error2[2]);
}else{
  $res_interviewee_info = $stmt2->fetch();

}



$stmt3 = $pdo->prepare("SELECT * FROM interview WHERE id =:interview_id");
$stmt3->bindValue(':interview_id',$interview_id, PDO::PARAM_INT);

$status3 = $stmt3->execute();

if($status3==false){
  //execute（SQL実行時にエラーがある場合）
  $error3 = $stmt3->errorInfo();
  exit("ErrorQuery:".$error3[2]);
}else{
  $res_interview = $stmt3->fetch();
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
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}
body{
  background:#f8f8f8;
}

.div_vertical-middle{
  /*vertical-align: middle;*/
  text-align: center;
  margin-top:auto;
  margin-bottom:auto;
}
div.item{
  margin-bottom:40px;
}
.item_title{
  margin:15px;
}
.form_title{
  margin:30px auto;
}
label{
  font-size: 1.5em;
}
label#inteviewer{
  font-size:1em;
}
</style>
</head>
<body>
<?php include("../template/nav.php") ?>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-5">
    <p class="text-center"><?=h($res_interviewee_info["interviewee_name_kana"])?></p>
    <h2 class="text-center"><?=h($res_interviewee_info["interviewee_name"])?></h2>
    </div>';
    <div class="col-sm-5">
    <table class="table table-striped">
    <tr><th class="text-center">誕生日</th><td class="text-center"><?=h($res_interviewee_info["birthday"])?></td></tr>
    <tr><th class="text-center">職種</th><td class="text-center"><?=h($res_interviewee_info["job_title"])?></td></tr>
    <tr><th class="text-center">選考ステージ</th><td class="text-center"><?=$interview_type[h($res_interview["interview_type"])] ?></td></tr>
    <tr><th class="text-center">面接日時</th><td class="text-center"><?=h($res_interview["interview_date_time"]) ?></td></tr>
    </table>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>
<div class="container">
  <h2 class="text-center form_title">面接結果入力フォーム</h2>
  <div class="row">

  <form method="post" action="input_data_update.php">
    <input type="hidden" name="interviewee_id" value="<?= $interviewee_id ?>">
    <input type="hidden" name="interview_id" value="<?= $interview_id ?>">
    <div class="item_0 item">
      <div class="row item_title">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="col-sm-10"><h3 class="text-center">能力/スキル</h3></div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
      <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="form-group col-sm-2">
          <div class="row">
              <div class="col-sm-6"><label for="score_0">score</label></div>
              <div class="col-sm-6">
                <!-- <input class="form-control" type="number" min="0" max="10" name="score_0"> -->
                <select class="form-control" name="score_0" required>
                  <option value="0" <?php if($res_interview_result["score_0"] == 0){echo"selected";}?>>0</option>
                  <option value="1" <?php if($res_interview_result["score_0"] == 1){echo"selected";}?>>1</option>
                  <option value="2" <?php if($res_interview_result["score_0"] == 2){echo"selected";}?>>2</option>
                  <option value="3" <?php if($res_interview_result["score_0"] == 3){echo"selected";}?>>3</option>
                  <option value="4" <?php if($res_interview_result["score_0"] == 4){echo"selected";}?>>4</option>
                  <option value="5" <?php if($res_interview_result["score_0"] == 5){echo"selected";}?>>5</option>
                  <option value="6" <?php if($res_interview_result["score_0"] == 6){echo"selected";}?>>6</option>
                  <option value="7" <?php if($res_interview_result["score_0"] == 7){echo"selected";}?>>7</option>
                  <option value="8" <?php if($res_interview_result["score_0"] == 8){echo"selected";}?>>8</option>
                  <option value="9" <?php if($res_interview_result["score_0"] == 9){echo"selected";}?>>9</option>
                  <option value="10" <?php if($res_interview_result["score_0"] == 10){echo"selected";}?>>10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_0">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_0"><?=$res_interview_result["qualitative_0"]?></textarea></div>
          </div>
        </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>

    <div class="item_1 item">
      <div class="row item_title">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="col-sm-10"><h3 class="text-center">協調性</h3></div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
      <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="form-group col-sm-2">
          <div class="row">
              <div class="col-sm-6"><label for="score_1">score</label></div>
              <div class="col-sm-6">
                <!-- <input class="form-control" type="number" min="0" max="10" name="score_0"> -->
                <select class="form-control" name="score_1">
                  <option value="0" <?php if($res_interview_result["score_1"] == 0){echo"selected";}?>>0</option>
                  <option value="1" <?php if($res_interview_result["score_1"] == 1){echo"selected";}?>>1</option>
                  <option value="2" <?php if($res_interview_result["score_1"] == 2){echo"selected";}?>>2</option>
                  <option value="3" <?php if($res_interview_result["score_1"] == 3){echo"selected";}?>>3</option>
                  <option value="4" <?php if($res_interview_result["score_1"] == 4){echo"selected";}?>>4</option>
                  <option value="5" <?php if($res_interview_result["score_1"] == 5){echo"selected";}?>>5</option>
                  <option value="6" <?php if($res_interview_result["score_1"] == 6){echo"selected";}?>>6</option>
                  <option value="7" <?php if($res_interview_result["score_1"] == 7){echo"selected";}?>>7</option>
                  <option value="8" <?php if($res_interview_result["score_1"] == 8){echo"selected";}?>>8</option>
                  <option value="9" <?php if($res_interview_result["score_1"] == 9){echo"selected";}?>>9</option>
                  <option value="10" <?php if($res_interview_result["score_1"] == 10){echo"selected";}?>>10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_1">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_1"><?=$res_interview_result["qualitative_1"]?></textarea></div>
          </div>
        </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>

    <div class="item_2 item">
      <div class="row item_title">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="col-sm-10"><h3 class="text-center">コミュニケーション能力</h3></div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
      <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="form-group col-sm-2">
          <div class="row">
              <div class="col-sm-6"><label for="score_2">score</label></div>
              <div class="col-sm-6">
                <!-- <input class="form-control" type="number" min="0" max="10" name="score_0"> -->
                <select class="form-control" name="score_3">
                  <option value="0" <?php if($res_interview_result["score_2"] == 0){echo"selected";}?>>0</option>
                  <option value="1" <?php if($res_interview_result["score_2"] == 1){echo"selected";}?>>1</option>
                  <option value="2" <?php if($res_interview_result["score_2"] == 2){echo"selected";}?>>2</option>
                  <option value="3" <?php if($res_interview_result["score_2"] == 3){echo"selected";}?>>3</option>
                  <option value="4" <?php if($res_interview_result["score_2"] == 4){echo"selected";}?>>4</option>
                  <option value="5" <?php if($res_interview_result["score_2"] == 5){echo"selected";}?>>5</option>
                  <option value="6" <?php if($res_interview_result["score_2"] == 6){echo"selected";}?>>6</option>
                  <option value="7" <?php if($res_interview_result["score_2"] == 7){echo"selected";}?>>7</option>
                  <option value="8" <?php if($res_interview_result["score_2"] == 8){echo"selected";}?>>8</option>
                  <option value="9" <?php if($res_interview_result["score_2"] == 9){echo"selected";}?>>9</option>
                  <option value="10" <?php if($res_interview_result["score_2"] == 10){echo"selected";}?>>10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_2">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_2"><?=$res_interview_result["qualitative_2"]?></textarea></div>
          </div>
        </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>

    <div class="item_3 item">
      <div class="row item_title">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="col-sm-10"><h3 class="text-center">積極性</h3></div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
      <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="form-group col-sm-2">
          <div class="row">
              <div class="col-sm-6"><label for="score_3">score</label></div>
              <div class="col-sm-6">
                <!-- <input class="form-control" type="number" min="0" max="10" name="score_0"> -->
                <select class="form-control" name="score_3">
                  <option value="0" <?php if($res_interview_result["score_3"] == 0){echo"selected";}?>>0</option>
                  <option value="1" <?php if($res_interview_result["score_3"] == 1){echo"selected";}?>>1</option>
                  <option value="2" <?php if($res_interview_result["score_3"] == 2){echo"selected";}?>>2</option>
                  <option value="3" <?php if($res_interview_result["score_3"] == 3){echo"selected";}?>>3</option>
                  <option value="4" <?php if($res_interview_result["score_3"] == 4){echo"selected";}?>>4</option>
                  <option value="5" <?php if($res_interview_result["score_3"] == 5){echo"selected";}?>>5</option>
                  <option value="6" <?php if($res_interview_result["score_3"] == 6){echo"selected";}?>>6</option>
                  <option value="7" <?php if($res_interview_result["score_3"] == 7){echo"selected";}?>>7</option>
                  <option value="8" <?php if($res_interview_result["score_3"] == 8){echo"selected";}?>>8</option>
                  <option value="9" <?php if($res_interview_result["score_3"] == 9){echo"selected";}?>>9</option>
                  <option value="10" <?php if($res_interview_result["score_3"] == 10){echo"selected";}?>>10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_3">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_3"><?=$res_interview_result["qualitative_3"]?></textarea></div>
          </div>
        </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>
    <div class="item_4 item">
      <div class="row item_title">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="col-sm-10"><h3 class="text-center">モラル/性格面</h3></div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
      <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="form-group col-sm-2">
          <div class="row">
              <div class="col-sm-6"><label for="score_4">score</label></div>
              <div class="col-sm-6">
                <!-- <input class="form-control" type="number" min="0" max="10" name="score_0"> -->
                <select class="form-control" name="score_4">
                  <option value="0" <?php if($res_interview_result["score_4"] == 0){echo"selected";}?>>0</option>
                  <option value="1" <?php if($res_interview_result["score_4"] == 1){echo"selected";}?>>1</option>
                  <option value="2" <?php if($res_interview_result["score_4"] == 2){echo"selected";}?>>2</option>
                  <option value="3" <?php if($res_interview_result["score_4"] == 3){echo"selected";}?>>3</option>
                  <option value="4" <?php if($res_interview_result["score_4"] == 4){echo"selected";}?>>4</option>
                  <option value="5" <?php if($res_interview_result["score_4"] == 5){echo"selected";}?>>5</option>
                  <option value="6" <?php if($res_interview_result["score_4"] == 6){echo"selected";}?>>6</option>
                  <option value="7" <?php if($res_interview_result["score_4"] == 7){echo"selected";}?>>7</option>
                  <option value="8" <?php if($res_interview_result["score_4"] == 8){echo"selected";}?>>8</option>
                  <option value="9" <?php if($res_interview_result["score_4"] == 9){echo"selected";}?>>9</option>
                  <option value="10" <?php if($res_interview_result["score_4"] == 10){echo"selected";}?>>10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_4">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_4"><?=$res_interview_result["qualitative_4"]?></textarea></div>
          </div>
        </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>
    <div class="item_5 item">
      <div class="row item_title">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="col-sm-10"><h3 class="text-center">定着度</h3></div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
      <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="form-group col-sm-2">
          <div class="row">
              <div class="col-sm-6"><label for="score_5">score</label></div>
              <div class="col-sm-6">
                <!-- <input class="form-control" type="number" min="0" max="10" name="score_0"> -->
                <select class="form-control" name="score_5">
                  <option value="0" <?php if($res_interview_result["score_5"] == 0){echo"selected";}?>>0</option>
                  <option value="1" <?php if($res_interview_result["score_5"] == 1){echo"selected";}?>>1</option>
                  <option value="2" <?php if($res_interview_result["score_5"] == 2){echo"selected";}?>>2</option>
                  <option value="3" <?php if($res_interview_result["score_5"] == 3){echo"selected";}?>>3</option>
                  <option value="4" <?php if($res_interview_result["score_5"] == 4){echo"selected";}?>>4</option>
                  <option value="5" <?php if($res_interview_result["score_5"] == 5){echo"selected";}?>>5</option>
                  <option value="6" <?php if($res_interview_result["score_5"] == 6){echo"selected";}?>>6</option>
                  <option value="7" <?php if($res_interview_result["score_5"] == 7){echo"selected";}?>>7</option>
                  <option value="8" <?php if($res_interview_result["score_5"] == 8){echo"selected";}?>>8</option>
                  <option value="9" <?php if($res_interview_result["score_5"] == 9){echo"selected";}?>>9</option>
                  <option value="10" <?php if($res_interview_result["score_5"] == 10){echo"selected";}?>>10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_5">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_5"><?=$res_interview_result["qualitative_5"]?></textarea></div>
          </div>
        </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>
    <div class="item_6 item">
      <div class="row item_title">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="col-sm-10"><h3 class="text-center">総評</h3></div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
      <div class="row">
        <div class="col-sm-1 hidden-xs"></div>
        <div class="form-group col-sm-10">
          <div class="row">
              <div class="col-sm-2"><label for="comment">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="comment"><?=$res_interview_result["comment"]?></textarea></div>
          </div>
        </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>
    <input type="hidden" name="interview_result_id" value="<?=$res_interview_result["id"] ?>"><!--$input_resultのidを送信 -->
    <div class="submit_btn text-center">
      <input class="btn btn-default btn-lg" type="submit" value="修正">
    </div>
  </form>
  </div>
</div>
<?php include("../template/footer.html") ?>
</body>

</html>
