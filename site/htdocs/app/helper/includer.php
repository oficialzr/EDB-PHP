<?php
$url = $_SERVER['REQUEST_URI'];
$a = explode("/", $url);
$key = $a[1];


if ($key == 'app') {
	$scr = array("<script src='https://code.jquery.com/jquery-3.6.0.js'></script>", "<script src='https://code.jquery.com/ui/1.13.2/jquery-ui.js'></script>", "<script src='assets/js/tools/sorting.js'></script>");
	$title = ''
} elseif ($key == '') {
	echo '1';
} else {
	echo '2';
}


