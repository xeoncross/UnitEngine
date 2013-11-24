<?php

// Alert the user about their environment for all those "help!" requests
passthru('git --version; type git');
$runAgain = false;

// Starting with gvm, loop over all existing gists
foreach (array_merge(array('.'), glob("*/")) as $directory) {

	chdir(__DIR__ . '/' . $directory);
	is_dir('.git') AND passthru('git pull origin master');

	if(is_file('requires.txt')) {

		// Allow notes and comments in addition to gist ID's
		if(preg_match_all('~\d{4,}~', file_get_contents('requires.txt'), $matches)) {
			foreach($matches[0] as $id) {
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
}