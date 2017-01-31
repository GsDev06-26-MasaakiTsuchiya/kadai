<html lang="ja">
<head>
<meta charset="utf-8">
<title>interview_rader_chart > input</title>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="./css/common.css">
</head>
<body>
<?php include("./template/nav.html") ?>
<form class="form-group form-horizontal" action="setting_insert.php" method="post">
  <label for="interviewee_name">候補者名</label><input class="form-control" type="text" name="interviewee_name" value="">
  <label for="interviewee_name_kana">カナ</label><input class="form-control" type="text" name="interviewee_name_kana" value="">
  <label for="interview_date">面接日時</label><input class="form-control" type="datetime-local" name="interview_date" value="">
  <label for="birthday">誕生日</label><input class="form-control" type="date" name="birthday" value="">
  <label for="devision_name">部署名</label><input class="form-control" type="text" name="devision_name" value="">
  <label for="position_name">職種</label><input class="form-control" type="text" name="position_name" value="">
  <label for="position_title">タイトル</label><input class="form-control" type="text" name="position_title" value="">
  <input type="submit" value="設定">
</form>

<?php include("./template/footer.html") ?>

</body>
</html>
