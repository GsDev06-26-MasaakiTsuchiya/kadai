<?php

$user_name =  $_POST["user_name"];
$skill_point_0 = $_POST["skill_point_0"];
$skill_qualitative_0 = $_POST["skill_qualitative_0"];

//データ書き込み
$str = $user_name.",".$skill_point_0.",".$skill_qualitative_0;
$file = fopen("data/data_sample.csv","a");
flock($file, LOCK_EX);
fwrite($file, $str."\n");
flock($file, LOCK_UN);
fclose($file);


//データ読み込み
$csv = fopen("data/data_sample.csv","r");
$dataList = [];
while($array = fgetcsv($csv)){
  array_push($dataList, $array);
}
$json_data = json_encode($dataList);

var_dump($json_data);
 ?>


<html lang="ja">
<head>
<meta charset="utf-8">
<title>output</title>
</head>
<body>
<p id="text"></p>
<script>
//phpからjson形式でデータを受取り、parseする。
var data_s = <?php echo $dataList; ?>;//csvを1行ずつ配列にしてそれをまた配列にいれたものをphpでjsonencodeする。それをjson.parseしたが
console.dir(data_s);
</script>

</body>
</html>
