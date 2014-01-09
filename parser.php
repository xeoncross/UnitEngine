<?php
/**
 * This is a CLI parser which takes a file path and returns
 * the number of PHP instruction tokens found:
 *
 * 	$ php parser.php [file path]
 */
count($argv) > 1
	OR die("Format: \033[1;31mphp parser.php [file path]\033[0m\n");

$tokens = array_slice(token_get_all(file_get_contents($argv[1])), 1);

$count = 0;
foreach($tokens as $token)
{
	$token = (array) $token;

	/*
	 * No penalty for:
	 *
	 * 	- long names					recursivecallbackfilteriterator()
	 * 	- proper use of brackets		i.e. if(1){foo();} vs if(1)foo();
	 * 	- parentheses					They count(as(function(name())));
	 * 	- whitespace					Spaces, tabs, & newlines are good
	 *	- comments						Remember, tell us *why* not *how*
	 * 	- extending/defining classes	Make something others can extend!
	 * 	- defining functions			You can't really avoid this goal.
	 * 	- using namespaces				Please namespace code for safety!
	 *
	 * Don't write trash, just make it concise.
	 */
	if( ! in_array($token[0], array(
		'{', '}', '(', ')', ';',
		T_WHITESPACE,
		T_COMMENT,T_DOC_COMMENT,
		T_CLASS,T_IMPLEMENTS,T_INTERFACE,T_EXTENDS,T_ABSTRACT,
		T_DOUBLE_COLON,T_OBJECT_OPERATOR,
		//T_OPEN_TAG,T_CLOSE_TAG,
		T_FUNCTION,
		T_NAMESPACE,T_USE,T_NS_SEPARATOR
	))) {
		$count++;
	}
}

/**
 * Anything more than 100 commands long fails
 */
if($count <= 100) {
	print "\033[1;33m$count\033[0m\n";
} else {
	print "\033[1;31m$count\033[0m\n";
}
