<?php

// Alert the user about their environment for all those "help!" requests
passthru('git --version; type git');
$runAgain = false;

chdir(__DIR__);

// Starting with us, then loop over all existing gists
foreach (array_merge(array('../'), glob("*/")) as $directory) {

	chdir(__DIR__ . '/' . $directory);
	is_dir('.git') AND passthru('git pull origin master');

	if(is_file('units.txt')) {

		/**
		 * Samples:
		 * 	https://gist.github.com/[integer](.git)
		 * 	https://gist.github.com/[user]/[integer]
		 * 	https://gist.github.com/[hash](.git)
		 * 	https://gist.github.com/[user]/[hash]
		 *
		 * Format to:
		 * 	https://gist.github.com/([hash]|[integer]).git
		 */
		// Allow notes and comments in addition to gist ID's
		if(preg_match_all('~://gist.github.com/(?:\w+/)?(\w+)~', file_get_contents('units.txt'), $matches)) {
			foreach($matches[1] as $id) {
				chdir(__DIR__);
				if( ! is_dir($id)) {
					passthru("git clone https://gist.github.com/$id.git");
					$runAgain = true;
				}
			}
		}
	}
}

if($runAgain) {
	passthru("php ".__FILE__);
} else {
	passthru("php " . __DIR__ . '/compile.php');
}