<?php
//目标站
$url=$_POST["url"];
$fp = @fopen($url, "r") or die("超时");
$fcontents = file_get_contents($url);
$fcontents= iconv("gbk", "utf-8", $fcontents);
//echo $fcontents;
//preg_match("/^(style|style_)(.*)*/i", $file)
preg_match('/<tbody id="separatorline"(.*)<div id="filter_special_menu" class="p_pop"/si', $fcontents, $regs);
//eregi("<tbody id=\"separatorline\">(.*)<div id=\"filter_special_menu\" class=\"p_pop\"", $fcontents, $regs);
echo $regs[1];
?>
