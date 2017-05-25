<?php
if($_SERVER['REQUEST_METHOD']=== 'POST'){
// if(isset($_POST["user_name"])){
  $user_name =  $_POST["user_name"];
  $skill_point_0 = $_POST["skill_point_0"];
  $skill_qualitative_0 = $_POST["skill_qualitative_0"];
  $skill_point_1 = $_POST["skill_point_1"];
  $skill_qualitative_1 = $_POST["skill_qualitative_1"];
  $skill_point_2 = $_POST["skill_point_2"];
  $skill_qualitative_2 = $_POST["skill_qualitative_2"];
  $skill_point_3 = $_POST["skill_point_3"];
  $skill_qualitative_3 = $_POST["skill_qualitative_3"];
  $skill_point_4 = $_POST["skill_point_4"];
  $skill_qualitative_4 = $_POST["skill_qualitative_4"];
  $skill_point_5 = $_POST["skill_point_5"];
  $skill_qualitative_5 = $_POST["skill_qualitative_5"];
  $skill_qualitative_6 = $_POST["skill_qualitative_6"];
  // //データ書き込み
  $str = $user_name.",".$skill_point_0.",".$skill_point_1.",".$skill_point_2.",".$skill_point_3.",".$skill_point_4.",".$skill_point_5.",".$skill_qualitative_0.",".$skill_qualitative_1.",".$skill_qualitative_2.",".$skill_qualitative_3.",".$skill_qualitative_4.",".$skill_qualitative_5.",".$skill_qualitative_6;
  $file = fopen("data/data.csv","a");	// ファイル読み込み
  flock($file, LOCK_EX);			// ファイルロック 他の人からアクセスできなくする決め打ち
  fwrite($file, $str."\n");
  flock($file, LOCK_UN);			// ファイルロック解除
  fclose($file);
}
// // else{
//   echo "中身が無いよ";
//   exit();
// }




//データ読み込み

$lines = file('data/data.csv');//data for table

//dataList for chart
$csv = fopen("data/data.csv","r");
$dataList = [];
while($array = fgetcsv($csv)){
  array_push($dataList, $array);
}
$json_data = json_encode($dataList);
?>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>interview_rader_chart > result </title>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="./css/common.css">
<style type="text/css">
  body{
    background:#f8f8f8;
  }
  /*th {
    white-space: nowrap;
  }*/
  td.comment{
    word-wrap:break-word;
  }

  .tableItemTitle{
    width:30%;
  }
  .tableCommentTitle{
    width:60%;
  }
  .tablePointTitle{
    width:10%;
  }
.evaluation_detail{
  margin-bottom: 60px;
}
.info_name{
  margin-bottom:30px;
}

</style>
</head>
<body>
<?php include("./template/nav.html") ?>
<div class="info_name">
<?php include("./template/info_name.html") ?>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-6">
      <canvas id="myChart" width="400" height="400"></canvas>
    </div>
    <div class="col-sm-4">
      <?php include("./template/info_table.html") ?>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>
<h2 class="text-center">評価詳細</h2>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
<?php
include("./function/function.php");
foreach($lines as $line){
  // $line に一行ずつ入る
  $data = explode(',',$line);
  $avarage = round(($data[1] + $data[2]+ $data[3]+ $data[4]+ $data[5]+ $data[6])/6,2) ;
echo '<h3 class="text-center">'.h($data[0]).'</h3>';
echo '<table class="table table-striped evaluation_detail" style="table-layout:fixed;width:100%;">';
echo '<thead><tr><th class="text-center">評価項目</th><th class="text-center">score</th><th class="text-center">comment</th></tr></thead>';
echo '<tbody>';
echo '<tr><td class="text-center">能力・スキル</td><td class="point text-center">'.h($data[1]).'</td><td class="comment">'.h($data[7]).'</td></tr>';
echo '<tr><td class="text-center">協調性</td><td class="point text-center">'.h($data[2]).'</td><td class="comment">'.h($data[8]).'</td></tr>';
echo '<tr><td class="text-center">コミュニケーション能力</td><td class="point text-center">'.h($data[3]).'</td><td class="comment">'.h($data[9]).'</td></tr>';
echo '<tr><td class="text-center">積極性</td><td class="point text-center">'.h($data[4]).'</td><td class="comment">'.h($data[10]).'</td></tr>';
echo '<tr><td class="text-center">モラル・性格面</td><td class="point text-center">'.h($data[5]).'</td><td class="comment">'.h($data[11]).'</td></tr>';
echo '<tr><td class="text-center">定着度</td><td class="point text-center">'.h($data[6]).'</td><td class="comment">'.h($data[12]).'</td></tr>';
echo '<tr><td class="text-center">平均点/総評</td><td class="point text-center">'.h($avarage).'</td><td class="comment">'.h($data[13]).'</td></tr>';
echo '</tbody>';
echo '</table>';
}
?>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>
<?php include("./template/footer.html") ?>
<script>
var ctx = document.getElementById("myChart");
var data_s = JSON.parse('<?php echo $json_data; ?>');//1行ずつ配列にしてそれをまた配列にいれたものをjsonencodeする。それをjson.parseするとよいのでは？
// console.dir(data_s);

var colorSet = [["rgba(255, 99, 132, 0.2)","rgba(255,99,132,1)"],["rgba(54, 162, 235, 0.2)","rgba(54, 162, 235, 1)"],["rgba(255, 206, 86, 0.2)","rgba(255, 206, 86, 1)"],["rgba(75, 192, 192, 0.2)","rgba(75, 192, 192, 1)"],["rgba(153, 102, 255, 0.2)","rgba(153, 102, 255, 1)"],["rgba(255, 159, 64, 0.2)","rgba(255, 159, 64, 1)"]];

var dataSets = [];
for (var i=0; i< data_s.length; i++){
  var p1 = Number(data_s[i][1]);
  var p2 = Number(data_s[i][2]);
  var p3 = Number(data_s[i][3]);
  var p4 = Number(data_s[i][4]);
  var p5 = Number(data_s[i][5]);
  var p6 = Number(data_s[i][6]);
  var points = [p1,p2,p3,p4,p5,p6];
  var obj = { label: data_s[i][0],//名前
              backgroundColor: colorSet[i][0],
              borderColor: colorSet[i][1],
              data: points //配列
            };
  dataSets.push(obj);  //配列 オブジェクトが完成したらpush
  // console.dir(points);
}
console.dir(dataSets);
var myChart = new Chart(ctx, {
  type: 'radar',
  data: {
    labels: ["能力・スキル", "協調性", "コミュニケーション", "積極性", "モラル", "定着度"],
    datasets: dataSets
    // datasets: [{
    //   label: 'apples',
    //   backgroundColor: "rgba(153,255,51,0.4)",
    //   borderColor: "rgba(153,255,51,1)",
    //   data: [9, 19, 3, 17, 28, 24, 7]
    // }, {
    //   label: 'oranges',
    //   backgroundColor: "rgba(255,153,0,0.4)",
    //   borderColor: "rgba(255,153,0,1)",
    //   data: [30, 29, 5, 5, 20, 3, 10]
    // }]
    },
  options:{
      scale:{
        ticks:{
          beginAtZero: true
        }
      }

  }

});

</script>

</body>
</html>
