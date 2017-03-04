<?php
session_start();
include("../function/function.php");
login_check();
if($_SESSION){
$interviewer_name = $_SESSION["interviewer_name"];
}else{
  header("Location: ../login_out/login.php");
  exit;
}



?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/common.css">
  <script src="https://skyway.io/dist/0.3/peer.min.js"></script>
  <script src="https://skyway.io/dist/multiparty.min.js"></script>

  <style> video { width:300px; } </style>

</head>
<body>
  <div class="container">
    <div class="row" id="streams">
      <div class="col-sm-4" id="video_0">
      </div>
      <div class="col-sm-4" id="video_1">
      </div>
      <div class="col-sm-4" id="video_2">
      </div>
    </div>
    <div class="row" id="streams">
      <div class="col-sm-4" id="video_3">
      </div>
      <div class="col-sm-4" id="video_4">
      </div>
      <div class="col-sm-4" id="video_5">
      </div>
    </div>
  </div>
<script>

  // MultiParty インスタンスを生成
  multiparty = new MultiParty( {
    "key": "68ea836f-c243-4b68-b5c9-ee68fcf48c97",  /* SkyWay keyを指定 */
    "id" : "<?=$interviewer_name?>"
  });
  var i = 0;

    // var streams = $("#streams");
  multiparty.on('my_ms', function(video) {
    // 自分のvideoを表示
    var vNode = MultiParty.util.createVideoNode(video);
    $(vNode).appendTo('#video_' + i);
    i++;
  }).on('peer_ms', function(video) {
    // peerのvideoを表示1
    var vNode = MultiParty.util.createVideoNode(video);
    $(vNode).appendTo('#video_' + i);
    i++;
  }).on('ms_close', function(peer_id) {
    // peerが切れたら、対象のvideoノードを削除する
    $("#"+peer_id).remove();
  });

  // サーバとpeerに接続
  multiparty.start()

</script>
</body>
</html>
