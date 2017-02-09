<?php
include("./function/function.php");
$interviewee_id = $_GET["target_inteviewee"];

try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM interviewee_info WHERE id = :interviewee_id");
$stmt->bindValue(':interviewee_id',$interviewee_id, PDO::PARAM_INT);
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
    $view .= '<div class="col-sm-5">';
    $view .= '<p class="text-center">'.h($result["interviewee_name_kana"]).'</p>';
    $view .= '<h2 class="text-center">'.h($result["interviewee_name"]).'</h2>';
    $view .= '</div>';
    $view .= '<div class="col-sm-5">';
    $view .= '<table class="table table-striped">';
    $view .= '<tr><th class="text-center">面接日時</th><td class="text-center">'.h($result["interview_date"]).'</td></tr>';
    $view .= '<tr><th class="text-center">誕生日</th><td class="text-center">'.h($result["birthday"]).'</td></tr>';
    // $view .= '<tr><th class="text-center">ステージ</th><td class="text-center">'.h($result["stage"]).'</td></tr>';
    $view .= '<tr><th class="text-center">部門</th><td class="text-center">'.h($result["devision_name"]).'</td></tr>';
    $view .= '<tr><th class="text-center">職種</th><td class="text-center">'.h($result["position_name"]).'</td></tr>';
    $view .= '<tr><th class="text-center">タイトル</th><td class="text-center">'.h($result["position_title"]).'</td></tr>';
    $view .= '</table>';
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
<?php include("./template/nav.html") ?>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
      <?=$view?>
    <div class="col-sm-1"></div>
  </div>
</div>
<div class="container">
  <h2 class="text-center form_title">面接結果入力フォーム</h2>
  <div class="row">

  <form method="post" action="insert.php">
    <input type="hidden" name="interviewee_id" value="<?= $interviewee_id ?>">

    <div class="form-group item_name item">
      <div class="row">
        <div class="col-sm-6 hidden-xs"></div>
          <div class="col-sm-2">
            <label id="interviewer" for="interviewer_name">interviewer</label>
          </div>
          <div class="col-sm-3">
            <select class="form-control" name="interviewer_name">
              <option value="前田　日明">前田　日明</option>
              <option value="高田　延彦">高田　延彦</option>
              <option value="山崎　一夫">山崎　一夫</option>
              <option value="藤原　喜明">藤原　喜明</option>
              <option value="船木　誠勝">船木　誠勝</option>
              <option value="鈴木　みのる">鈴木　みのる</option>
            </select>
          </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>


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
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_0">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_0"></textarea></div>
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
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_1">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_1"></textarea></div>
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
                <select class="form-control" name="score_2">
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_2">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_2"></textarea></div>
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
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_3">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_3"></textarea></div>
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
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_4">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_4"></textarea></div>
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
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
              </div>
          </div>
        </div>
        <div class="form-group col-sm-8">
          <div class="row">
              <div class="col-sm-2"><label for="qualitative_5">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="qualitative_5"></textarea></div>
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
              <div class="col-sm-2"><label for="comment">comment</label></div><div class="col-sm-10"><textarea class="form-control" name="comment"></textarea></div>
          </div>
        </div>
        <div class="col-sm-1 hidden-xs"></div>
      </div>
    </div>


<!-- koomadde -->

    <!-- <div class="form-group item_0">
    <label for="score_0">能力・スキル</label><input class="form-control" type="number" min="0" max="10" name="score_0">
    </div>
    <div class="form-group item_0">
    <label for="qualitative_0">能力・スキル定性評価</label><textarea class="form-control" name="qualitative_0"></textarea>
    </div>

    <div class="form-group item_1">
    <label for="score_1">協調性</label><input class="form-control" type="number" min="0" max="10" name="score_1">
    </div>
    <div class="form-group item_1">
    <label for="qualitative_1">協調性定性評価</label><textarea class="form-control" name="qualitative_1"></textarea>
    </div>

    <div class="form-group item_2">
    <label for="score_2">コミュニケーション能力</label><input class="form-control" type="number" min="0" max="10" name="score_2">
    </div>
    <div class="form-group item_2">
    <label for="qualitative_2">コミュニケーション能力定性評価</label><textarea class="form-control" name="qualitative_2"></textarea>
    </div>

    <div class="form-group item_3">
    <label for="score_3">積極性</label><input class="form-control" type="number" min="0" max="10" name="score_3">
    </div>
    <div class="form-group item_3">
    <label for="qualitative_3">積極性定性評価</label><textarea class="form-control" name="qualitative_3"></textarea>
    </div>

    <div class="form-group item_4">
    <label for="score_4">モラル・性格面</label><input class="form-control" type="number" min="0" max="10" name="score_4">
    </div>
    <div class="form-group item_4">
    <label for="qualitative_4">スキル定性評価</label><textarea class="form-control" name="qualitative_4"></textarea>
    </div>

    <div class="form-group item_5">
    <label for="score_5">定着度</label><input class="form-control" type="number" min="0" max="10" name="score_5">
    </div>
    <div class="form-group item_5">
    <label for="qualitative_5">定着度定性評価</label><textarea class="form-control" name="qualitative_5"></textarea>
    </div> -->
    <div class="submit_btn text-center">
      <input class="btn btn-default btn-lg" type="submit" name="" value="確定">
    </div>
  </form>
  </div>
</div>
<?php include("./template/footer.html") ?>
</body>

</html>
