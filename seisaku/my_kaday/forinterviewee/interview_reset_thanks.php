<?php
include("../function/function.php");
$cancel_reason = $_GET["cancel_reason"];
$comment = $_GET["comment"];
?>
ご連絡ありがとうございます。
以下の内容で連絡しました。

<h4>選択理由</h4><?php if($cancel_reason == "not_work"):?>
<div class="">ウェブ面接機能が動作しない。</div>
<?php elseif($cancel_reason == "not_wish"):?>
<div class="">ウェブ面接を希望しない。</div>
<?php elseif($cancel_reason == "not_available"):?>
<div class="">対応可能な日時がない</div>
<?php endif; ?>

<h4>コメント</h4>
<p class=""><?php echo h($comment); ?></p>

<p>
確認の上再度ご連絡いたしますのでしばらくおまちください。
</p>
