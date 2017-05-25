<?php
//1. POSTデータ取得 from interview_setting
$interview_type =  $_POST["interview_type"];
$interviewee_id =  $_POST["interviewee_id"];
$interview_time = $_POST["interview_time"];
$interviewer_id = $_POST["interviewer_id"];

$interviewer_id_count = count($interviewer_id);
// var_dump($interviewer_id_count);
// exit;

//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());//errorが出たら処理を止めてエラーを表示
}
//複数のテーブルにデータをインサートするのはどうやるの？

//３．データ登録SQL作成
//interview の設定


try{
$pdo->beginTransaction();//transaction 開始

$stmt = $pdo->prepare("INSERT INTO interview(id, interview_type, interviewee_id, interview_time
 )VALUES(NULL, :interview_type, :interviewee_id, :interview_time)");
$stmt->bindValue(':interview_type', $interview_type, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':interviewee_id', $interviewee_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':interview_time', $interview_time, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();


$interview_id = $pdo->lastInsertId();
$stmt = $pdo->prepare("INSERT INTO interviewer_list(id, interview_id, interviewer_id
)VALUES(NULL, :interview_id, :interviewer_id)");
$stmt->bindParam(':interview_id', $interview_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
for($i = 0 ; $i < $interviewer_id_count; $i++){
  $stmt->bindValue(':interviewer_id', $interviewer_id[$i], PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
  $status2 = $stmt->execute();
}

$pdo->commit();

}catch (PDOException $e) {
  $pdo->rollback();
  echo "とちゅうでとまりました";
  exit;
}
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
}
if($status2==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
}

header("Location: interview_setting.php?target_interviewee_id=".$interviewee_id);//location: のあとに必ずスペースが入る
exit;


?>
