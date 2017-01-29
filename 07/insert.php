<?php
//1. POSTデータ取得

$interviewer_name =  $_POST["interviewer_name"];
$interviewee_name =  $_POST["interviewee_name"];
$score_0 = $_POST["score_0"];
$score_1 = $_POST["score_1"];
$score_2 = $_POST["score_2"];
$score_3 = $_POST["score_3"];
$score_4 = $_POST["score_4"];
$score_5 = $_POST["score_5"];
$qualitative_0 = $_POST["qualitative_0"];
$qualitative_1 = $_POST["qualitative_1"];
$qualitative_2 = $_POST["qualitative_2"];
$qualitative_3 = $_POST["qualitative_3"];
$qualitative_4 = $_POST["qualitative_4"];
$qualitative_5 = $_POST["qualitative_5"];
$comment = $_POST["comment"];



//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());//errorが出たら処理を止めてエラーを表示
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO interview_result(id, interviewer_name, interviewee_name, score_0, score_1, score_2, score_3, score_4, score_5, qualitative_0, qualitative_1, qualitative_2, qualitative_3, qualitative_4, qualitative_5, comment,
indate )VALUES(NULL, :interviewer_name, :interviewee_name, :score_0, :score_1, :score_2, :score_3, :score_4, :score_5, :qualitative_0, :qualitative_1, :qualitative_2, :qualitative_3, :qualitative_4, :qualitative_5, :comment, sysdate())");
$stmt->bindValue(':interviewer_name', $interviewer_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':interviewee_name', $interviewee_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':score_0', $score_0, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':score_1', $score_1, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':score_2', $score_2, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':score_3', $score_3, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':score_4', $score_4, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':score_5', $score_5, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':qualitative_0', $qualitative_0, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':qualitative_1', $qualitative_1, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':qualitative_2', $qualitative_2, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':qualitative_3', $qualitative_3, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':qualitative_4', $qualitative_4, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':qualitative_5', $qualitative_5, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: input_data.php");//location: のあとに必ずスペースが入る
  exit;

}
?>
