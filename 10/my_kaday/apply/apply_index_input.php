<?php
session_start();
include("../function/function.php");
login_check();
?>


<html lang="ja">
<head>
<meta charset="utf-8">
<title>interview_rader_chart > input</title>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="../ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="../css/common.css">
<style>
h3{
  margin-bottom:30px;
}
</style>
</head>
<body>

<?php include("../template/nav.php") ?>





<h3 class="text-center">募集サイト情報入力</h3>
<div class="container">
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <form class="form-group form-horizontal" action="apply_index_insert.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label class="control-label col-sm-2" for="corp_name">会社名</label><div class="col-sm-10"><input type="text" class="form-control" name="corp_name" value=""></div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="corp_name_en">会社名アルファベット</label><div class="col-sm-10"><input type="text" class="form-control" name="corp_name_en" value=""></div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="corp_logo_f">会社ロゴ</label>
          <div class="col-sm-5"><input id="up_image" type="file" class="form-control" name="corp_logo_f" accept=“image/*” capture=“camera”></div>
          <div class="col-sm-5"><img id="thumbnail" class="img-responsive" src=""></div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="main_title_text">メインタイトル</label>
          <div class="col-sm-10">
            <textArea id="main_title_text" class="form-control" name="main_title_text" rows="10" cols="80"></textArea>
          </div>
          <script>
          CKEDITOR.replace('main_title_text');
          </script>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="main_lead_text">リードテキスト</label>
          <div class="col-sm-10">
            <textArea id="main_lead_text" class="form-control" name="main_lead_text" rows="10" cols="80"></textArea>
          </div>
          <script>
          CKEDITOR.replace('main_lead_text');
          </script>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="main_photo_f">メイン画像</label>
          <div class="col-sm-5"><input id="up_main_image" type="file" class="form-control" name="main_photo_f" accept=“image/*” capture=“camera”></div>
          <div class="col-sm-5"><img id="main_thumbnail" class="img-responsive" src=""></div>
        </div>

        <div class="text-center">
          <input class="btn btn-default" type="submit" value="登録">
        </div>
      </form>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>
<!-- Main[End] -->
<?php include("../template/footer.html") ?>
</body>
<script>
$('#up_image').change(function(){
  if(this.files.length > 0){
    var file = this.files[0];

    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(){
      $('#thumbnail').attr('src',reader.result);
    }
  }
});
$('#up_main_image').change(function(){
  if(this.files.length > 0){
    var file = this.files[0];
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(){
      $('#main_thumbnail').attr('src',reader.result);
    }
  }
});
</script>
</html>
