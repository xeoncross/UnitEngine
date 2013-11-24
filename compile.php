<?php

chdir(__DIR__);

$code = '<?php';

foreach (glob("*/*.php") as $file) {
	print $file . "\n";
	$name = basename($file);

	if(strpos($file, 'PHPUnit') !== FALSE) {
		continue;
	}

	if($name == 'UnitTest.php') {
		copy($file, __DIR__ . '/'. $name);
		continue;
	}

	$code .= substr(file_get_contents($file), 5);
}

file_put_contents('UnitEngine.php', $code);
