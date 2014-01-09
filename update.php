<?php

// Alert the user about their environment for all those "help!" requests
passthru('git --version; type git');
$runAgain = false;

chdir(__DIR__);

if(empty($argv[1])) {
	/*
	 * When a unit is no longer needed we need to clear it from the system.
	 * Rather than doing something complex, lets just remove all existing
	 * units and checkout only the ones we need. Makes the compile stage much
	 * easier.
	 *
	 * @todo this wastes bandwidth re-downloading projects over and over
	 */
	foreach(
			new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator('Units', FilesystemIterator::SKIP_DOTS),
				RecursiveIteratorIterator::CHILD_FIRST
			) as $path) {
	    $path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
	}
}

// Starting with us, loop over all existing gists
foreach (array_merge(array('../'), glob("Units/*")) as $directory) {

	chdir(__DIR__ . '/' . $directory);
	is_dir('.git') AND passthru('git pull origin master');

	/**
	 * The Units.md file is a mix of readme + composer.json. We allow notes and 
	 * comments in addition to gist ID's. We autodetect gists that start with
	 * "https://" (vs "http://") and add them as dependencies of this unit. If 
	 * you want to talk about a gist that is not required by your unit then please
	 * use "http://".
	 *
	 * Samples:
	 * 	https://gist.github.com/[integer](.git)
	 * 	https://gist.github.com/[user]/[integer]
	 * 	https://gist.github.com/[hash](.git)
	 * 	https://gist.github.com/[user]/[hash]
	 *
	 * Format to:
	 * 	https://gist.github.com/([hash]|[integer]).git
	 */
	if(is_file('readme.md')) {
		if(preg_match_all('~https://gist.github.com/(?:\w+/)?(\w+)~', file_get_contents('readme.md'), $matches)) {
			foreach($matches[1] as $id) {
				chdir(__DIR__ . '/Units');
				if( ! is_dir($id)) {
					passthru("git clone https://gist.github.com/$id.git");
					$runAgain = true;
				}
			}
		}
	}
}

if($runAgain) {
	passthru("php ".__FILE__ . ' 1');
} else {
	passthru("php " . __DIR__ . '/compile.php');
}