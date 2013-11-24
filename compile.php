<?php
$code = '<?php';

foreach (glob("*/*.php") as $file) {
	print $file . "\n";
	$code .= substr(file_get_contents($file), 5);
}

file_put_contents('unitengine.php', $code);
