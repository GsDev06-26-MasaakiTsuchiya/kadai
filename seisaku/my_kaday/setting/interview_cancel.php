<?php
//1. POSTデータ取得
session_start();
include("../function/function.php");
include("../sendgrid/sendgrid_send.php");
$interview_id = $_GET["interview_id"];

//2. DB接続します
$pdo = db_con();

//interviewのステージフラグを抽出(メールの送信方法を分けるため。

$stmt_interview_stage = $pdo->prepare("SELECT stage_flg,interviewee_id,interview_date_time FROM interview WHERE id=:id;");
$stmt_interview_stage->bindValue(':id',$interview_id, PDO::PARAM_INT);
$status_interview_stage = $stmt_interview_stage->execute();
if($status_interview_stage==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt_interview_stage->errorInfo();
  exit("ErrorQuery_interview_stage:".$error[2]);
}else{
  $res_interview_stage = $stmt_interview_stage->fetch();
}

try{
$pdo->beginTransaction();//transaction 開始
//最初に対象のinterview_reserve_timeをすべて削除します。
$stmt = $pdo->prepare("DELETE FROM interview_reserve_time WHERE interview_id =:interview_id");
$stmt->bindValue(':interview_id', $interview_id);
$status = $stmt->execute();


//次に対象のinterviewer_listをすべて削除します。
$stmt2 = $pdo->prepare("DELETE FROM interviewer_list WHERE interview_id =:interview_id");
$stmt2->bindValue(':interview_id', $interview_id);
$status2 = $stmt2->execute();

//次に対象のinterviewのstage_flgを6[再調整に]変更します。
$stmt3 = $pdo->prepare("UPDATE interview SET stage_flg = :stage_flg,fix_time = :fix_time WHERE id=:interview_id");
$stmt3->bindValue(':interview_id', $interview_id);
$stmt3->bindValue(':stage_flg', 6);
$stmt3->bindValue(':fix_time', "");
$status3 = $stmt3->execute();

$pdo->commit();
}catch (PDOException $e) {
  $pdo->rollback();
  echo "とちゅうでとまりました";
  exit;
}

//データ登録処理後 errorがあったらとまる
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}
if($status2==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error2 = $stmt2->errorInfo();
  exit("QueryError:".$error2[2]);
}
if($status3==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error3 = $stmt3->errorInfo();
  exit("QueryError:".$error3[2]);
}

//メール送信
$url_path = path_for_mail();
if($res_interview_stage["stage_flg"]==2){//確定前キャンセル 候補者に送る。
  $stmt_interviewee = $pdo->prepare("SELECT * FROM interviewee_info WHERE id=:interviewee_id;");
  $stmt_interviewee->bindValue(':interviewee_id',$res_interview_stage["interviewee_id"], PDO::PARAM_INT);
  $status_interviewee = $stmt_interviewee->execute();
  if($status_interviewee==false){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt_interviewee->errorInfo();
    exit("ErrorQuery_interviewee:".$error[2]);
  }else{
    $res_interviewee = $stmt_interviewee->fetch();
  }
  $to_s = $res_interviewee["mail"];
  $subject_text = "[smartinterview]○○株式会社様より面接日時についてご案内";
  $text = "";
  // $text .= $anchet_message.;
  // $text .= $res_interviewee_mail["interviewee_name"]."様".PHP_EOL;
  $text .= $res_interviewee["interviewee_name"]."様".PHP_EOL;
  $text .= "現在調整中の面接日時について、ご返信いただきました日時で確定できなかったため再調整が必要となりました。".PHP_EOL;
  $text .= "日程について改めて○○株式会社様よりご連絡がありますのでしばらくお待ちください。".PHP_EOL;
  $text .= "どうぞよろしくお願いいたします。".PHP_EOL;
  $res_send = send_email_by_sendgrid($to_s,$subject_text,$text);
  var_dump($res_send);
}else if($res_interview_stage["stage_flg"]==3){//確定後キャンセル
  $stmt_interviewee = $pdo->prepare("SELECT * FROM interviewee_info WHERE id=:interviewee_id;");
  $stmt_interviewee->bindValue(':interviewee_id',$res_interview_stage["interviewee_id"], PDO::PARAM_INT);
  $status_interviewee = $stmt_interviewee->execute();
  if($status_interviewee==false){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt_interviewee->errorInfo();
    exit("ErrorQuery_interviewee:".$error[2]);
  }else{
    $res_interviewee = $stmt_interviewee->fetch();
  }

  //候補者にメール
  $to_interviewee = $res_interviewee["mail"];
  $subject_text_interviewee = "[smartinterview]○○株式会社様より面接日時についてご案内";
  $text_interviewee = "";
  // $text .= $anchet_message.;
  // $text .= $res_interviewee_mail["interviewee_name"]."様".PHP_EOL;
  $text_interviewee .= $res_interviewee["interviewee_name"]."様".PHP_EOL;
  $text_interviewee .= $res_interview_stage["interview_date_time"]."に予定しておりました面接について○○株式会社様のご都合により日程の再調整を行う必要が生じました。".PHP_EOL;
  $text_interviewee .= "新たな日程について改めて○○株式会社様よりご連絡がありますのでしばらくお待ちください。".PHP_EOL;
  $text_interviewee .= "どうぞよろしくお願いいたします。".PHP_EOL;
  $res_send_interviewee = send_email_by_sendgrid($to_interviewee,$subject_text_interviewee,$text_interviewee);
  // var_dump($res_send_interviewee);

  //面接担当者にメール
  $stmt_interviewer = $pdo->prepare("SELECT * FROM interviewer_list INNER JOIN interviewer_info ON interviewer_list.interviewer_id = interviewer_info.id WHERE interviewer_list.interview_id = :interview_id");
  $stmt_interviewer->bindValue(':interview_id',$interview_id, PDO::PARAM_INT);
  $status_interviewer = $stmt_interviewer->execute();
  $mail_interviewer="";
  if($status_interviewer==false){
    $error = $stmt_interviewer->errorInfo();
    exit("ErrorQuery_interviewer:".$error[2]);
  }else{
    //Selectデータの数だけ自動でループしてくれる
    while( $result_interviewer = $stmt_interviewer->fetch(PDO::FETCH_ASSOC)){
      $mail_interviewer .= $result_interviewer["interviewer_mail"].',';

    }
    $mail_interviewer = rtrim($mail_interviewer, ',');
  }

  $to_interviewer = $mail_interviewer;
  $subject_text_interviewer = "[smartinterview]面接再調整のご案内";
  $text_interviewer = "";
  $text_interviewer .= "以下の通り実施を予定しておりました面接が都合により再調整となりました。";
  $text_interviewer .= "候補者名:".$res_interviewee["interviewee_name"].PHP_EOL;
  $text_interviewer .= "日時:".$res_interview_stage["interview_date_time"].PHP_EOL;
  $text_interviewer .= "上記面接は一旦キャンセルとなり、改めて日程の調整を行います。".PHP_EOL;
  $text_interviewer .= "新しい面接日時は決まり次第通知があります。".PHP_EOL;
  $res_send_interviewer = send_email_by_sendgrid($to_interviewer,$subject_text_interviewer,$text_interviewer);
  // var_dump($res_send_interviewer);
}


//リダイレクト
  header("Location: interview_resetting.php?interview_id=".$interview_id);//location: のあとに必ずスペースが入る
  exit;

?>
