<?php

function h($str){
    $str = htmlspecialchars($str,ENT_QUOTES);
    return $str;//関数の外に出す
}

?>
