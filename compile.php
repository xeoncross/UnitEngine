<?php

chdir(__DIR__);

$code = '<?php';

foreach (glob("Units/*/*.php") as $file) {
	
	//print $file . "\n";
	$filename = basename($file);
	
	// Do not compile the unit test code
	if(strpos($filename, 'Test') !== FALSE) {
		continue;
	}

	// Ignore lower-case file names (i.e. sample/support files)
	if(preg_match('~[A-Z]~', $filename)) {
		$code .= substr(file_get_contents($file), 5);
	}
}

file_put_contents(__DIR__ . '/UnitEngine.php', $code);
