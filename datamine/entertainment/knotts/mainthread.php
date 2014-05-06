<?php
$rawpage=file_get_contents("https://www.knotts.com/hours-directions/park-hours");
$startpos=strpos($rawpage,'<div class="calendar">');
$m="";
$t="";
$w="";
$r="";
$f="";
$s="";
$u="";

//<div class="day "
?>