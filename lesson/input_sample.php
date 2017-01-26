<html lang="ja">
<head>
<meta charset="utf-8">
<title>input_sample</title>
</head>
<body>
  <form method="post" action="output_sample.php">
    <div class="form-group item_name">
      <label for="user_name">user:</label>
      <select name="user_name">
        <option value="maeda">前田</option>
        <option value="takada">高田</option>
        <option value="yamazaki">山崎</option>
        <option value="fujiwara">藤原</option>
        <option value="funaki">船木</option>
        <option value="suzuki">鈴木</option>
      </select>
    </div>
    <div class="form-group item_0">
    <label for="skill_point_0">point</label><input class="form-control" type="number" min="0" max="10" name="skill_point_0">
    </div>
    <div class="form-group item_0">
    <label for="skill_qualitative_0">comment</label><textarea class="form-control" name="skill_qualitative_0"></textarea>
    </div>
    <input type="submit" name="" value="submit">
  </form>
</body>

</html>
