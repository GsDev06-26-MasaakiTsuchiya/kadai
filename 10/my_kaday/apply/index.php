<?php
include("../function/function.php");

$pdo = db_con();

$stmt = $pdo->prepare("SELECT * FROM job_post where life_flg = 0 ORDER BY indate DESC limit 5");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // var_dump($result);
    $view .='<a href="../job_post/job_post_view.php?job_post_id='.$result["id"].'">';
    $view .='<tr>';
    $view .='<td><i class="fa fa-id-badge" aria-hidden="true"></i></td>';
    $view .='<td><a href="../job_post/job_post_view.php?job_post_id='.$result["id"].'">'.$result["job_title"].'</a></td>';
    $jd_text_of_head = substr($result["job_description"],0,100);
    $view .= '<td>'.$jd_text_of_head.'</td>';
    $view .= '<td>'.$result["indate"].'</td>';
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
 <script src="https://use.fontawesome.com/16c63c33a4.js"></script>
 <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
 <script src="./js/l-by-l.min.js"></script>
 <link rel="stylesheet" href="../css/common.css">
 <style>
 html,body{
   height: 100%;
 }

 .carousel{
    width:100%;  /*サイズ指定*/
    margin:auto;
 }
 .carousel img{
    width:100%;
 }
 #main{
   background-image: url("img/01.jpg");
        background-size: cover;
        background-position:center center;
        height:100%;
        color:#fff;
        padding-top:200px;
        margin-bottom:50px;
        margin-top:-20px;

}
#main h1{
  text-shadow: 3px 3px 3px #999;
}
#main p{
  text-shadow: 3px 3px 3px #999;
}


 </style>
 </head>
 <body>
   <div class="container-fluid" style="padding:0;">
   <nav class="navbar navbar-default navbar-static-top">
   <div class="navbar-header">
     <button class="navbar-toggle" data-toggle="collapse" data-target=".target">
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
     </button>
     <a class="navbar-brand" href="#">チンチロリン株式会社  -採用情報-</a>
   </div>

   <div class="collapse navbar-collapse target">
     <ul class="nav navbar-nav navbar-right">
         <li><a href="#list">募集一覧</a></li>
     </ul>
   </div>
   </nav>
 </div>
 <div class="container-fluid" id="main">
   <h1 class="text-center">チンチロリン株式会社</h1>
     <p class="text-center">アムロ ふりむかないで宇宙のかなたに 輝く星はアムロ お前の生まれた 故郷だ おぼえているかい 少年の日のことをあたたかい ぬくもりの中で めざめた朝をアムロ ふりむくな
     </p>
 </div>
   <!-- <div class="container-fluid">
     <div class="row">
       <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> -->
      <!-- Indicators -->
      <!-- <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
      </ol> -->

      <!-- Wrapper for slides -->
      <!-- <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="img/01.jpg" alt="photo1">
          <div class="carousel-caption">
            写真1
          </div>
        </div>
        <div class="item">
          <img src="img/02.jpg" alt="photo2">
          <div class="carousel-caption">
            写真2
          </div>
        </div>
        <div class="item">
          <img src="img/03.jpg" alt="photo3">
          <div class="carousel-caption">
            写真3
          </div>
        </div>
        ...
      </div> -->

      <!-- Controls -->
      <!-- <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</div> -->
<h2 class="text-center text-info" id="list">募集一覧</h2>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
       <table class="table table-responsive">
         <?=$view?>
       </table>
    </div>
    <div class="col-sm-2"></div>
  </div>
 </div>
 </body>
 <script>
 $(function(){
   $('.carousel').lbyl({
    content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce iaculis a quam a pellentesque. Proin maximus, nulla non molestie scelerisque, ligula purus lacinia massa, et dapibus quam mi at mi.",
    speed: 10, //time between each new letter being added
    type: 'show', // 'show' or 'fade'
    fadeSpeed: 500, // Only relevant when the 'type' is set to 'fade'
    finished: function(){ console.log('finished') } // Finished Callback
    });

 });

 </script>
</html>
