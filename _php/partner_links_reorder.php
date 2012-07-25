<?php

$text = "";

foreach($_GET['partner_links'] as $key=>$value) {
	$text .= "ID = ".$value."<br />";
	$text .= "Postion = ".$key."<br />";
	$text .= "---------- <br />";
}

$fp = fopen('data.txt', 'w');
fwrite($fp, $text);
fclose($fp);
?>